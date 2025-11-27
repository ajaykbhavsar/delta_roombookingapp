<x-sneat-admin-layout>

    <div class="row">
        <div class="col-12">

            <!-- Dashboard Card -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header border-bottom">
                    <h4 class="card-title mb-0">
                        Welcome, {{ auth()->user()->name }}!
                    </h4>
                </div>

                <div class="card-body">

                    {{-- Status Message --}}
                    <p class="text-muted">{{ __("You're logged in!") }}</p>

                    {{-- User Role Section --}}
                    @php
                        $roleName = auth()->user()->role ?? 'user';
                        $badgeClass = match ($roleName) {
                            'super_admin' => 'bg-primary',
                            'admin' => 'bg-danger',
                            default => 'bg-success',
                        };

                        $user = auth()->user();

                        $filter = $user->role === 'user'
                            ? ['created_by' => $user->id]
                            : [];

                        $counts = [
                            'pending'      => App\Models\Booking::where($filter)->where('booking_status', 'pending')->count(),
                            'confirmed'    => App\Models\Booking::where($filter)->where('booking_status', 'confirmed')->count(),
                            'cancelled'    => App\Models\Booking::where($filter)->where('booking_status', 'cancelled')->count(),
                            'checked_in'   => App\Models\Booking::where($filter)->where('booking_status', 'checked_in')->count(),
                            'checked_out'  => App\Models\Booking::where($filter)->where('booking_status', 'checked_out')->count(),
                        ];
                    @endphp

                    <p class="mb-4">
                        <strong>Role:</strong>
                        <span class="badge {{ $badgeClass }} px-3 py-2">
                            {{ \Illuminate\Support\Str::headline($roleName) }}
                        </span>
                    </p>

                    {{-- Admin Buttons --}}
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.logs.index') }}" class="btn btn-primary">
                                <i class="fa-solid fa-clipboard-list me-2"></i>View Logs
                            </a>
                            @if( $user->role=="super_admin")
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary">
                                <i class="fa-solid fa-users me-2"></i>Manage Users
                            </a>
                            @endif
                        @endif
                        @if(auth()->user()=='user')
                        @can('create', \App\Models\Booking::class)
                            <a href="{{ route('bookings.create') }}" class="btn btn-primary text-white">
                                <i class="fa-solid fa-paper-plane me-2"></i>New Booking
                            </a>
                        @endcan
                        @endif
                    </div>

                    {{-- Booking Status Cards for Normal Users --}}

                    <div class="row g-3">

                        @foreach([
                            'pending' => 'Pending',
                            'confirmed' => 'Confirmed',
                            'cancelled' => 'Cancelled',
                            'checked_in' => 'Checked In',
                            'checked_out' => 'Checked Out',
                        ] as $key => $label)

                        <div class="col-6 col-sm-4 col-md-2">
                        <a href="{{ route('bookings.index') }}?booking_status={{ $key }}"
                        class="text-decoration-none">
                        <div class="card bg-primary text-white text-center shadow-sm border-0 p-3 status-box">
                        <h6 class="mb-1">{{ $label }}</h6>
                        <h3 class="fw-bold">{{ $counts[$key] }}</h3>
                        </div>
                        </a>
                        </div>

                        @endforeach

                    </div>


                </div>
            </div>
            <!-- /Dashboard Card -->

        </div>
    </div>

</x-sneat-admin-layout>
