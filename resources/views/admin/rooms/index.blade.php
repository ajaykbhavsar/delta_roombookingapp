<x-sneat-admin-layout>
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Room Management</h4>
            @can('create', \App\Models\Room::class)
                <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary">
                    <i class="fa-solid fa-plus me-2"></i>Create New Room
                </a>
            @endcan
        </div>
        <div class="card-body">
            @if($rooms->isEmpty())
                <div class="text-center py-5">
                    <i class="fa-solid fa-door-open fa-3x text-muted mb-3"></i>
                    <h5 class="mb-2">No rooms found</h5>
                    <p class="text-muted mb-4">Add a room to get started.</p>
                    @can('create', \App\Models\Room::class)
                        <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary">
                            <i class="fa-solid fa-plus me-2"></i>Create New Room
                        </a>
                    @endcan
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Room No.</th>
                                <th>Location</th>
                                <th>Room Type</th>
                                <th>Base Rate</th>
                                <th>Occupancy</th>
                                <th>Housekeeping Status</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rooms as $room)
                                <tr>
                                    <td><strong>{{ $room->room_no }}</strong></td>
                                    <td>
                                        @if($room->location)
                                            <strong>{{ $room->location->name }}</strong>
                                            <span class="text-muted d-block small">{{ $room->location->location_id }}</span>
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td>{{ $room->roomType->name ?? '—' }}</td>
                                    <td>Rs {{ number_format($room->base_rate, 2) }}</td>
                                    <td>
                                        {{ \App\Models\Booking::OCCUPANCY_STATUS_OPTIONS[$room->occupancy_status] ?? \Illuminate\Support\Str::headline($room->occupancy_status) }}
                                    </td>
                                     <td>{{ $room->room_status ?? '—' }}</td>
                                    <td>
                                        @if($room->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $room->created_at->format('M d, Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.rooms.show', $room) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            @can('update', $room)
                                                <a href="{{ route('admin.rooms.edit', $room) }}" class="btn btn-sm btn-outline-info">
                                                    <i class="fa-solid fa-edit"></i>
                                                </a>
                                            @endcan
                                            @can('delete', $room)
                                                <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this room?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-sneat-admin-layout>







