@extends('layouts.master_layout', ['title' => 'Vendor Contact'])
@section('content')
    @include('inc.headers.vendor.vendor_header')
    @include('inc.asidebar.vendor.vendor_asidebar')
    <main id="main">
        <div class="row">
            <div class="col-md-12">
                <div class="pagetitle mt-3 p-1">
                    <span class="btn btn-outline-secondary p-1 text-capitalize user-role video-thumbnail">
                        {{ Auth::check() ? Auth::user()->role : 'Guest' }}
                    </span>

                    <nav aria-label="breadcrumb" class="mt-1">
                        <ol class="breadcrumb m-0">

                            <li class="breadcrumb-item">
                                <a href="{{ route('vendor.dashboard') }}">
                                    <span class="small">Dashboard</span>
                                </a>
                            </li>

                            <li class="breadcrumb-item">
                                <span class="small active">Contact</span>
                            </li>

                            <li>
                                <a href="{{ url()->previous() }}" class="btn btn-dark text-white back ms-2 px-1 py-0"
                                    aria-label="Go back">
                                    <i class="fa-solid fa-arrow-left me-1"></i> Back
                                </a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center table-heading mt-3">Contact Information</h1>
            </div>
        </div>

        <div class="row">
            <section class="section contact">
                <div class="row gy-4">
                    <div class="col-xl-6">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="info-box card">
                                    <i class="bi bi-geo-alt"></i>
                                    <h3>Address</h3>
                                    <p>A108 Ad<br>New 22</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="info-box card">
                                    <i class="bi bi-telephone"></i>
                                    <h3>Call Us</h3>
                                    <p>+1 5589 5488 55<br> 254445 41</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="info-box card">
                                    <i class="bi bi-envelope"></i>
                                    <h3>Email Us</h3>
                                    <p>iample.com<br>con.com</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="info-box card">
                                    <i class="bi bi-clock"></i>
                                    <h3>Open Hours</h3>
                                    <p>Monday - Friday<br>9:00AM - 05:00PM</p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-xl-6">
                        <div class="card p-4">
                            <form action="forms/contact.php" method="post" class="php-email-form">
                                <div class="row gy-4">

                                    <div class="col-md-6">
                                        <input type="text" name="name" class="form-control" placeholder="Your Name"
                                            required>
                                    </div>

                                    <div class="col-md-6 ">
                                        <input type="email" class="form-control" name="email" placeholder="Your Email"
                                            required>
                                    </div>

                                    <div class="col-md-12">
                                        <input type="text" class="form-control" name="subject" placeholder="Subject"
                                            required>
                                    </div>

                                    <div class="col-md-12">
                                        <textarea class="form-control" name="message" rows="6" placeholder="Message" required></textarea>
                                    </div>

                                    <div class="text-end">
                                        <button class="btn btn-outline-primary">Send Message</button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
@endsection
