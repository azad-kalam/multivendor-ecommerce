<div class="modal fade" id="registerModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="registerModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
        style="width: 370px; margin-top:5.7%; margin-right:10%;">
        <div class="modal-content">
            <div class="modal-header position-relative justify-content-center align-items-center border-0"
                style="height: 80px;">
                <!-- Centered Icon -->
                <div class="position-absolute top-50 start-50 translate-middle">
                    <i id="registerKeyholeIcon" class="fas fa-lock icon locked"></i>
                </div>
            </div>
            <div class="text-center">
                <h1 class="h5 fw-bold">Register Now</h1>
            </div>

            <div class="modal-body pt-0" style="scroll-behavior: smooth; scrollbar-width: thin;">
                <!-- REGISTER FORM -->
                <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Name -->
                    <div class="mb-3">
                        <x-input-label for="register_name" class="fw-bold">
                            {{ __('Name:') }} <span class="text-danger">*</span>
                        </x-input-label>

                        <x-text-input id="register_name" class="form-control" type="text" name="name"
                            :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="text-danger mt-1" />
                    </div>

                    {{-- Profile Image --}}
                    @include('partials.global_file.register_file')

                    <!-- Email -->
                    <div class="mb-3">
                        <x-input-label for="register_email" class="fw-bold">
                            {{ __('Email:') }} <span class="text-danger">*</span>
                        </x-input-label>

                        <x-text-input id="register_email" class="form-control" type="email" name="email"
                            :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="text-danger mt-1" />
                    </div>

                    <!-- Phone -->
                    <div class="mb-3">
                        <x-input-label for="register_phone" class="fw-bold">
                            {{ __('Phone:') }} <span class="text-danger">*</span>
                        </x-input-label>

                        <x-text-input id="register_phone" class="form-control" type="tel" name="phone"
                            :value="old('phone')" pattern="[0-9]*" required autocomplete="tel" />
                        <x-input-error :messages="$errors->get('phone')" class="text-danger mt-1" />
                    </div>

                    {{-- About --}}
                    <div class="mb-3">
                        <x-input-label for="about" class="fw-bold" :value="__('About:')" />
                        <textarea id="about" class="form-control" name="about" rows="3">{{ old('about') }}</textarea>
                    </div>

                    {{-- Company --}}
                    <div class="mb-3">
                        <x-input-label for="company" class="fw-bold" :value="__('Company:')" />
                        <x-text-input id="company" class="form-control" type="text" name="company"
                            :value="old('company')" />
                    </div>

                    {{-- Job --}}
                    <div class="mb-3">
                        <x-input-label for="job" class="fw-bold" :value="__('Job:')" />
                        <x-text-input id="job" class="form-control" type="text" name="job"
                            :value="old('job')" />
                    </div>

                    {{-- Country --}}
                    <div class="mb-3">
                        <x-input-label for="country" class="fw-bold" :value="__('Country:')" />
                        <x-text-input id="country" class="form-control" type="text" name="country"
                            :value="old('country')" />
                    </div>

                    {{-- Address --}}
                    <div class="mb-3">
                        <x-input-label for="address" class="fw-bold" :value="__('Address:')" />

                        <textarea id="address" class="form-control" name="address" rows="3">{{ old('address') }}</textarea>
                    </div>

                    {{-- Social Links --}}
                    <div class="mb-3">
                        <x-input-label for="twitter" class="fw-bold" :value="__('Twitter:')" />
                        <x-text-input id="twitter" class="form-control" type="url" name="twitter"
                            :value="old('twitter')" />
                    </div>

                    <div class="mb-3">
                        <x-input-label for="facebook" class="fw-bold" :value="__('Facebook:')" />
                        <x-text-input id="facebook" class="form-control" type="url" name="facebook"
                            :value="old('facebook')" />
                    </div>

                    <div class="mb-3">
                        <x-input-label for="instagram" class="fw-bold" :value="__('Instagram:')" />
                        <x-text-input id="instagram" class="form-control" type="url" name="instagram"
                            :value="old('instagram')" />
                    </div>

                    <div class="mb-3">
                        <x-input-label for="linkedin" class="fw-bold" :value="__('LinkedIn:')" />
                        <x-text-input id="linkedin" class="form-control" type="url" name="linkedin"
                            :value="old('linkedin')" />
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <x-input-label for="register_password" class="fw-bold">
                            {{ __('Password:') }} <span class="text-danger">*</span>
                        </x-input-label>

                        <x-text-input id="register_password" class="form-control" type="password" name="password"
                            required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="text-danger mt-1" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-3">
                        <x-input-label for="register_password_confirmation" class="fw-bold">
                            {{ __('Confirm Password:') }} <span class="text-danger">*</span>
                        </x-input-label>

                        <x-text-input id="register_password_confirmation" class="form-control" type="password"
                            name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="text-danger mt-1" />
                    </div>

                    <!-- Remember Me -->
                    <div class="form-check mb-3">
                        <input class="form-check-input border border-1 border-dark p-1" type="checkbox"
                            name="remember" id="register_remember_me">
                        <label class="form-check-label fw-bold" for="register_remember_me">
                            {{ __('Remember me') }}
                        </label>
                    </div>

                    <!-- Actions -->
                    <div>
                        <a class="text-decoration-underline fw-bold small text-secondary hover:text-dark"
                            href="{{ route('login') }}">
                            {{ __('Already registered?') }}
                        </a>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <button type="button" class="btn btn-outline-danger me-3" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-outline-success">
                            {{ __('Register') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('registerForm').addEventListener('submit', function() {
        const icon = document.getElementById('registerKeyholeIcon');
        if (icon.classList.contains('fa-lock')) {
            icon.classList.remove('fa-lock', 'locked');
            icon.classList.add('fa-unlock', 'unlocked');
        } else {
            icon.classList.remove('fa-unlock', 'unlocked');
            icon.classList.add('fa-lock', 'locked');
        }
    });
</script>
