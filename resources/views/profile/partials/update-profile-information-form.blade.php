
    <section class="border border-start p-3 border-bottom py-4 border-danger">
        <header>
            <h2 class="text-lg font-medium text-gray-900 text-center fw-bold">
                Profile Information
            </h2>
    
            <p class="mt-1 text-sm text-gray-600 text-center">
                Update your account's profile information and email address.
            </p>
        </header>
        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>
    
        <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
            @csrf
            @method('patch')
            <div class="mt-3">
                <label for="name" class="form-label fw-bold">Name</label>
                <input id="name" name="name" type="text" class="form-control mt-1 border-dark" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                @if ($errors->has('name'))
                    <div class="mt-2 text-danger">
                        {{ implode(', ', $errors->get('name')) }}
                    </div>
                @endif
            </div>
            <div class="mt-3">
                    <label for="email" class="form-label fw-bold">Email</label>
                    <input id="email" name="email" type="email" class="form-control mt-1 border-dark" value="{{ old('email', $user->email) }}" required autocomplete="username">
                    @if ($errors->has('email'))
                        <div class="mt-2 text-danger">
                            {{ implode(', ', $errors->get('email')) }}
                        </div>
                    @endif    
                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                        <div>
                            <p class="text-muted mt-2">
                                <span class="text-danger">Your email address is unverified.</span>
    
                                <button form="send-verification" class="btn btn-link text-decoration-none text-primary">
                                    Click here to re-send the verification email
                                </button>
                            </p>
                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 fw-bold text-sm text-success">
                                    <span class="fw-bold">A new verification link has been sent to your email address</span>
                                </p>
                            @endif
                        </div>
                    @endif
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-light btn-outline-info text-dark fw-bold d-flex ms-auto">Save</button>
                @if (session('status') === 'profile-updated')
                    <p class="text-muted text-sm p-0 m-0" id="status-message" style="display: none;">Saved Successfully</p>
                @endif
            </div>
            
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const statusMessage = document.getElementById('status-message');
                    if (statusMessage) {
                        statusMessage.style.display = 'block';
                        setTimeout(() => {
                            statusMessage.style.display = 'none';
                        }, 2000);
                    }
                });
            </script>
        </form>
    </section>

