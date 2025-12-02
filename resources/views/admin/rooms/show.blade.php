<x-sneat-admin-layout>
    <div class="card mb-4">
        <div class="card-header">
            <h4 class="card-title mb-0">Room Details</h4>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="text-muted small">Room Number</label>
                    <p class="mb-0"><strong>{{ $room->room_no }}</strong></p>
                </div>
                <div class="col-md-6">
                    <label class="text-muted small">Status</label>
                    <p class="mb-0">
                        @if($room->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </p>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="text-muted small">Location</label>
                    <p class="mb-0">
                        @if($room->location)
                            <strong>{{ $room->location->name }}</strong>
                            <span class="text-muted">(ID: {{ $room->location->location_id }})</span>
                        @else
                            —
                        @endif
                    </p>
                </div>
                <div class="col-md-6">
                    <label class="text-muted small">Room Type</label>
                    <p class="mb-0">{{ $room->roomType->name ?? '—' }}</p>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-12">
                    <label class="text-muted small">Description</label>
                    <p class="mb-0">{{ $room->description ?? '—' }}</p>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="text-muted small">Housekeeping Status</label>
                    <p class="mb-0">{{ $room->room_status ?? '—' }}</p>
                </div>
                <div class="col-md-6">
                    <label class="text-muted small">Occupancy Status</label>
                    <p class="mb-0">{{ \App\Models\Booking::OCCUPANCY_STATUS_OPTIONS[$room->occupancy_status] ?? \Illuminate\Support\Str::headline($room->occupancy_status) }}</p>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="text-muted small">Base Rate</label>
                    <p class="mb-0">Rs {{ number_format($room->base_rate, 2) }}</p>
                </div>

            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="text-muted small">Created Date</label>
                    <p class="mb-0">{{ $room->created_at->format('M d, Y H:i:s') }}</p>
                </div>
                <div class="col-md-6">
                    <label class="text-muted small">Updated Date</label>
                    <p class="mb-0">{{ $room->updated_at->format('M d, Y H:i:s') }}</p>
                </div>
            </div>

            <div class="d-flex gap-2">
                @can('update', $room)
                    <a href="{{ route('admin.rooms.edit', $room) }}" class="btn btn-primary">
                        <i class="fa-solid fa-edit me-2"></i>Edit
                    </a>
                @endcan
                <a href="{{ route('admin.rooms.index') }}" class="btn btn-outline-secondary">
                    <i class="fa-solid fa-arrow-left me-2"></i>Back to List
                </a>
            </div>
        </div>
    </div>
</x-sneat-admin-layout>






