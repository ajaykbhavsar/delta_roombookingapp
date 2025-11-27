<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
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
        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('admin.rooms.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_no' => 'required|string|max:50|unique:rooms,room_no',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $room = Room::create([
            'room_no' => $validated['room_no'],
            'description' => $validated['description'] ?? null,
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
        return view('admin.rooms.show', compact('room'));
    }

    public function edit(Room $room)
    {
        return view('admin.rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'room_no' => 'required|string|max:50|unique:rooms,room_no,' . $room->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $room->update([
            'room_no' => $validated['room_no'],
            'description' => $validated['description'] ?? null,
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

