<x-sneat-admin-layout>
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">Room Type Management</h4>
            @can('create', \App\Models\RoomType::class)
                <a href="{{ route('admin.room-types.create') }}" class="btn btn-primary">
                    <i class="fa-solid fa-plus me-2"></i>Create Room Type
                </a>
            @endcan
        </div>
        <div class="card-body">
            @if($roomTypes->isEmpty())
                <div class="text-center py-5">
                    <i class="fa-solid fa-layer-group fa-3x text-muted mb-3"></i>
                    <h5 class="mb-2">No room types found</h5>
                    <p class="text-muted mb-4">Add your first room type to get started.</p>
                    @can('create', \App\Models\RoomType::class)
                        <a href="{{ route('admin.room-types.create') }}" class="btn btn-primary">
                            <i class="fa-solid fa-plus me-2"></i>Create Room Type
                        </a>
                    @endcan
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Base Rate</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roomTypes as $roomType)
                                <tr>
                                    <td><strong>{{ $roomType->name }}</strong></td>
                                    <td>{{ $roomType->description ?? '—' }}</td>
                                    <td>INR {{ number_format($roomType->base_rate, 2) }}</td>
                                    <td>
                                        @if($roomType->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $roomType->created_at->format('M d, Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.room-types.show', $roomType) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            @can('update', $roomType)
                                                <a href="{{ route('admin.room-types.edit', $roomType) }}" class="btn btn-sm btn-outline-info">
                                                    <i class="fa-solid fa-edit"></i>
                                                </a>
                                            @endcan
                                            @can('delete', $roomType)
                                                <form action="{{ route('admin.room-types.destroy', $roomType) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this room type?');">
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


