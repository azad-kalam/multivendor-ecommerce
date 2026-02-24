@extends('layouts.master_layout', ['title' => 'Admin profile'])
@section('content')
    @include('inc.headers.admin.admin_header')
    @include('inc.asidebar.admin.admin_asidebar')
    <main id="main">
        <div class="row">
            <div class="col-12">
                <div class="pagetitle mt-3 p-1">
                    <a href="{{ route('admin.dashboard') }}"
                        class="btn btn-outline-secondary p-1 text-capitalize user-role video-thumbnail">
                        {{ Auth::check() ? Auth::user()->role : 'Guest' }}
                    </a>

                    <nav aria-label="breadcrumb" class="d-flex my-1">
                        <ol class="breadcrumb m-0 mb-1">
                            <!-- Home Breadcrumb -->
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">
                                    <span class="small">Dashboard</span>
                                </a>
                            </li>

                            <!-- Products Breadcrumb -->
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.profile.index') }}">
                                    <span class="small active">Profile</span>
                                </a>
                            </li>

                            <!-- Active Breadcrumb -->
                            <li class="breadcrumb-item active" aria-current="page">
                                <span>Table</span>
                            </li>

                            <!-- Back Button -->
                            <li>
                                <a href="{{ url()->previous() }}" class="btn btn-dark text-white back ms-2 px-1 py-0"
                                    aria-label="Go back">
                                    <i class="fa-solid fa-arrow-left me-1"></i> Back
                                </a>
                            </li>
                        </ol>
                    </nav>
                </div>

                <div class="d-flex position-relative align-items-center mb-3 mt-2">
                    <h1 class="table-heading position-absolute start-50 translate-middle-x m-0">
                        Profile Information
                    </h1>
                </div>
            </div>

            <div class="col-md-12">
                {{-- <section class="section profile">
                    <div class="row">
                        <div class="col-xl-4">
                            @foreach ($user_details as $user_detail)
                                <div class="card bg-primary">
                                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                                        @if ($profile && $profile->image)
                                            <img src="{{ asset($profile->image->public_path) }}" alt="Profile"
                                                class="rounded-circle">
                                        @else
                                            <img src="{{ asset('default-profile.png') }}" alt="Default Profile"
                                                class="rounded-circle">
                                        @endif



                                        <h2> {{ $user_detail->name }}</h2>
                                        <h3>Web Designer</h3>
                                        <div class="social-links mt-2">
                                            <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                                            <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                                            <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                                            <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="col-xl-8">
                            <div class="card bg-info p-3">
                                <div class="card-body pt-3">
                                    <!-- Bordered Tabs -->
                                    <ul class="nav nav-tabs nav-tabs-bordered">

                                        <li class="nav-item">
                                            <button class="nav-link active" data-bs-toggle="tab"
                                                data-bs-target="#profile-overview">Overview</button>
                                        </li>

                                        <li class="nav-item">
                                            <button class="nav-link" data-bs-toggle="tab"
                                                data-bs-target="#profile-edit">Edit Profile</button>
                                        </li>

                                        <li class="nav-item">
                                            <button class="nav-link" data-bs-toggle="tab"
                                                data-bs-target="#profile-settings">Settings</button>
                                        </li>

                                        <li class="nav-item">
                                            <button class="nav-link" data-bs-toggle="tab"
                                                data-bs-target="#profile-change-password">Change Password</button>
                                        </li>

                                    </ul>

                                    <div class="tab-content pt-2">
                                        <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                            <h5 class="card-title">About</h5>
                                                <p class="small fst-italic">
                                                    {{ $user_detail->about ?? 'No about' }}
                                                </p>

                                            <h5 class="card-title">Profile Details</h5>

                                            <div class="row">
                                                <div class="col-lg-3 col-md-4 label ">Full Name:</div>
                                                <div class="col-lg-9 col-md-8">{{ $user->name ?? 'No Name' }}</div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-3 col-md-4 label">Company:</div>
                                                <div class="col-lg-9 col-md-8">{{ $user->company ?? 'No company' }}
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-3 col-md-4 label">Job:</div>
                                                <div class="col-lg-9 col-md-8">{{ $user->job ?? 'No job' }}</div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-3 col-md-4 label">Country:</div>
                                                <div class="col-lg-9 col-md-8">{{ $user->country ?? 'No country' }}
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-3 col-md-4 label">Address:</div>
                                                <div class="col-lg-9 col-md-8">{{ $user->address ?? 'No address' }}
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-3 col-md-4 label">Phone:</div>
                                                <div class="col-lg-9 col-md-8">{{ $user->phone ?? 'No phone' }}</div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-3 col-md-4 label">Email:</div>
                                                <div class="col-lg-9 col-md-8">{{ $user->email ?? 'No email' }}</div>
                                            </div>

                                        </div>

                                        <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                                            <!-- Profile Edit Form -->
                                            <form>
                                                <div class="row mb-3">
                                                    <label for="profileImage"
                                                        class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <img src="assets/img/profile-img.jpg" alt="Profile">
                                                        <div class="pt-2">
                                                            <a href="#" class="btn btn-primary btn-sm"
                                                                title="Upload new profile image"><i
                                                                    class="bi bi-upload"></i></a>
                                                            <a href="#" class="btn btn-danger btn-sm"
                                                                title="Remove my profile image"><i
                                                                    class="bi bi-trash"></i></a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full
                                                        Name</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input name="fullName" type="text" class="form-control"
                                                            id="fullName" value="Kevin Anderson">
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="about"
                                                        class="col-md-4 col-lg-3 col-form-label">About</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <textarea name="about" class="form-control" id="about" style="height: 100px">Sunt est soluta temporibus accusantium neque nam maiores cumque temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure rerum quae quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at unde.</textarea>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="company"
                                                        class="col-md-4 col-lg-3 col-form-label">Company</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input name="company" type="text" class="form-control"
                                                            id="company" value="Lueilwitz, Wisoky and Leuschke">
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="Job"
                                                        class="col-md-4 col-lg-3 col-form-label">Job</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input name="job" type="text" class="form-control"
                                                            id="Job" value="Web Designer">
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="Country"
                                                        class="col-md-4 col-lg-3 col-form-label">Country</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input name="country" type="text" class="form-control"
                                                            id="Country" value="USA">
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="Address"
                                                        class="col-md-4 col-lg-3 col-form-label">Address</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input name="address" type="text" class="form-control"
                                                            id="Address" value="A108 Adam Street, New York, NY 535022">
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="Phone"
                                                        class="col-md-4 col-lg-3 col-form-label">Phone</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input name="phone" type="text" class="form-control"
                                                            id="Phone" value="(436) 486-3538 x29071">
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="Email"
                                                        class="col-md-4 col-lg-3 col-form-label">Email</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input name="email" type="email" class="form-control"
                                                            id="Email" value="k.anderson@example.com">
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="Twitter" class="col-md-4 col-lg-3 col-form-label">Twitter
                                                        Profile</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input name="twitter" type="text" class="form-control"
                                                            id="Twitter" value="https://twitter.com/#">
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="Facebook"
                                                        class="col-md-4 col-lg-3 col-form-label">Facebook
                                                        Profile</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input name="facebook" type="text" class="form-control"
                                                            id="Facebook" value="https://facebook.com/#">
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="Instagram"
                                                        class="col-md-4 col-lg-3 col-form-label">Instagram
                                                        Profile</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input name="instagram" type="text" class="form-control"
                                                            id="Instagram" value="https://instagram.com/#">
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="Linkedin"
                                                        class="col-md-4 col-lg-3 col-form-label">Linkedin
                                                        Profile</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input name="linkedin" type="text" class="form-control"
                                                            id="Linkedin" value="https://linkedin.com/#">
                                                    </div>
                                                </div>

                                                <div class="text-center">
                                                    <button type="submit" class="btn btn-primary">Save
                                                        Changes</button>
                                                </div>
                                            </form>
                                            <!-- End Profile Edit Form -->

                                        </div>

                                        <div class="tab-pane fade pt-3" id="profile-settings">
                                            <!-- Settings Form -->
                                            <form>
                                                <div class="row mb-3">
                                                    <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Email
                                                        Notifications</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="changesMade" checked>
                                                            <label class="form-check-label" for="changesMade">
                                                                Changes made to your account
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="newProducts" checked>
                                                            <label class="form-check-label" for="newProducts">
                                                                Information on new products and services
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="proOffers">
                                                            <label class="form-check-label" for="proOffers">
                                                                Marketing and promo offers
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                id="securityNotify" checked disabled>
                                                            <label class="form-check-label" for="securityNotify">
                                                                Security alerts
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="text-center">
                                                    <button type="submit" class="btn btn-primary">Save
                                                        Changes</button>
                                                </div>
                                            </form><!-- End settings Form -->
                                        </div>

                                        <div class="tab-pane fade pt-3" id="profile-change-password">
                                            <!-- Change Password Form -->
                                            <form>
                                                <div class="row mb-3">
                                                    <label for="currentPassword"
                                                        class="col-md-4 col-lg-3 col-form-label">Current
                                                        Password</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input name="password" type="password" class="form-control"
                                                            id="currentPassword">
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New
                                                        Password</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input name="newpassword" type="password" class="form-control"
                                                            id="newPassword">
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="renewPassword"
                                                        class="col-md-4 col-lg-3 col-form-label">Re-enter New
                                                        Password</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input name="renewpassword" type="password" class="form-control"
                                                            id="renewPassword">
                                                    </div>
                                                </div>

                                                <div class="text-center">
                                                    <button type="submit" class="btn btn-primary">Change
                                                        Password</button>
                                                </div>
                                            </form><!-- End Change Password Form -->
                                        </div>
                                    </div><!-- End Bordered Tabs -->
                                </div>
                            </div>
                        </div>
                    </div>
                </section> --}}



                <section class="section profile">
                    <div class="row">
                        <!-- Profile Card -->
                        <div class="col-xl-4">
                            <div class="card">
                                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center py-3">
                                    @if ($profile && $profile->image)
                                        <img src="{{ asset($profile->image->public_path) }}" alt="Profile"
                                            class="rounded-circle border border-2 border-danger">
                                    @else
                                        <img src="{{ asset('default-profile.png') }}" alt="Default Profile"
                                            class="rounded-circle">
                                    @endif

                                    <div class="overflow-hidden w-100 my-2">
                                        <h2 class="d-inline-block marque-animation">
                                            {{ $user->name }}
                                        </h2>
                                    </div>

                                    <h3 class="mb-5">
                                        {{ $profile->job ?? 'Job not defined' }}
                                    </h3>

                                    {{-- Social Links --}}
                                    <div class="social-links mt-2">
                                        <a href="{{ $profile->twitter ?? '#' }}" class="twitter"><i
                                                class="bi bi-twitter"></i></a>

                                        <a href="{{ $profile->facebook ?? '#' }}" class="facebook"><i
                                                class="bi bi-facebook"></i></a>
                                        <a href="{{ $profile->instagram ?? '#' }}" class="instagram"><i
                                                class="bi bi-instagram"></i></a>
                                        <a href="{{ $profile->linkedin ?? '#' }}" class="linkedin"><i
                                                class="bi bi-linkedin"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Profile Details and Tabs -->
                        <div class="col-xl-8">
                            <div class="card p-3">
                                <div class="card-body pt-3">
                                    <!-- Nav Tabs -->
                                    <ul class="nav nav-tabs nav-tabs-bordered">
                                        <li class="nav-item">
                                            <button class="nav-link active" data-bs-toggle="tab"
                                                data-bs-target="#profile-overview">Overview</button>
                                        </li>
                                        <li class="nav-item">
                                            <button class="nav-link" data-bs-toggle="tab"
                                                data-bs-target="#profile-edit">Edit Profile</button>
                                        </li>
                                        <li class="nav-item">
                                            <button class="nav-link" data-bs-toggle="tab"
                                                data-bs-target="#profile-settings">Settings</button>
                                        </li>
                                        <li class="nav-item">
                                            <button class="nav-link" data-bs-toggle="tab"
                                                data-bs-target="#profile-change-password">Change Password</button>
                                        </li>
                                    </ul>

                                    <div class="tab-content pt-2">
                                        <!-- Overview Tab -->
                                        <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                            <h5 class="card-title">About</h5>
                                            <p class="small fst-italic">{{ $profile->about ?? 'No about information' }}</p>

                                            <h5 class="card-title">Profile Details</h5>
                                            <div class="row">
                                                <div class="col-lg-3 col-md-4 label">Full Name:</div>
                                                <div class="col-lg-9 col-md-8">{{ $user->name }}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-3 col-md-4 label">Company:</div>
                                                <div class="col-lg-9 col-md-8">{{ $profile->company ?? 'No company' }}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-3 col-md-4 label">Job:</div>
                                                <div class="col-lg-9 col-md-8">{{ $profile->job ?? 'No job' }}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-3 col-md-4 label">Country:</div>
                                                <div class="col-lg-9 col-md-8">{{ $profile->country ?? 'No country' }}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-3 col-md-4 label">Address:</div>
                                                <div class="col-lg-9 col-md-8">{{ $profile->address ?? 'No address' }}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-3 col-md-4 label">Phone:</div>
                                                <div class="col-lg-9 col-md-8">{{ $user->phone ?? 'No phone' }}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-3 col-md-4 label">Email:</div>
                                                <div class="col-lg-9 col-md-8">{{ $user->email }}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-3 col-md-4 label">Twitter Link:</div>
                                                <div class="col-lg-9 col-md-8">
                                                    {{ $profile->twitter ?? 'No Twitter link' }}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-3 col-md-4 label">Facebook Link:</div>
                                                <div class="col-lg-9 col-md-8">
                                                    {{ $profile->facebook ?? 'No Facebook link' }}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-3 col-md-4 label">Instagram Link:</div>
                                                <div class="col-lg-9 col-md-8">
                                                    {{ $profile->instagram ?? 'No Instagram link' }}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-3 col-md-4 label">LinkedIn Link:</div>
                                                <div class="col-lg-9 col-md-8">
                                                    {{ $profile->linkedin ?? 'No LinkedIn link' }}</div>
                                            </div>
                                        </div>

                                        <!-- Edit Profile Tab -->
                                        {{-- <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                                            <form action="{{ route('admin.profile.update', $user->id) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('POST')

                                                <div class="row mb-3">
                                                    <div class="col-md-12 text-center">

                                                        <img src="{{ $profile && $profile->image ? asset($profile->image->public_path) : asset('default-profile.png') }}"
                                                            id="oldImage" alt="Old profile image" class="rounded-circle"
                                                            style="width: 120px; height: 120px;">


                                                        <img id="newImagePreview" alt="New profile image"
                                                            class="rounded-circle d-none"
                                                            style="width: 120px; height: 120px;">
                                                    </div>
                                                </div>

                                                @include('partials.global_file.profile.edit_file')

                                                <div class="row mb-3">
                                                    <label class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input name="name" type="text" class="form-control"
                                                            value="{{ $user->name }}">
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-md-4 col-lg-3 col-form-label">About</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <textarea name="about" class="form-control" style="height: 100px">{{ $profile->about }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-md-4 col-lg-3 col-form-label">Company</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input name="company" type="text" class="form-control"
                                                            value="{{ $profile->company }}">
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-md-4 col-lg-3 col-form-label">Job</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input name="job" type="text" class="form-control"
                                                            value="{{ $profile->job }}">
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-md-4 col-lg-3 col-form-label">Country</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input name="country" type="text" class="form-control"
                                                            value="{{ old('country', $profile->country ?? '') }}">
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-md-4 col-lg-3 col-form-label">Address</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input name="address" type="text" class="form-control"
                                                            value="{{ old('address', $profile->address ?? '') }}">
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-md-4 col-lg-3 col-form-label">Phone</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input name="phone" type="text" class="form-control"
                                                            value="{{ old('phone', $user->phone ?? '') }}">
                                                    </div>
                                                </div>


                                                <div class="row mb-3">
                                                    <label class="col-md-4 col-lg-3 col-form-label">Email</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input name="email" type="email" class="form-control"
                                                            value="{{ old('email', $user->email ?? '') }}">
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-md-4 col-lg-3 col-form-label">Twitter Link</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input name="twitter_profile" type="text" class="form-control"
                                                            value="{{ old('twitter_profile', $profile->twitter ?? '') }}">
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-md-4 col-lg-3 col-form-label">Facebook Link</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input name="facebook_profile" type="text"
                                                            class="form-control"
                                                            value="{{ old('facebook_profile', $profile->facebook ?? '') }}">
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-md-4 col-lg-3 col-form-label">Instagram Link</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input name="instagram_profile" type="text"
                                                            class="form-control"
                                                            value="{{ old('instagram_profile', $profile->instagram ?? '') }}">
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-md-4 col-lg-3 col-form-label">Linkedin Link</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input name="linkedin_profile" type="text"
                                                            class="form-control"
                                                            value="{{ old('linkedin_profile', $profile->linkedin ?? '') }}">
                                                    </div>
                                                </div>


                                                <div class="text-center">
                                                    <button type="submit" class="btn btn-primary">Save
                                                        Changes</button>
                                                </div>
                                            </form>
                                        </div> --}}

                                        <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                                            <form action="{{ route('admin.profile.update', $user->id) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')

                                                {{-- Image Preview --}}
                                                <div class="row mb-3">
                                                    <div class="col-md-12 text-center">
                                                        {{-- Old Image --}}
                                                        <img src="{{ $profile && $profile->image ? asset($profile->image->public_path) : asset('default-profile.png') }}"
                                                            id="oldImage" alt="Old profile image"
                                                            class="rounded-circle border border-1 border-danger"
                                                            width="120" height="120">

                                                        {{-- New Image Preview --}}
                                                        <img id="newImagePreview" alt="New profile image"
                                                            class="rounded-circle border border-2 d-none mt-2"
                                                            width="120" height="120">
                                                    </div>
                                                </div>

                                                {{-- Profile Image Input --}}
                                                @include('partials.global_file.profile.edit_file')

                                                {{-- Full Name --}}
                                                <div class="row mb-3">
                                                    <label class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input name="name" type="text"
                                                            class="form-control form-control-sm"
                                                            value="{{ old('name', $user->name) }}">
                                                    </div>
                                                </div>

                                                {{-- About --}}
                                                <div class="row mb-3">
                                                    <label class="col-md-4 col-lg-3 col-form-label small">About</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <textarea name="about" class="form-control form-control-sm" rows="4">{{ old('about', $profile->about ?? '') }}</textarea>
                                                    </div>
                                                </div>

                                                {{-- Company --}}
                                                <div class="row mb-3">
                                                    <label class="col-md-4 col-lg-3 col-form-label small">Company</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input name="company" type="text"
                                                            class="form-control form-control-sm"
                                                            value="{{ old('company', $profile->company ?? '') }}">
                                                    </div>
                                                </div>

                                                {{-- Job --}}
                                                <div class="row mb-3">
                                                    <label class="col-md-4 col-lg-3 col-form-label small">Job</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input name="job" type="text"
                                                            class="form-control form-control-sm"
                                                            value="{{ old('job', $profile->job ?? '') }}">
                                                    </div>
                                                </div>

                                                {{-- Country --}}
                                                <div class="row mb-3">
                                                    <label class="col-md-4 col-lg-3 col-form-label small">Country</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input name="country" type="text"
                                                            class="form-control form-control-sm"
                                                            value="{{ old('country', $profile->country ?? '') }}">
                                                    </div>
                                                </div>

                                                {{-- Address --}}
                                                <div class="row mb-3">
                                                    <label class="col-md-4 col-lg-3 col-form-label small">Address</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <textarea name="address" class="form-control form-control-sm" rows="4">{{ old('address', $profile->address ?? '') }}</textarea>
                                                    </div>
                                                </div>

                                                {{-- Phone --}}
                                                <div class="row mb-3">
                                                    <label class="col-md-4 col-lg-3 col-form-label small">Phone</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input name="phone" type="text"
                                                            class="form-control form-control-sm"
                                                            value="{{ old('phone', $user->phone ?? '') }}">
                                                    </div>
                                                </div>

                                                {{-- Email --}}
                                                <div class="row mb-3">
                                                    <label class="col-md-4 col-lg-3 col-form-label small">Email</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input name="email" type="email"
                                                            class="form-control form-control-sm"
                                                            value="{{ old('email', $user->email ?? '') }}">
                                                    </div>
                                                </div>

                                                {{-- Social Links --}}
                                                @php
                                                    $socials = [
                                                        'twitter' => 'Twitter Link',
                                                        'facebook' => 'Facebook Link',
                                                        'instagram' => 'Instagram Link',
                                                        'linkedin' => 'Linkedin Link',
                                                    ];
                                                @endphp

                                                @foreach ($socials as $field => $label)
                                                    <div class="row mb-3">
                                                        <label
                                                            class="col-md-4 col-lg-3 col-form-label small">{{ $label }}</label>
                                                        <div class="col-md-8 col-lg-9">
                                                            <input name="{{ $field }}" type="text"
                                                                class="form-control form-control-sm"
                                                                value="{{ old($field, $profile->$field ?? '') }}">
                                                        </div>
                                                    </div>
                                                @endforeach

                                                {{-- Submit Button --}}
                                                <div class="text-center">
                                                    <button type="submit" class="btn btn-primary btn-sm">Save
                                                        Changes</button>
                                                </div>

                                            </form>
                                        </div>

                                        <!-- Settings Tab -->
                                        <div class="tab-pane fade pt-3" id="profile-settings">
                                            <!-- Email Notification Settings (Optional) -->
                                        </div>

                                        <!-- Change Password Tab -->
                                        <div class="tab-pane fade pt-3" id="profile-change-password">
                                            {{-- <form action="{{ route('admin.profile.change-password') }}" method="POST">
                                @csrf --}}
                                            <div class="row mb-3">
                                                <label class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="current_password" type="password" class="form-control">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label class="col-md-4 col-lg-3 col-form-label">New Password</label>
                                                <div class="col-md-8 col-lg-9">
                                                    <input name="new_password" type="password" class="form-control">
                                                </div>
                                            </div>

                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary">Change Password</button>
                                            </div>
                                            {{-- </form> --}}
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>

        </div>
    </main>
@endsection


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.querySelector('.product_image');
        const oldImage = document.getElementById('oldImage');
        const newImage = document.getElementById('newImagePreview');
        const fileNameText = document.querySelector('.fileNameText');

        if (input) {
            input.addEventListener('change', function(e) {
                let file = e.target.files[0];

                if (file) {
                    // Show filename
                    fileNameText.textContent = file.name;

                    // Show new image
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        newImage.src = event.target.result;
                        newImage.classList.remove('d-none');
                        oldImage.classList.add('d-none');
                    }
                    reader.readAsDataURL(file);
                } else {
                    // Reset
                    fileNameText.textContent = 'No file';
                    newImage.classList.add('d-none');
                    oldImage.classList.remove('d-none');
                }
            });
        }
    });
</script>
