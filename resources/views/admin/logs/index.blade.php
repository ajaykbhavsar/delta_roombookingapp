<x-sneat-admin-layout>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">System Logs</h4>
            <span class="text-muted small">Tracking changes across Users & Products</span>
        </div>
        <div class="card-body">
            @if($logs->isEmpty())
                <div class="text-center py-5">
                    <i class="fa-solid fa-clipboard-list fa-3x text-muted mb-3"></i>
                    <h5 class="mb-2">No log entries yet</h5>
                    <p class="text-muted mb-0">Once changes are made to users or products, they will appear here.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Summary</th>
                                <th>Performed By</th>
                                <th>Details</th>
                                <th>Recorded At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($logs as $log)
                                <tr>
                                    <td>
                                        <span class="badge bg-primary text-uppercase">{{ str_replace('_', ' ', $log->action) }}</span>
                                    </td>
                                    <td>{{ data_get($log->payload, 'summary', '—') }}</td>
                                    <td>
                                        @if($log->performedBy)
                                            <div>{{ $log->performedBy->name }}</div>
                                            <small class="text-muted">{{ $log->performedBy->email }}</small>
                                        @else
                                            <span class="text-muted">System</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $details = collect($log->payload ?? [])->except('summary');
                                        @endphp
                                        @if($details->isEmpty())
                                            <span class="text-muted">—</span>
                                        @else
                                            <ul class="list-unstyled mb-0 small">
                                                @foreach($details as $key => $value)
                                                    <li><strong>{{ \Illuminate\Support\Str::title(str_replace('_', ' ', $key)) }}:</strong> {{ is_scalar($value) ? $value : json_encode($value) }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </td>
                                    <td>{{ $log->created_at->format('M d, Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $logs->links() }}
                </div>
            @endif
        </div>
    </div>
</x-sneat-admin-layout>

