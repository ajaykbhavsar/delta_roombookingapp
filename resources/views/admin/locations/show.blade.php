<x-sneat-admin-layout>
    <div class="card mb-4">
        <div class="card-header">
            <h4 class="card-title mb-0">Location Details</h4>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="text-muted small">Unique ID</label>
                    <p class="mb-0"><code class="fs-6">{{ $location->unique_id }}</code></p>
                </div>
                <div class="col-md-6">
                    <label class="text-muted small">Location ID</label>
                    <p class="mb-0"><code class="fs-6">{{ $location->location_id ?? '—' }}</code></p>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="text-muted small">Status</label>
                    <p class="mb-0">
                        @if($location->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </p>
                </div>
                <div class="col-md-6">
                    <label class="text-muted small">Location Name</label>
                    <p class="mb-0"><strong>{{ $location->name }}</strong></p>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="text-muted small">Created Date</label>
                    <p class="mb-0">{{ $location->created_at->format('M d, Y H:i:s') }}</p>
                </div>
                <div class="col-md-6">
                    <label class="text-muted small">Updated Date</label>
                    <p class="mb-0">{{ $location->updated_at->format('M d, Y H:i:s') }}</p>
                </div>
            </div>

            <div class="d-flex gap-2">
                @can('update', $location)
                    <a href="{{ route('admin.locations.edit', $location) }}" class="btn btn-primary">
                        <i class="fa-solid fa-edit me-2"></i>Edit
                    </a>
                @endcan
                <a href="{{ route('admin.locations.index') }}" class="btn btn-outline-secondary">
                    <i class="fa-solid fa-arrow-left me-2"></i>Back to List
                </a>
            </div>
        </div>
    </div>
</x-sneat-admin-layout>


