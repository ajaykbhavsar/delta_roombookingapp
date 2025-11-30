<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Booking;
use App\Models\SystemLog;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function __construct()
    {

        $this->authorizeResource(Room::class, 'room');
    }

    public function index()
    {

        $rooms = Room::latest()->get();
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
        $roomStatusOptions = Booking::ROOM_STATUS_OPTIONS;
        return view('admin.rooms.create', compact('roomStatusOptions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_no' => 'required|string|max:50|unique:rooms,room_no',
            'location' => 'nullable|string',
            'room_status'=>'nullable|string',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $room = Room::create([
            'room_no' => $validated['room_no'],
            'location' => $validated['location'] ?? null,
            'description' => $validated['description'] ?? null,
            'room_status' => $validated['room_status'] ?? null,
            'is_active' => $request->has('is_active') ? true : false,
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
        return view('admin.rooms.show', compact('room'));
    }

    public function edit(Room $room)
    {
        if (!in_array(auth()->user()->role, ['super_admin', 'admin'])) {
            abort(403, 'Unauthorized');
        }
        $roomStatusOptions = Booking::ROOM_STATUS_OPTIONS;
        return view('admin.rooms.edit', compact('room','roomStatusOptions'));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'room_no' => 'required|string|max:50|unique:rooms,room_no,' . $room->id,
            'description' => 'nullable|string',
            'room_status'=>'nullable|string',
            'location' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $room->update([
            'room_no' => $validated['room_no'],
            'location' => $validated['location'] ?? null,
            'description' => $validated['description'] ?? null,
            'room_status' => $validated['room_status'] ?? null,
            'is_active' => $request->has('is_active') ? true : false,
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
}





