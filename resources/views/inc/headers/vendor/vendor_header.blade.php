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
                            <li class="nav-item dropdown">

                                <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                                    <i class="bi bi-bell"></i>
                                    <span class="badge bg-primary badge-number">4</span>
                                </a><!-- End Notification Icon -->

                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                                    <li class="dropdown-header">
                                        You have 4 new notifications
                                        <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View
                                                all</span></a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>

                                    <li class="notification-item">
                                        <i class="bi bi-exclamation-circle text-warning"></i>
                                        <div>
                                            <h4>Lorem Ipsum</h4>
                                            <p>Quae dolorem earum veritatis oditseno</p>
                                            <p>30 min. ago</p>
                                        </div>
                                    </li>

                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>

                                    <li class="notification-item">
                                        <i class="bi bi-x-circle text-danger"></i>
                                        <div>
                                            <h4>Atque rerum nesciunt</h4>
                                            <p>Quae dolorem earum veritatis oditseno</p>
                                            <p>1 hr. ago</p>
                                        </div>
                                    </li>

                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>

                                    <li class="notification-item">
                                        <i class="bi bi-check-circle text-success"></i>
                                        <div>
                                            <h4>Sit rerum fuga</h4>
                                            <p>Quae dolorem earum veritatis oditseno</p>
                                            <p>2 hrs. ago</p>
                                        </div>
                                    </li>

                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>

                                    <li class="notification-item">
                                        <i class="bi bi-info-circle text-primary"></i>
                                        <div>
                                            <h4>Dicta reprehenderit</h4>
                                            <p>Quae dolorem earum veritatis oditseno</p>
                                            <p>4 hrs. ago</p>
                                        </div>
                                    </li>

                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li class="dropdown-footer">
                                        <a href="#">Show all notifications</a>
                                    </li>

                                </ul><!-- End Notification Dropdown Items -->

                            </li><!-- End Notification Nav -->

                            <li class="nav-item dropdown">

                                <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                                    <i class="bi bi-chat-left-text"></i>
                                    <span class="badge bg-success badge-number">3</span>
                                </a><!-- End Messages Icon -->

                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
                                    <li class="dropdown-header">
                                        You have 3 new messages
                                        <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View
                                                all</span></a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>

                                    <li class="message-item">
                                        <a href="#">
                                            <img src="assets/img/messages-1.jpg" alt="" class="rounded-circle">
                                            <div>
                                                <h4>Maria Hudson</h4>
                                                <p>Velit asperiores et ducimus soluta repudiandae labore officia est
                                                    ut...</p>
                                                <p>4 hrs. ago</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>

                                    <li class="message-item">
                                        <a href="#">
                                            <img src="assets/img/messages-2.jpg" alt="" class="rounded-circle">
                                            <div>
                                                <h4>Anna Nelson</h4>
                                                <p>Velit asperiores et ducimus soluta repudiandae labore officia est
                                                    ut...</p>
                                                <p>6 hrs. ago</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>

                                    <li class="message-item">
                                        <a href="#">
                                            <img src="assets/img/messages-3.jpg" alt="" class="rounded-circle">
                                            <div>
                                                <h4>David Muldon</h4>
                                                <p>Velit asperiores et ducimus soluta repudiandae labore officia est
                                                    ut...</p>
                                                <p>8 hrs. ago</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>

                                    <li class="dropdown-footer">
                                        <a href="#">Show all messages</a>
                                    </li>

                                </ul><!-- End Messages Dropdown Items -->

                            </li><!-- End Messages Nav -->

                            <!-- Profile start here -->
                            <li class="nav-item dropdown pe-3">
                                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
                                    data-bs-toggle="dropdown">
                                    <img src="{{ asset('assets/images/profile/profile-img.jpg') }}" alt="Profile"
                                        class="rounded-circle">
                                    <span class="d-none d-md-block dropdown-toggle ps-2">{{Auth::User()->name}}</span>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                                    <li class="dropdown-header">
                                        <h6>Kevin Anderson</h6>
                                        <span>Web Designer</span>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>

                                    <li>
                                        <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
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

                                    <li>
                                        <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                                            <i class="bi bi-question-circle"></i>
                                            <span>Need Help?</span>
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
