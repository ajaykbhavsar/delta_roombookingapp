<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light-style layout-navbar-fixed layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="/" data-template="vertical-menu-template-free">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="author" content="">

        <title>{{ config('app.name', 'Laravel') }} - Admin Panel</title>

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

        <!-- Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Core CSS -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- CKEditor -->
        <script src="{{ URL('assets/ckeditor/ckeditor.js') }}"></script>

        <style>
            :root {
                --bs-primary: #1f8c82;
                --bs-primary-rgb: 31, 140, 130;
                --bs-secondary: #475569;
                --bs-success: #22c55e;
                --bs-info: #0ea5e9;
                --bs-warning: #f59e0b;
                --bs-danger: #ef4444;
                --bs-light: #f8fafc;
                --bs-dark: #0f172a;
                --booking-surface: #eef6f4;
                --booking-deep: #0a2e36;
                --booking-gradient: linear-gradient(135deg, #1f8c82 0%, #0f766e 55%, #0b4f56 100%);
                --booking-card-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
            }

            body {
                font-family: 'Public Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
                background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 40%, #e4f0ee 100%);
                color: #1f2933;
            }

            a {
                color: var(--bs-primary);
            }

            a:hover {
                color: #13685f;
            }

            .navbar {
                background: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(12px);
                box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
                padding: 1rem 1.5rem;
            }

            .navbar-brand,
            .app-brand-text {
                font-size: 1.25rem;
                font-weight: 600;
                color: var(--bs-primary) !important;
                letter-spacing: 0.02em;
            }

            .layout-menu {
                position: fixed;
                top: 0;
                left: 0;
                bottom: 0;
                width: 260px;
                z-index: 1029;
                background: linear-gradient(180deg, #0f172a 0%, #111f3f 60%, #0c1224 100%);
                color: #cfd8f3;
                box-shadow: 0 20px 60px rgba(12, 18, 36, 0.8);
                transition: transform 0.25s ease;
                overflow-y: auto;
                padding-top: 70px;
            }

            .menu-inner {
                list-style: none;
                padding: 0;
                margin: 0;
            }

            .menu-item {
                margin: 0.25rem 0.625rem;
            }

            .menu-link {
                display: flex;
                align-items: center;
                padding: 0.65rem 1.25rem;
                color: #c6d0f4;
                text-decoration: none;
                border-radius: 0.5rem;
                transition: all 0.2s ease;
                font-weight: 500;
            }

            .menu-icon {
                width: 1.125rem;
                font-size: 1rem;
                margin-right: 0.75rem;
                opacity: 0.9;
            }

            .menu-link:hover {
                background: rgba(255, 255, 255, 0.08);
                color: #ffffff;
                transform: translateX(2px);
            }

            .menu-item.active .menu-link {
                background: var(--booking-gradient);
                box-shadow: 0 10px 20px rgba(31, 140, 130, 0.35);
                color: #ffffff;
            }

            .app-brand {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 1.25rem 1.5rem;
                border-bottom: 1px solid rgba(255, 255, 255, 0.08);
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                background: linear-gradient(90deg, #0f172a 0%, #0c2538 100%);
                z-index: 1030;
                height: 70px;
            }

            #layout-navbar {
                position: fixed;
                top: 0;
                left: 260px;
                right: 0;
                z-index: 1029;
                height: 70px;
            }

            .layout-page {
                margin-left: 260px;
                margin-top: 70px;
                min-height: calc(100vh - 70px);
            }

            .content-wrapper {
                padding: 1.5rem;
            }

            .card {
                background: #ffffff;
                border: 0;
                box-shadow: var(--booking-card-shadow);
                border-radius: 0.85rem;
                margin-bottom: 1.5rem;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            .card:hover {
                transform: translateY(-2px);
                box-shadow: 0 24px 46px rgba(15, 23, 42, 0.12);
            }

            .card-header {
                padding: 1.25rem 1.5rem;
                border-bottom: 1px solid rgba(15, 23, 42, 0.08);
                background: linear-gradient(90deg, rgba(31, 140, 130, 0.12), rgba(15, 118, 110, 0.02));
            }

            .card-header .card-title {
                color: #0f172a;
                font-weight: 600;
                letter-spacing: 0.01em;
            }

            .card-body {
                padding: 1.5rem;
            }

            .btn-primary {
                background: var(--booking-gradient);
                border-color: #0f766e;
                box-shadow: 0 10px 20px rgba(15, 118, 110, 0.35);
            }

            .btn-primary:hover {
                background: linear-gradient(135deg, #1b776f, #0a4e54);
                border-color: #0a4e54;
            }

            .btn-outline-warning {
                color: var(--bs-warning);
                border-color: rgba(245, 158, 11, 0.8);
            }

            .btn-outline-warning:hover {
                background: var(--bs-warning);
                color: #0f172a;
            }

            .form-control:focus,
            .form-select:focus {
                border-color: rgba(31, 140, 130, 0.7);
                box-shadow: 0 0 0 0.25rem rgba(31, 140, 130, 0.15);
            }

            .form-label {
                font-weight: 600;
                color: #0f172a;
            }

            .avatar {
                width: 2.5rem;
                height: 2.5rem;
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .avatar-initial {
                font-weight: 600;
                color: #fff;
            }

            .bg-label-primary {
                background-color: rgba(31, 140, 130, 0.15);
                color: var(--bs-primary);
            }

            .footer {
                background: rgba(255, 255, 255, 0.9);
                padding: 1.5rem;
                border-top: 1px solid rgba(15, 23, 42, 0.08);
                margin-top: auto;
            }

            @media (max-width: 991.98px) {
                .layout-menu {
                    transform: translateX(-100%);
                }

                .layout-menu.show {
                    transform: translateX(0);
                }

                #layout-navbar {
                    left: 0;
                }

                .layout-page {
                    margin-left: 0;
                }

                .layout-overlay {
                    position: fixed;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    background: rgba(0, 0, 0, 0.5);
                    z-index: 1028;
                    display: none;
                }

                .layout-menu.show ~ .layout-overlay {
                    display: block;
                }
            }

            .badge {
                padding: 0.4em 0.7em;
                font-weight: 600;
                letter-spacing: 0.015em;
            }

            .badge.bg-success {
                background: rgba(34, 197, 94, 0.18);
                color: #15803d;
            }

            .badge.bg-info {
                background: rgba(14, 165, 233, 0.18);
                color: #0c4a6e;
            }

            .badge.bg-warning,
            .badge.bg-warning.text-dark {
                background: rgba(245, 158, 11, 0.22);
                color: #92400e !important;
            }

            .badge.bg-danger {
                background: rgba(239, 68, 68, 0.2);
                color: #7f1d1d;
            }

            .table {
                color: #1f2933;
            }

            .table thead th {
                font-weight: 600;
                text-transform: uppercase;
                font-size: 0.72rem;
                letter-spacing: 0.08em;
                color: #94a3b8;
            }

            .table-hover tbody tr:hover {
                background: rgba(31, 140, 130, 0.06);
            }

            .alert {
                border-radius: 0.65rem;
                border: 0;
                box-shadow: 0 10px 20px rgba(15, 23, 42, 0.08);
            }

            .alert-success {
                background: var(--booking-gradient);
                color: #ffffff;
                border: none;
            }

            .alert-success .btn-close {
                filter: brightness(0) invert(1);
            }

            .booking-highlight {
                border-left: 4px solid var(--bs-primary);
                padding-left: 1rem;
            }

            .bg-primary,
            .text-bg-primary,
            .bg-success,
            .text-bg-success {
                background: var(--booking-gradient) !important;
                color: #ffffff !important;
            }

            .badge.bg-primary,
            .badge.bg-success {
                background: rgba(31, 140, 130, 0.25);
                color: var(--bs-primary);
            }
        </style>
    </head>
    <body>
        <!-- Layout wrapper -->
        <div class="layout-wrapper layout-content-navbar">
            <!-- Menu -->
            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand">
                    <a href="{{ route('dashboard') }}" class="app-brand-link">
                        <span class="app-brand-text">{{ config('app.name', 'Laravel') }}</span>
                    </a>
                    <a href="javascript:void(0);" class="layout-menu-toggle d-block d-xl-none">
                        <i class="fa-solid fa-bars"></i>
                    </a>
                </div>

                <ul class="menu-inner">
                    @if(auth()->user()->isAdmin())
                        <!-- Dashboard -->
                        <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <a href="{{ route('dashboard') }}" class="menu-link">
                                <i class="fa-solid fa-house menu-icon"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li class="menu-item {{ request()->routeIs('admin.logs.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.logs.index') }}" class="menu-link">
                                <i class="fa-solid fa-clipboard-list menu-icon"></i>
                                <span>System Logs</span>
                            </a>
                        </li>
                        @php
                          $user = auth()->user();

                        @endphp
                        @if( $user->role=="super_admin")
                        <li class="menu-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.users.index') }}" class="menu-link">
                                <i class="fa-solid fa-users menu-icon"></i>
                                <span>Manage Users</span>
                            </a>
                        </li>
                        @endif

                        <!-- @can('viewAny', \App\Models\Product::class)
                            <li class="menu-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                                <a href="{{ route('admin.products.index') }}" class="menu-link">
                                    <i class="fa-solid fa-box menu-icon"></i>
                                    <span>Manage Products</span>
                                </a>
                            </li>
                        @endcan -->
                        @can('viewAny', \App\Models\Room::class)
                            <li class="menu-item {{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}">
                                <a href="{{ route('admin.rooms.index') }}" class="menu-link">
                                    <i class="fa-solid fa-door-open menu-icon"></i>
                                    <span>Manage Rooms</span>
                                </a>
                            </li>
                        @endcan
                        @can('viewAny', \App\Models\RoomType::class)
                            <li class="menu-item {{ request()->routeIs('admin.room-types.*') ? 'active' : '' }}">
                                <a href="{{ route('admin.room-types.index') }}" class="menu-link">
                                    <i class="fa-solid fa-layer-group menu-icon"></i>
                                    <span>Manage Room Types</span>
                                </a>
                            </li>
                        @endcan
                        @can('viewAny', \App\Models\Booking::class)
                            <li class="menu-item {{ request()->routeIs('bookings.*') ? 'active' : '' }}">
                                <a href="{{ route('bookings.index') }}" class="menu-link">
                                    <i class="fa-solid fa-bed menu-icon"></i>
                                    <span>Room Bookings</span>
                                </a>
                            </li>
                        @endcan

                        <!-- Profile -->
                        <li class="menu-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                            <a href="{{ route('profile.edit') }}" class="menu-link">
                                <i class="fa-solid fa-user menu-icon"></i>
                                <span>Profile</span>
                            </a>
                        </li>
                    @else
                        @can('viewAny', \App\Models\Booking::class)
                            <li class="menu-item {{ request()->routeIs('bookings.*') ? 'active' : '' }}">
                                <a href="{{ route('bookings.index') }}" class="menu-link">
                                    <i class="fa-solid fa-bed menu-icon"></i>
                                    <span>Room Bookings</span>
                                </a>
                            </li>
                        @endcan
                        <li class="menu-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                            <a href="{{ route('profile.edit') }}" class="menu-link">
                                <i class="fa-solid fa-user menu-icon"></i>
                                <span>Profile</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                <nav class="navbar navbar-expand-xl navbar-detached align-items-center" id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="fa-solid fa-bars"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-nav-right">
                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                                <!-- User -->
                                <li class="nav-item navbar-dropdown dropdown dropdown-user">
                                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                        <div class="avatar avatar-online">
                                            <span class="avatar-initial rounded-circle bg-label-primary">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                        </div>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar avatar-online">
                                                            <span class="avatar-initial rounded-circle bg-label-primary">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <span class="fw-semibold d-block">{{ Auth::user()->name }}</span>
                                                        <small class="text-muted">{{ Auth::user()->email }}</small>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="dropdown-divider"></div>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                                <i class="fa-solid fa-user me-2"></i>
                                                <span class="align-middle">My Profile</span>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="dropdown-divider"></div>
                                        </li>
                                        <li>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                                    <i class="fa-solid fa-right-from-bracket me-2"></i>
                                                    <span class="align-middle">Log Out</span>
                                                </a>
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                                <!--/ User -->
                        </ul>
                    </div>
                </nav>
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper d-flex flex-column" style="min-height: calc(100vh - 70px);">
                    <!-- Content -->
                    <div class="flex-grow-1">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        {{ $slot }}
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    <footer class="footer mt-auto">
                        <div class="d-flex flex-wrap justify-content-between py-2">
                            <div>
                                © <script>document.write(new Date().getFullYear())</script>,</span>  {{ config('app.name', 'Laravel') }}
                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->

            <!-- Overlay -->
            <div class="layout-overlay"></div>
        </div>
        <!-- / Layout wrapper -->

        <script>
            // Toggle menu for mobile
            document.querySelectorAll('.layout-menu-toggle').forEach(toggle => {
                toggle.addEventListener('click', function() {
                    document.getElementById('layout-menu').classList.toggle('show');
                });
            });

            // Close menu when clicking overlay
            document.querySelector('.layout-overlay')?.addEventListener('click', function() {
                document.getElementById('layout-menu').classList.remove('show');
            });
        </script>
    </body>
</html>

