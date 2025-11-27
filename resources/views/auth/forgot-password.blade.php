<x-guest-layout>
    <h4 class="auth-title mb-3">Forgot Password?</h4>
    <p class="text-muted mb-4">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </p>

    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-success mb-4" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" required autofocus>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-paper-plane me-2"></i>{{ __('Email Password Reset Link') }}
            </button>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="text-decoration-none">
                <i class="fa-solid fa-arrow-left me-1"></i>Back to login
            </a>
        </div>
    </form>
</x-guest-layout>
