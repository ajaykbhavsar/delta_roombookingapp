<x-sneat-admin-layout>
    <div class="card mb-4">
        <div class="card-header">
            <h4 class="card-title mb-0">Room Type Details</h4>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="text-muted small">Name</label>
                    <p class="mb-0"><strong>{{ $roomType->name }}</strong></p>
                </div>
                <div class="col-md-6">
                    <label class="text-muted small">Status</label>
                    <p class="mb-0">
                        @if($roomType->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </p>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-12">
                    <label class="text-muted small">Description</label>
                    <p class="mb-0">{{ $roomType->description ?? '—' }}</p>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="text-muted small">Base Rate</label>
                    <p class="mb-0">INR {{ number_format($roomType->base_rate, 2) }}</p>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="text-muted small">Created Date</label>
                    <p class="mb-0">{{ $roomType->created_at->format('M d, Y H:i:s') }}</p>
                </div>
                <div class="col-md-6">
                    <label class="text-muted small">Updated Date</label>
                    <p class="mb-0">{{ $roomType->updated_at->format('M d, Y H:i:s') }}</p>
                </div>
            </div>

            <div class="d-flex gap-2">
                @can('update', $roomType)
                    <a href="{{ route('admin.room-types.edit', $roomType) }}" class="btn btn-primary">
                        <i class="fa-solid fa-edit me-2"></i>Edit
                    </a>
                @endcan
                <a href="{{ route('admin.room-types.index') }}" class="btn btn-outline-secondary">
                    <i class="fa-solid fa-arrow-left me-2"></i>Back to List
                </a>
            </div>
        </div>
    </div>
</x-sneat-admin-layout>


