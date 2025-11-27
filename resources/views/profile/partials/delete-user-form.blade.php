<section>
    <header class="mb-4">
        <h5 class="mb-2">{{ __('Delete Account') }}</h5>
        <p class="text-muted small mb-0">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button type="button" class="btn btn-danger"
            x-data=""
            x-on:click="$dispatch('open-modal', 'confirm-user-deletion')">
        <i class="fa-solid fa-trash me-2"></i>{{ __('Delete Account') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-4">
            @csrf
            @method('delete')

            <h5 class="mb-3">
                {{ __('Are you sure you want to delete your account?') }}
            </h5>

            <p class="text-muted small mb-4">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mb-4">
                <label for="password" class="form-label sr-only">{{ __('Password') }}</label>
                <input type="password" id="password" name="password"
                       class="form-control {{ $errors->userDeletion->has('password') ? 'is-invalid' : '' }}"
                       placeholder="{{ __('Password') }}">
                @if($errors->userDeletion->has('password'))
                    <div class="invalid-feedback">{{ $errors->userDeletion->first('password') }}</div>
                @endif
            </div>

            <div class="d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-secondary" x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </button>
                <button type="submit" class="btn btn-danger">
                    <i class="fa-solid fa-trash me-2"></i>{{ __('Delete Account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
