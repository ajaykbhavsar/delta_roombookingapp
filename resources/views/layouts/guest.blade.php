<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light-style customizer-hide" dir="ltr" data-theme="theme-default">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - {{ isset($title) ? $title : 'Authentication' }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

        <!-- Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Core CSS -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --auth-primary: #1f8c82;
                --auth-secondary: #0f172a;
                --auth-gradient: linear-gradient(135deg, #1f8c82 0%, #0f766e 55%, #0b4f56 100%);
                --auth-surface: #f8fafc;
                --auth-card-shadow: 0 24px 48px rgba(15, 23, 42, 0.18);
            }

            body {
                font-family: 'Public Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
                background: radial-gradient(circle at top left, rgba(31, 140, 130, 0.22), transparent 55%), linear-gradient(180deg, #e2f1ef 0%, #eef6f4 45%, #f8fafc 100%);
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 100vh;
                color: #0f172a;
                padding: 2rem;
            }

            .auth-container-wrapper {
                width: 100%;
                max-width: 1040px;
                display: flex;
                align-items: stretch;
                justify-content: center;
                background: #ffffff;
                border-radius: 1.5rem;
                box-shadow: var(--auth-card-shadow);
                overflow: hidden;
            }

            .auth-container {
                width: 100%;
                max-width: 440px;
                padding: 3rem;
            }

            .auth-hero {
                flex: 1;
                background: var(--auth-gradient);
                color: #ecfdf5;
                padding: 3rem;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
            }

            .auth-hero h2 {
                font-size: 2rem;
                font-weight: 700;
                margin-bottom: 1rem;
            }

            .auth-hero p {
                font-size: 1rem;
                color: rgba(255, 255, 255, 0.8);
            }

            .auth-logo {
                margin-bottom: 2rem;
            }

            .auth-logo-text {
                font-size: 1.75rem;
                font-weight: 700;
                color: var(--auth-primary);
            }

            .auth-title {
                font-weight: 700;
                color: #0f172a;
            }

            .form-label {
                font-weight: 600;
                color: #0f172a;
                margin-bottom: 0.35rem;
            }

            .form-control {
                border: 1px solid rgba(15, 23, 42, 0.1);
                border-radius: 0.75rem;
                padding: 0.75rem 0.95rem;
                color: #0f172a;
                background: #fff;
            }

            .form-control:focus {
                border-color: rgba(31, 140, 130, 0.7);
                box-shadow: 0 0 0 0.2rem rgba(31, 140, 130, 0.15);
            }

            .btn-primary {
                background: var(--auth-gradient);
                border: 0;
                font-weight: 600;
                padding: 0.8rem 1.25rem;
                border-radius: 0.85rem;
                box-shadow: 0 12px 24px rgba(31, 140, 130, 0.35);
            }

            .btn-primary:hover {
                background: linear-gradient(135deg, #1b776f, #0a4e54);
            }

            a {
                color: var(--auth-primary);
            }

            a:hover {
                color: #13685f;
            }

            @media (max-width: 992px) {
                .auth-container-wrapper {
                    flex-direction: column;
                }

                .auth-hero {
                    order: -1;
                }
            }

            @media (max-width: 576px) {
                body {
                    padding: 1rem;
                }

                .auth-container {
                    padding: 2rem 1.5rem;
                }

                .auth-hero {
                    padding: 2rem 1.5rem;
                }
            }
        </style>
    </head>
    <body>
        <div class="auth-container-wrapper">
            <div class="auth-hero">
                <div>
                    <h2>Room Booking Application</h2>
                    <p>Streamline reservations, monitor occupancy, and keep guests delighted—all from a single modern workspace.</p>
                </div>
                <div>
                    <p class="mb-1">Need help?</p>
                    <strong>support@roomapp.local</strong>
                </div>
            </div>
            <div class="auth-container">
                <div class="auth-logo">
                    <div class="auth-logo-text">{{ config('app.name', 'Laravel') }}</div>
                </div>

                {{ $slot }}
            </div>
        </div>
    </body>
</html>

