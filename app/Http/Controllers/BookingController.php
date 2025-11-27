<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Models\Booking;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\SystemLog;
use Carbon\Carbon;
use Throwable;
use Illuminate\Http\Request;

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
        $rooms = $this->activeRooms();
        $roomTypes = $this->activeRoomTypes();

        if ($rooms->isEmpty() || $roomTypes->isEmpty()) {
            return redirect()
                ->route('bookings.index')
                ->with('error', 'Please create at least one active room and room type before creating bookings.');
        }

        return view('bookings.create', array_merge($this->formOptions(), [
            'rooms' => $rooms,
            'roomTypes' => $roomTypes,
        ]));
    }

    public function store(StoreBookingRequest $request)
    {
        $room = $this->activeRoomsQuery()->findOrFail($request->input('room_id'));
        $roomType = $this->activeRoomTypesQuery()->findOrFail($request->input('room_type_id'));

        $payload = $request->validated();
        $payload['room_rate'] = $roomType->base_rate;
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

    public function edit(Booking $booking)
    {
        $rooms = $this->activeRooms();
        $roomTypes = $this->activeRoomTypes();

        $booking->load(['room', 'roomType']);

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
        ]));
    }

    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        $room = $this->activeRoomsQuery()->findOrFail($request->input('room_id'));
        $roomType = $this->activeRoomTypesQuery()->findOrFail($request->input('room_type_id'));

        $payload = $request->validated();
        $payload['room_rate'] = $roomType->base_rate;
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

        return redirect()
            ->route('bookings.show', $booking)
            ->with('success', 'Room booking updated successfully.');
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
}


