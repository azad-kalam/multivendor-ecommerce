<ul class="dropdown-menu" aria-labelledby="userDropdownToggle" id="userDropdownMenu">
    @guest
        <!-- Guest User -->
        @if (Route::has('register'))
            <li class="mt-0">
                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#registerModal">
                    <i class="fas fa-user-plus me-1"></i> Registration
                </a>
            </li>
        @endif

        @if (Route::has('login'))
            <li class="mt-0">
                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">
                    <i class="fas fa-sign-in-alt fa-flip-horizontal me-2"></i> Login
                </a>
            </li>
        @endif
    @endguest

    @auth
        @php
            $user = Auth::user();
            $loginTime = $user->last_login_time
                ? \Carbon\Carbon::parse($user->last_login_time)->timezone('Asia/Dhaka')
                : null;
        @endphp

        <li class="px-2">
            <div class="d-flex flex-column gap-2">
                <div class="d-flex justify-content-between align-items-center">
                    @if ($user->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-info p-2 m-0">Dashboard
                        </a>
                    @elseif ($user->role === 'vendor')
                        <a href="{{ route('vendor.dashboard') }}" class="btn btn-outline-info p-2 m-0">Dashboard
                        </a>
                    @elseif ($user->role === 'user')
                        <a href="{{ route('user.dashboard') }}" class="btn btn-outline-info p-2 m-0">Dashboard
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger p-2">Logout</button>
                    </form>
                </div>

                <!-- User Info -->
                <div class="p-0 ms-1">
                    <small>
                        <strong>Name:</strong>
                        {{ $user->name }}
                    </small><br>
                    <small>
                        <strong>Logged in:</strong>
                        {{ $loginTime ? $loginTime->format('d M Y, h:i A') : 'N/A' }}
                    </small><br>
                    <small><strong>Duration:</strong>
                        {{ $loginTime ? $loginTime->diffForHumans(now('Asia/Dhaka'), true) . ' ago' : 'N/A' }}
                    </small>
                </div>
            </div>
        </li>
    @endauth
</ul>
