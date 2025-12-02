<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\SystemLog;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Location::class, 'location');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locations = Location::latest()->get();

        return view('admin.locations.index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.locations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'location_id' => 'required|string|max:50|unique:locations,location_id',
            'name' => 'required|string|max:255|unique:locations,name',
            'is_active' => 'boolean',
        ]);

        $location = Location::create([
            'location_id' => $validated['location_id'],
            'name' => $validated['name'],
            'is_active' => $request->boolean('is_active'),
        ]);

        SystemLog::record('location_created', [
            'summary' => "Created location {$location->name}",
            'location_id' => $location->id,
        ]);

        return redirect()->route('admin.locations.index')
            ->with('success', 'Location created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Location $location)
    {
        return view('admin.locations.show', compact('location'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Location $location)
    {
        return view('admin.locations.edit', compact('location'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Location $location)
    {
        $validated = $request->validate([
            'location_id' => 'required|string|max:50|unique:locations,location_id,' . $location->id,
            'name' => 'required|string|max:255|unique:locations,name,' . $location->id,
            'is_active' => 'boolean',
        ]);

        $location->update([
            'location_id' => $validated['location_id'],
            'name' => $validated['name'],
            'is_active' => $request->boolean('is_active'),
        ]);

        SystemLog::record('location_updated', [
            'summary' => "Updated location {$location->name}",
            'location_id' => $location->id,
        ]);

        return redirect()->route('admin.locations.index')
            ->with('success', 'Location updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(Location $location)
{
    // Check if location is used in rooms or bookings
    if ($location->rooms()->exists() || $location->bookings()->exists()) {
        return redirect()->route('admin.locations.index')
            ->with('error', 'Cannot delete location. It is currently in use by rooms or bookings.');
    }

    $location->delete();

    SystemLog::record('location_deleted', [
        'summary' => "Deleted location {$location->name}",
        'location_id' => $location->id,
    ]);

    return redirect()->route('admin.locations.index')
        ->with('success', 'Location deleted successfully.');
}
}


