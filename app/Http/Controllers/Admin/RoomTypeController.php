<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoomType;
use App\Models\SystemLog;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    public function __construct()
    {
        // $this->authorizeResource(RoomType::class, 'roomType');
    }

    public function index()
    {
        if (!in_array(auth()->user()->role, ['super_admin', 'admin'])) {
            abort(403, 'Unauthorized');
        }
        $roomTypes = RoomType::latest()->get();
        return view('admin.room-types.index', compact('roomTypes'));
    }

    public function create()
    {
        if (!in_array(auth()->user()->role, ['super_admin', 'admin'])) {
            abort(403, 'Unauthorized');
        }
        return view('admin.room-types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:room_types,name',
            'description' => 'nullable|string',
            // 'base_rate' => 'required|numeric|min:0|max:999999.99',
            'is_active' => 'boolean',
        ]);

        $roomType = RoomType::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            // 'base_rate' => $validated['base_rate'],
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        SystemLog::record('room_type_created', [
            'summary' => "Created room type {$roomType->name}",
            'room_type_id' => $roomType->id,
        ]);

        return redirect()->route('admin.room-types.index')
            ->with('success', 'Room type created successfully.');
    }

    public function show(RoomType $roomType)
    {
        if (!in_array(auth()->user()->role, ['super_admin', 'admin'])) {
            abort(403, 'Unauthorized');
        }
        return view('admin.room-types.show', compact('roomType'));
    }

    public function edit(RoomType $roomType)
    {
        if (!in_array(auth()->user()->role, ['super_admin', 'admin'])) {
            abort(403, 'Unauthorized');
        }
        return view('admin.room-types.edit', compact('roomType'));
    }

    public function update(Request $request, RoomType $roomType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:room_types,name,' . $roomType->id,
            'description' => 'nullable|string',
            // 'base_rate' => 'required|numeric|min:0|max:999999.99',
            'is_active' => 'boolean',
        ]);

        $roomType->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            // 'base_rate' => $validated['base_rate'],
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        SystemLog::record('room_type_updated', [
            'summary' => "Updated room type {$roomType->name}",
            'room_type_id' => $roomType->id,
        ]);

        return redirect()->route('admin.room-types.index')
            ->with('success', 'Room type updated successfully.');
    }


public function destroy(RoomType $roomType)
{
    if (!in_array(auth()->user()->role, ['super_admin', 'admin'])) {
        abort(403, 'Unauthorized');
    }

    // Check if room type is used in rooms
    if ($roomType->rooms()->exists()) {
        return redirect()->route('admin.room-types.index')
            ->with('error', 'Cannot delete room type. It is currently in use by rooms.');
    }

    $typeName = $roomType->name;
    $typeId = $roomType->id;

    $roomType->delete();

    SystemLog::record('room_type_deleted', [
        'summary' => "Deleted room type {$typeName}",
        'room_type_id' => $typeId,
    ]);

    return redirect()->route('admin.room-types.index')
        ->with('success', 'Room type deleted successfully.');
}
}

