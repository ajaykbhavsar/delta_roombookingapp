<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Mail\BookingStatusMail;
use App\Models\Booking;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\SystemLog;
use App\Models\Location;
use Carbon\Carbon;
use Throwable;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(Booking::class, 'booking');
    }

    public function index(Request $request)
    {
        $filters = $request->only([
            'search',
            'room_id',
            'room_type_id',
            'booking_status',
            'payment_status',
            'payment_type',
            'check_in_from',
            'check_in_to',
        ]);

        $bookings = Booking::with(['room', 'roomType', 'creator'])
            ->visibleTo($request->user());

        if ($search = trim((string) ($filters['search'] ?? ''))) {
            $bookings->where(function ($query) use ($search) {
                $query->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('phone_number', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('reference_no', 'like', "%{$search}%");
            });
        }

        if (! empty($filters['room_id'])) {
            $bookings->where('room_id', $filters['room_id']);
        }

        if (! empty($filters['room_type_id'])) {
            $bookings->where('room_type_id', $filters['room_type_id']);
        }

        if (! empty($filters['booking_status'])) {
            $bookings->where('booking_status', $filters['booking_status']);
        }

        if (! empty($filters['payment_status'])) {
            $bookings->where('payment_status', $filters['payment_status']);
        }

        if (! empty($filters['payment_type'])) {
            $bookings->where('payment_type', $filters['payment_type']);
        }

        if ($fromDate = $this->parseDate($filters['check_in_from'] ?? null)) {
            $bookings->whereDate('check_in_at', '>=', $fromDate);
        }

        if ($toDate = $this->parseDate($filters['check_in_to'] ?? null)) {
            $bookings->whereDate('check_in_at', '<=', $toDate);
        }

        $bookings = $bookings
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('bookings.index', array_merge($this->formOptions(), [
            'bookings' => $bookings,
            'filters' => $filters,
            'rooms' => $this->activeRooms(),
            'roomTypes' => $this->activeRoomTypes(),
        ]));
    }

    public function create()
    {
        // Show all active rooms initially - filtering will happen via JavaScript when dates are selected
        $rooms = $this->activeRooms();
        $roomTypes = $this->activeRoomTypes();
        $locations= Location::where('is_active','=',1)->get();

        if ($rooms->isEmpty() || $roomTypes->isEmpty()) {
            return redirect()
                ->route('bookings.index')
                ->with('error', 'Please create at least one active room and room type before creating bookings.');
        }

        return view('bookings.create', array_merge($this->formOptions(), [
            'rooms' => $rooms,
            'roomTypes' => $roomTypes,
            'locations'=>$locations,
        ]));
    }

    public function store(StoreBookingRequest $request)
    {
        $room = $this->activeRoomsQuery()->findOrFail($request->input('room_id'));
        $roomType = $this->activeRoomTypesQuery()->findOrFail($request->input('room_type_id'));

        $payload = $request->validated();
        $checkInAt = Carbon::parse($payload['check_in_at']);
        $checkOutAt = Carbon::parse($payload['check_out_at']);

        $this->ensureRoomIsAvailable($room->id, $checkInAt, $checkOutAt);

        $payload['room_rate'] = $room->base_rate;
        $payload['discount'] = (float) ($payload['discount'] ?? 0);
        $payload['service_charges'] = (float) ($payload['service_charges'] ?? 0);
        $payload['total_amount'] = max(
            0,
            ($payload['room_rate'] - $payload['discount']) + $payload['service_charges']
        );
        $payload['reference_no'] = Booking::generateReference();
        $payload['created_by'] = $request->user()->id;
        $payload['is_repeat_customer'] = (bool) $payload['is_repeat_customer'];

      

        $booking = Booking::create($payload);

        SystemLog::record('booking_created', [
            'summary' => "Created booking {$booking->reference_no}",
            'booking_id' => $booking->id,
            'room_id' => $room->id,
            'room_type_id' => $roomType->id,
        ]);

       $booking_status= $payload['booking_status'];
        // Send pending booking email
        $this->sendBookingStatusEmail($booking, $booking_status);

        return redirect()
            ->route('bookings.show', $booking)
            ->with('success', 'Room booking created successfully.');
    }

    public function show(Booking $booking)
    {
        return view('bookings.show', array_merge($this->formOptions(), [
            'booking' => $booking->load(['room', 'roomType', 'creator']),
        ]));
    }

    public function getAvailableRooms(Request $request)
{
    $checkInAt = $this->parseDate($request->input('check_in_at'));
    $checkOutAt = $this->parseDate($request->input('check_out_at'));
    $roomTypeId = $request->input('room_type_id'); // fix: don't parse as date
    $locationId=$request->input('location_id');
    $excludeBookingId = $request->input('exclude_booking_id') ? (int) $request->input('exclude_booking_id') : null;

    $rooms = $this->availableRooms($excludeBookingId, $checkInAt, $checkOutAt, $roomTypeId ,$locationId);

    return response()->json([
        'rooms' => $rooms->map(function ($room) {
            return [
                'id' => $room->id,
                'room_no' => $room->room_no,
                'base_rate'=>$room->base_rate
            ];
        })->values(),
    ]);
}

public function getRooms(Request $request)
{
    $roomTypeId = $request->input('room_type_id');

    if (!$roomTypeId) {
        return response()->json(['rooms' => []]);
    }

    // Fetch rooms ONLY by room_type_id
    $rooms = Room::where('room_type_id', $roomTypeId)
        ->where('is_active', 1)  // optional: only active rooms
        ->select('id', 'room_no')
        ->get();

    return response()->json([
        'rooms' => $rooms
    ]);
}


    public function edit(Booking $booking)
    {
        // Get available rooms based on booking dates, but exclude the current booking from the occupied check
        $rooms = $this->availableRooms(
            $booking->id,
            $booking->check_in_at,
            $booking->check_out_at
        );
        $roomTypes = $this->activeRoomTypes();
         $locations= Location::where('is_active','=',1)->get();

        $booking->load(['room', 'roomType']);

        // Always include the current booking's room even if it's occupied
        if ($booking->room && ! $rooms->contains('id', $booking->room_id)) {
            $rooms->push($booking->room);
            $rooms = $rooms->unique('id')->sortBy('room_no')->values();
        }

        if ($booking->roomType && ! $roomTypes->contains('id', $booking->room_type_id)) {
            $roomTypes->push($booking->roomType);
            $roomTypes = $roomTypes->unique('id')->sortBy('name')->values();
        }

        return view('bookings.edit', array_merge($this->formOptions(), [
            'booking' => $booking,
            'rooms' => $rooms,
            'roomTypes' => $roomTypes,
            'locations'=>$locations,
        ]));
    }

    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        $room = $this->activeRoomsQuery()->findOrFail($request->input('room_id'));
        $roomType = $this->activeRoomTypesQuery()->findOrFail($request->input('room_type_id'));

        $payload = $request->validated();


        $checkInAt = Carbon::parse($payload['check_in_at']);
        $checkOutAt = Carbon::parse($payload['check_out_at']);

        $this->ensureRoomIsAvailable($room->id, $checkInAt, $checkOutAt, $booking->id);

        $payload['room_rate'] =  $room->base_rate;
        $payload['discount'] = (float) ($payload['discount'] ?? 0);
        $payload['service_charges'] = (float) ($payload['service_charges'] ?? 0);
        $payload['total_amount'] = max(
            0,
            ($payload['room_rate'] - $payload['discount']) + $payload['service_charges']
        );
        $payload['is_repeat_customer'] = (bool) $payload['is_repeat_customer'];

       
        $booking->update($payload);

        SystemLog::record('booking_updated', [
            'summary' => "Updated booking {$booking->reference_no}",
            'booking_id' => $booking->id,
            'room_id' => $room->id,
            'room_type_id' => $roomType->id,
        ]);

           if($request->input('booking_status_change') != '1'){
            return redirect()
            ->route('bookings.show', $booking)
            ->with('success', 'Room booking updated successfully.');
           }else{
             $booking_status= $payload['booking_status'];
        // Send pending booking email
        $this->sendBookingStatusEmail($booking, $booking_status);
        return redirect()
            ->route('bookings.show', $booking)
            ->with('success', 'Room booking updated successfully.');
           }


        
    }

    /**
     * Send booking status email
     */
    protected function sendBookingStatusEmail(Booking $booking, string $status): void
    {
        try {
            Mail::to($booking->email)->send(new BookingStatusMail($booking, $status));
        } catch (\Exception $e) {
            \Log::error("Failed to send booking email: {$e->getMessage()}", [
                'booking_id' => $booking->id,
                'status' => $status,
            ]);
        }
    }

    /**
     * Update booking status and send email
     */
    public function updateBookingStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'booking_status' => 'required|in:pending,confirmed,checked_in,checkout,checked_out,cancelled',
        ]);

        $oldStatus = $booking->booking_status;
        $newStatus = $request->input('booking_status');

        $booking->update(['booking_status' => $newStatus]);

        SystemLog::record('booking_status_updated', [
            'summary' => "Updated booking {$booking->reference_no} from {$oldStatus} to {$newStatus}",
            'booking_id' => $booking->id,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
        ]);

        // Send status email
        $this->sendBookingStatusEmail($booking, $newStatus);

        return redirect()
            ->route('bookings.show', $booking)
            ->with('success', "Booking status updated to {$newStatus} and email sent.");
    }

    /**
     * Confirm booking
     */
    public function confirmBooking(Booking $booking)
    {
        $booking->update(['booking_status' => 'confirmed']);

        SystemLog::record('booking_confirmed', [
            'summary' => "Confirmed booking {$booking->reference_no}",
            'booking_id' => $booking->id,
        ]);

        $this->sendBookingStatusEmail($booking, 'confirmed');

        return redirect()
            ->route('bookings.show', $booking)
            ->with('success', 'Booking confirmed and confirmation email sent.');
    }

    /**
     * Check-in booking
     */
    public function checkInBooking(Booking $booking)
    {
        $booking->update(['booking_status' => 'checked_in']);

        SystemLog::record('booking_checked_in', [
            'summary' => "Checked in booking {$booking->reference_no}",
            'booking_id' => $booking->id,
        ]);

        $this->sendBookingStatusEmail($booking, 'checked_in');

        return redirect()
            ->route('bookings.show', $booking)
            ->with('success', 'Guest checked in and welcome email sent.');
    }

    /**
     * Send checkout reminder
     */
    public function sendCheckoutReminder(Booking $booking)
    {
        $this->sendBookingStatusEmail($booking, 'checkout');

        SystemLog::record('checkout_reminder_sent', [
            'summary' => "Sent checkout reminder for booking {$booking->reference_no}",
            'booking_id' => $booking->id,
        ]);

        return redirect()
            ->route('bookings.show', $booking)
            ->with('success', 'Checkout reminder email sent.');
    }

    /**
     * Check-out booking
     */
    public function checkOutBooking(Booking $booking)
    {
        $booking->update(['booking_status' => 'checked_out']);

        SystemLog::record('booking_checked_out', [
            'summary' => "Checked out booking {$booking->reference_no}",
            'booking_id' => $booking->id,
        ]);

        $this->sendBookingStatusEmail($booking, 'checked_out');

        return redirect()
            ->route('bookings.show', $booking)
            ->with('success', 'Guest checked out and thank you email sent.');
    }

    protected function formOptions(): array
    {
        return [
            'idProofOptions' => Booking::ID_PROOF_TYPES,
            'roomStatusOptions' => Booking::ROOM_STATUS_OPTIONS,
            'occupancyStatusOptions' => Booking::OCCUPANCY_STATUS_OPTIONS,
            'bookingTypeOptions' => Booking::BOOKING_TYPE_OPTIONS,
            'paymentTypeOptions' => Booking::PAYMENT_TYPE_OPTIONS,
            'paymentStatusOptions' => Booking::PAYMENT_STATUS_OPTIONS,
            'bookingStatusOptions' => Booking::BOOKING_STATUS_OPTIONS,
            'locationOptions' => Booking::LOCATION_OPTIONS,
        ];
    }

    protected function activeRooms()
    {
        return $this->activeRoomsQuery()->orderBy('room_no')->get();
    }

    protected function availableRooms(?int $excludeBookingId = null, ?Carbon $checkInAt = null, ?Carbon $checkOutAt = null, ?int $roomTypeId = null ,int $locationId =null)
{
    // Get room IDs that are occupied or have overlapping bookings
    $occupiedRoomIds = Booking::query()
        ->whereNotIn('booking_status', ['cancelled', 'checked_out'])
        ->when($checkInAt && $checkOutAt, function ($query) use ($checkInAt, $checkOutAt) {
            $query->where(function ($q) use ($checkInAt, $checkOutAt) {
                $q->where('check_in_at', '<', $checkOutAt)
                  ->where('check_out_at', '>', $checkInAt);
            });
        }, function ($query) {
            $now = Carbon::now();
            $query->where(function ($q) use ($now) {
                $q->whereNotIn('booking_status', ['cancelled', 'checked_out'])
                // $q->where('occupancy_status', 'occupied')
                  ->orWhere(function ($subQ) use ($now) {
                      $subQ->whereIn('booking_status', ['confirmed', 'checked_in', 'pending'])
                           ->where('check_in_at', '<=', $now)
                           ->where('check_out_at', '>=', $now);
                  });
            });
        })
        ->when($excludeBookingId, function ($query) use ($excludeBookingId) {
            $query->where('id', '!=', $excludeBookingId);
        })
        ->pluck('room_id')
        ->unique();

    // Get all active rooms excluding occupied ones
    $query = $this->activeRoomsQuery()
        ->whereNotIn('id', $occupiedRoomIds)
        ->orderBy('room_no');

    // Filter by room type if provided
    if ($roomTypeId) {
        $query->where('room_type_id', $roomTypeId);
    }

    // Filter by room type if provided
    if ($locationId) {
        $query->where('location_id', $locationId);
    }

    return $query->get();
}

    protected function ensureRoomIsAvailable(int $roomId, Carbon $checkInAt, Carbon $checkOutAt, ?int $ignoreBookingId = null): void
    {
        $hasOverlap = Booking::query()
            ->where('room_id', $roomId)
            ->whereNotIn('booking_status', ['cancelled', 'checked_out'])
            ->when($ignoreBookingId, fn ($query) => $query->where('id', '!=', $ignoreBookingId))
            ->where(function ($query) use ($checkInAt, $checkOutAt) {
                $query->where('check_in_at', '<', $checkOutAt)
                    ->where('check_out_at', '>', $checkInAt);
            })
            ->exists();

        if ($hasOverlap) {
            throw ValidationException::withMessages([
                'room_id' => 'The selected room is already booked for the chosen dates.',
            ]);
        }
    }

    protected function activeRoomTypes()
    {
        return $this->activeRoomTypesQuery()->orderBy('name')->get();
    }

    protected function activeRoomsQuery()
    {
        return Room::query()->where('is_active', true);
    }

    protected function activeRoomTypesQuery()
    {
        return RoomType::query()->where('is_active', true);
    }

    protected function parseDate(?string $value): ?Carbon
    {
        if (empty($value)) {
            return null;
        }

        try {
            return Carbon::parse($value);
        } catch (Throwable) {
            return null;
        }
    }

    public function getRoomDetails($id)
    {
        $room = Room::with(['location', 'roomType'])->find($id);

        if (!$room) {
            return response()->json([
                'error' => 'Room not found'
            ], 404);
        }

        return response()->json([
            'room_status' => $room->room_status,
            'occupancy_status' => $room->occupancy_status,
            'base_rate' => $room->base_rate,
            'location' => $room->location?->name,
            'location_id' => $room->location?->location_id,
            'room_type' => $room->roomType?->name,
        ]);
    }

    public function getRoomTypes($location_id)
{
    $types = Room::where('location_id', $location_id)
                 ->select('room_type_id')
                 ->distinct()
                 ->with('type') // Assuming relation roomType()
                 ->get();

    return response()->json($types);
}

}


