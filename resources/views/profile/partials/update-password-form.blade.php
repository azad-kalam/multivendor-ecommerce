<section class="border border-start p-3 border-bottom py-4 border-danger">
    <header>
        <h2 class="text-lg font-medium text-gray-900 text-center fw-bold">Update Password</h2>

        <p class="mt-1 text-sm text-gray-600 text-center">
            Ensure your account is using a long, random password to stay secure.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')
        <div class="mt-3">
            <label for="update_password_current_password" class="form-label fw-bold">Current Password</label>
            <input id="update_password_current_password" name="current_password" type="password" class="form-control border-dark" autocomplete="current-password" />
            
            @if ($errors->updatePassword->get('current_password'))
                <div class="text-danger">
                    {{ $errors->updatePassword->get('current_password')[0] }}
                </div>
            @endif
        </div>
        
        <div class="mt-3">
            <label for="update_password_password" class="form-label fw-bold">New Password</label>
            <input type="password" id="update_password_password" name="password"  class="form-control border-dark" autocomplete="new-password" />  
            @if ($errors->updatePassword->get('password'))
                <div class="text-danger mt-2">
                    {{ $errors->updatePassword->get('password')[0] }}
                </div>
            @endif
        </div>
        <div class="mt-3">
            <label for="update_password_password_confirmation" class="form-label fw-bold">Confirm Password</label>
            <input type="password" id="update_password_password_confirmation" name="password_confirmation" class="form-control border-dark" autocomplete="new-password" />
            @if ($errors->updatePassword->get('password_confirmation'))
                <div class="text-danger">
                    {{ $errors->updatePassword->get('password_confirmation')[0] }}
                </div>
            @endif
        </div>
        
        <div class="d-flex items-center gap-4">
            <x-primary-button class="ms-auto">{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
