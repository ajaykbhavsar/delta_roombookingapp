<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Location;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\SystemLog;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class RoomController extends Controller
{
    public function __construct()
    {

        $this->authorizeResource(Room::class, 'room');
    }

    public function index()
    {

        $rooms = Room::with(['location', 'roomType'])
            ->orderBy(
                Location::select('name')
                    ->whereColumn('locations.id', 'rooms.location_id')
            )
            ->orderBy(
                RoomType::select('name')
                    ->whereColumn('room_types.id', 'rooms.room_type_id')
            )
            ->orderBy('rooms.room_no')
            ->get();


        if (!in_array(auth()->user()->role, ['super_admin', 'admin'])) {
            abort(403, 'Unauthorized');
        }
        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        if (!in_array(auth()->user()->role, ['super_admin', 'admin'])) {
            abort(403, 'Unauthorized');
        }
        $roomStatusOptions = $this->roomStatusOptions();
        $occupancyStatusOptions = Booking::OCCUPANCY_STATUS_OPTIONS;
        $locations = Location::where('is_active', true)->orderBy('name')->get();
        $roomTypes = RoomType::where('is_active', true)->orderBy('name')->get();

        if ($locations->isEmpty() || $roomTypes->isEmpty()) {
            return redirect()->route('admin.rooms.index')
                ->with('error', 'Please create at least one active location and room type before creating rooms.');
        }

        return view('admin.rooms.create', compact(
            'roomStatusOptions',
            'occupancyStatusOptions',
            'locations',
            'roomTypes'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_no' => [
                'required',
                'string',
                'max:50',
                $this->uniqueRoomNumberRule($request),
            ],
            'location_id' => 'required|exists:locations,id',
            'room_type_id' => 'required|exists:room_types,id',
            'description' => 'nullable|string',
            'room_status' => ['required', Rule::in($this->roomStatusOptionKeys())],
            'occupancy_status' => ['required', Rule::in(array_keys(Booking::OCCUPANCY_STATUS_OPTIONS))],
            'base_rate' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $room = Room::create([
            'room_no' => $validated['room_no'],
            'location_id' => $validated['location_id'],
            'room_type_id' => $validated['room_type_id'],
            'description' => $validated['description'] ?? null,
            'room_status' => $validated['room_status'],
            'occupancy_status' => $validated['occupancy_status'],
            'base_rate' => $validated['base_rate'],
            'is_active' => $request->boolean('is_active'),
        ]);

        SystemLog::record('room_created', [
            'summary' => "Created room {$room->room_no}",
            'room_id' => $room->id,
        ]);

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Room created successfully.');
    }

    public function show(Room $room)
    {
        if (!in_array(auth()->user()->role, ['super_admin', 'admin'])) {
            abort(403, 'Unauthorized');
        }
        $room->load(['location', 'roomType']);

        return view('admin.rooms.show', compact('room'));
    }

    public function edit(Room $room)
    {
        if (!in_array(auth()->user()->role, ['super_admin', 'admin'])) {
            abort(403, 'Unauthorized');
        }
        $roomStatusOptions = $this->roomStatusOptions();
        $occupancyStatusOptions = Booking::OCCUPANCY_STATUS_OPTIONS;
        $locations = Location::where('is_active', true)->orderBy('name')->get();
        $roomTypes = RoomType::where('is_active', true)->orderBy('name')->get();

        if ($room->location && $locations->doesntContain('id', $room->location_id)) {
            $locations->push($room->location);
            $locations = $locations->sortBy('name')->values();
        }

        if ($room->roomType && $roomTypes->doesntContain('id', $room->room_type_id)) {
            $roomTypes->push($room->roomType);
            $roomTypes = $roomTypes->sortBy('name')->values();
        }

        return view('admin.rooms.edit', compact(
            'room',
            'roomStatusOptions',
            'occupancyStatusOptions',
            'locations',
            'roomTypes'
        ));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'room_no' => [
                'required',
                'string',
                'max:50',
                $this->uniqueRoomNumberRule($request, $room->id),
            ],
            'location_id' => 'required|exists:locations,id',
            'room_type_id' => 'required|exists:room_types,id',
            'description' => 'nullable|string',
            'room_status' => ['required', Rule::in($this->roomStatusOptionKeys())],
            'occupancy_status' => ['required', Rule::in(array_keys(Booking::OCCUPANCY_STATUS_OPTIONS))],
            'base_rate' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $room->update([
            'room_no' => $validated['room_no'],
            'location_id' => $validated['location_id'],
            'room_type_id' => $validated['room_type_id'],
            'description' => $validated['description'] ?? null,
            'room_status' => $validated['room_status'],
            'occupancy_status' => $validated['occupancy_status'],
            'base_rate' => $validated['base_rate'],
            'is_active' => $request->boolean('is_active'),
        ]);

        SystemLog::record('room_updated', [
            'summary' => "Updated room {$room->room_no}",
            'room_id' => $room->id,
        ]);

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Room updated successfully.');
    }

 
public function destroy(Room $room)
{
    if (!in_array(auth()->user()->role, ['super_admin', 'admin'])) {
        abort(403, 'Unauthorized');
    }

    // Check if room has active bookings
    if ($room->bookings()->exists()) {
        return redirect()->route('admin.rooms.index')
            ->with('error', 'Cannot delete room with existing bookings.');
    }

    $roomNumber = $room->room_no;
    $roomId = $room->id;

    $room->delete();

    SystemLog::record('room_deleted', [
        'summary' => "Deleted room {$roomNumber}",
        'room_id' => $roomId,
    ]);

    return redirect()->route('admin.rooms.index')
        ->with('success', 'Room deleted successfully.');
}

    protected function roomStatusOptions(): array
    {
        return collect(Booking::ROOM_STATUS_OPTIONS)
            ->reject(fn ($_, $key) => $key === '')
            ->toArray();
    }

    protected function roomStatusOptionKeys(): array
    {
        return array_keys($this->roomStatusOptions());
    }

    protected function uniqueRoomNumberRule(Request $request, ?int $ignoreId = null): Unique
    {
        $rule = Rule::unique('rooms')
            ->where(fn ($query) => $query
                ->where('location_id', $request->input('location_id'))
                ->where('room_type_id', $request->input('room_type_id'))
            );

        if ($ignoreId) {
            $rule->ignore($ignoreId);
        }

        return $rule;
    }
}





