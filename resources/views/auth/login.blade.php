<div class="modal fade" id="loginModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="loginModalLabel"
    aria-hidden="true">
    <div class="modal-dialog position-absolute top-0 end-0" style="width: 370px; margin-top:5.7%; margin-right:10%;">
        <div class="modal-content">
            <div class="modal-header position-relative justify-content-center align-items-center border-0"
                style="height: 80px;">
                <!-- Centered Icon -->
                <div class="position-absolute top-50 start-50 translate-middle">
                    <i id="loginKeyholeIcon" class="fas fa-lock icon locked"></i>
                </div>
            </div>
            <div class="text-center">
                <h1 class="h5 fw-bold">Login Now</h1>
            </div>

            <x-auth-session-status class="mx-3 mt-2" :status="session('status')" />
            <div class="modal-body pt-0">
                <!-- LOGIN FORM -->
                <form method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf

                    <!-- Email -->
                    <div class="mb-3">
                        <x-input-label for="login_email" :value="__('Email')" class="form-label fw-bold" />
                        <x-text-input id="login_email" type="email" name="email" class="form-control"
                            :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="text-danger mt-1" />
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <x-input-label for="login_password" :value="__('Password')" class="form-label fw-bold" />
                        <x-text-input id="login_password" type="password" name="password" class="form-control" required
                            autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="text-danger mt-1" />
                    </div>

                    <!-- Remember Me -->
                    <div class="form-check mb-3">
                        <input class="form-check-input border border-1 border-dark p-1" type="checkbox" name="remember"
                            id="login_remember_me">
                        <label class="form-check-label fw-bold" for="login_remember_me">
                            {{ __('Remember me') }}
                        </label>
                    </div>

                    <!-- Actions -->
                    <div>
                        @if (Route::has('password.request'))
                            <a class="text-decoration-none fw-bold small" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <button type="button" class="btn btn-outline-danger me-4"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-success">Log In</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('loginForm').addEventListener('submit', function() {
        const icon = document.getElementById('loginKeyholeIcon');
        if (icon.classList.contains('fa-lock')) {
            icon.classList.remove('fa-lock', 'locked');
            icon.classList.add('fa-unlock', 'unlocked');
        } else {
            icon.classList.remove('fa-unlock', 'unlocked');
            icon.classList.add('fa-lock', 'locked');
        }
    });
</script>
