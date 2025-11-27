<x-sneat-admin-layout>
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">User Management</h4>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-plus me-2"></i>Create New User
            </a>
        </div>
        <div class="card-body">
            @if($users->isEmpty())
                <div class="text-center py-5">
                    <i class="fa-solid fa-users fa-3x text-muted mb-3"></i>
                    <h5 class="mb-2">No users</h5>
                    <p class="text-muted mb-4">Get started by creating a new user.</p>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                        <i class="fa-solid fa-plus me-2"></i>Create New User
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        <strong>{{ $user->name }}</strong>
                                        @if($user->id === auth()->id())
                                            <span class="badge bg-info ms-2">You</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @php
                                            $roleName = $user->role ?? 'user';
                                            $badgeClass = match ($roleName) {
                                                'super_admin' => 'bg-primary',
                                                'admin' => 'bg-danger',
                                                default => 'bg-success',
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ \Illuminate\Support\Str::headline($roleName) }}</span>
                                    </td>
                                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-info">
                                                <i class="fa-solid fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                @csrf
                                                @method('DELETE')
                                                @if(auth()->user()->isSuperAdmin() && $user->id !== auth()->id())
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete user">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                                @endif
                                            </form>
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

