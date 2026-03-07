<!--Header starts here-->
<header class="container-fluid py-2 fixed-top bg-white" style="box-shadow: 0px 0px 1px red;">
    <nav class="navbar navbar-expand-lg custom_nav-container">
        <div class="container-fluid p-0 m-0">
            <div class="row w-100 m-0">
                <div class="col-md-5 d-flex align-items-center">
                    <!-- Logo -->
                    <a href="" class="navbar-brand d-flex align-items-center justify-content-center">
                        <img src="{{ asset('assets/images/homepage/img/logo.png') }}" class="img-fluid" alt="home Logo" />
                        <small class="bg-info border border-1 border-dark rounded-2 px-1 ms-1">MART</small>
                    </a>

                    <!-- Sidebar Toggle -->
                    <button type="button" class="btn btn-outline-primary toggle-sidebar-btn ms-5 px-3 py-1"
                        aria-label="Toggle sidebar">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                </div>

                <!-- search bar -->
                <div class="col-md-3 d-flex align-items-center justify-content-center">
                    <div class="w-100 w-md-50 d-flex align-items-center justify-content-center">
                        <input type="search" class="form-control border border-1 border-dark rounded-1" name=""
                            placeholder="Search">
                        <button type="submit" class="border border-2 border-dark rounded-1 p-1">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>

                <div class="col-md-4 d-flex justify-content-end align-items-center">
                    <nav class="header-nav ms-auto">
                        <ul class="d-flex align-items-center">

                            <!-- Profile start here -->
                            <li class="nav-item dropdown pe-3">
                                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
                                    data-bs-toggle="dropdown">
                                    @php
                                        $imagePath = auth()->user()?->profile?->image?->public_path;
                                    @endphp

                                    <div>
                                        @if ($imagePath)
                                            <img src="{{ asset($imagePath) }}" class="rounded-circle"
                                                style="object-fit:cover;">
                                        @else
                                            <i class="fa fa-user-circle text-secondary fa-2x"></i>
                                        @endif
                                    </div>

                                    <span class="d-none d-md-block dropdown-toggle ps-2">
                                        {{ auth()->user()->name }}
                                    </span>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                                    <li class="dropdown-header">
                                        <h6>{{ auth()->user()->name }}</h6>
                                        <span>{{ auth()->user()->profile->job }}</span>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>

                                    <li>
                                        <a class="dropdown-item d-flex align-items-center"
                                            href="{{ route('admin.profile.index') }}">
                                            <i class="bi bi-person"></i>
                                            <span>My Profile</span>
                                        </a>
                                    </li>

                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>

                                    <li>
                                        <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                                            <i class="bi bi-gear"></i>
                                            <span>Account Settings</span>
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>

                                    <li class="nav-item">
                                        <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
                                            <!-- CSRF Token -->
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                            <a href="#" class="dropdown-item d-flex align-items-center"
                                                onclick="event.preventDefault(); this.closest('form').submit();">
                                                <i class="fas fa-sign-out-alt me-2"></i>
                                                <span>Log Out</span>
                                            </a>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                            <!-- Profile end here -->
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </nav>
</header>
<!-- Header end here -->
