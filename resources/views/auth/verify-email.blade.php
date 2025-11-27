<x-guest-layout>
    <h4 class="auth-title mb-3">Verify Your Email</h4>
    <p class="text-muted mb-4">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </p>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success mb-4" role="alert">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="d-flex flex-column gap-3">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-envelope me-2"></i>{{ __('Resend Verification Email') }}
                </button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <div class="d-grid">
                <button type="submit" class="btn btn-outline-secondary">
                    <i class="fa-solid fa-sign-out-alt me-2"></i>{{ __('Log Out') }}
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
