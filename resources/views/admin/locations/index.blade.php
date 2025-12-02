<x-sneat-admin-layout>
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Location Management</h4>
            @can('create', \App\Models\Location::class)
            <a href="{{ route('admin.locations.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-plus me-2"></i>Create New Location
            </a>
            @endcan
        </div>
        <div class="card-body">
            @if($locations->isEmpty())
                <div class="text-center py-5">
                    <i class="fa-solid fa-location-dot fa-3x text-muted mb-3"></i>
                    <h5 class="mb-2">No locations</h5>
                    <p class="text-muted mb-4">Get started by creating a new location.</p>
                    @can('create', \App\Models\Location::class)
                    <a href="{{ route('admin.locations.create') }}" class="btn btn-primary">
                        <i class="fa-solid fa-plus me-2"></i>Create New Location
                    </a>
                    @endcan
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Unique ID</th>
                                <th>Location ID</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Created Date</th>
                                <th>Updated Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($locations as $location)
                                <tr>
                                    <td>{{ $location->unique_id }}</td>
                                    <td>{{ $location->location_id ?? '—' }}</td>
                                    <td><strong>{{ $location->name }}</strong></td>
                                    <td>
                                        @if($location->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $location->created_at->format('M d, Y H:i') }}</td>
                                    <td>{{ $location->updated_at->format('M d, Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.locations.show', $location) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            @can('update', $location)
                                            <a href="{{ route('admin.locations.edit', $location) }}" class="btn btn-sm btn-outline-info">
                                                <i class="fa-solid fa-edit"></i>
                                            </a>
                                            @endcan
                                            @can('delete', $location)
                                            <form action="{{ route('admin.locations.destroy', $location) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this location?');">
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


