<x-sneat-admin-layout>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">User Details</h4>
        </div>
        <div class="card-body">
            <div class="mb-4">
                <h3 class="h4 mb-2">{{ $user->name }}</h3>
                <p class="text-muted mb-2">
                    Email: {{ $user->email }} |
                    Role:
                    @php
                        $roleName = $user->role ?? 'user';
                        $badgeClass = match ($roleName) {
                            'super_admin' => 'bg-primary',
                            'admin' => 'bg-danger',
                            default => 'bg-success',
                        };
                    @endphp
                    <span class="badge {{ $badgeClass }}">{{ \Illuminate\Support\Str::headline($roleName) }}</span>
                </p>
                <p class="text-muted mb-0">
                    Created: {{ $user->created_at->format('M d, Y H:i') }}
                </p>
            </div>

            <div class="mb-4">
                <h5 class="mb-3">Recent Activity</h5>
                @if($recentLogs->isNotEmpty())
                    <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                        <table class="table table-sm table-hover">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th>Action</th>
                                    <th>Summary</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentLogs as $log)
                                    <tr>
                                        <td><span class="badge bg-primary text-uppercase">{{ str_replace('_', ' ', $log->action) }}</span></td>
                                        <td>{{ data_get($log->payload, 'summary', '—') }}</td>
                                        <td>{{ $log->created_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">No recent actions recorded for this user.</p>
                @endif
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
                    <i class="fa-solid fa-edit me-2"></i>Edit
                </a>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                    <i class="fa-solid fa-arrow-left me-2"></i>Back to List
                </a>
            </div>
        </div>
    </div>
</x-sneat-admin-layout>
