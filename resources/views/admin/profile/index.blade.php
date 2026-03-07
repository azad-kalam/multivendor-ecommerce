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
                <section class="section profile">
                    <div class="row">
                        <!-- Profile Card -->
                        <div class="col-xl-4">
                            <div class="card">
                                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center py-3">
                                    @if (!empty($profile) && !empty($profile->image))
                                        <img src="{{ asset($profile->image->public_path) }}" alt="Profile"
                                            class="rounded-circle border border-2 border-danger">
                                    @else
                                        <i class="fa fa-user-circle fa-5x text-secondary"></i>
                                    @endif

                                    <div class="overflow-hidden w-100 my-2">
                                        <h2 class="d-inline-block marque-animation">
                                            {{ $user->name ?? 'No name' }}
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
                                                <div class="col-lg-9 col-md-8">{{ $user->name ?? 'No name' }}</div>
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
                                                <div class="col-lg-9 col-md-8">{{ $user->email ?? 'No email' }}</div>
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

                                        <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                                            <!-- edit profile form start here -->
                                            <form action="{{ route('admin.profile.update') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')

                                                <div class="row mb-3">
                                                    <div class="col-md-12 text-center">
                                                        @if (!empty($profile) && !empty($profile->image))
                                                            <img src="{{ asset($profile->image->public_path) }}"
                                                                alt="Profile Image"
                                                                class="rounded-circle border border-2 border-danger"
                                                                id="oldImage">
                                                        @else
                                                            <i class="fa fa-user-circle fa-5x text-secondary"></i>
                                                        @endif

                                                        <img id="newImagePreview" class="rounded-circle d-none"
                                                            alt="New profile image">
                                                    </div>
                                                </div>

                                                <div class="form-group mb-4">
                                                    <label class="form-label ms-1 fw-bold">
                                                        Choose Image
                                                    </label>

                                                    <input type="file" class="form-control product_image product_field"
                                                        name="profile_image" accept="image/*">

                                                    @error('profile_image')
                                                        <span class="text-danger d-block">{{ $message }}</span>
                                                    @enderror

                                                    <!-- File Allowed Info -->
                                                    <div class="d-flex mt-2">
                                                        <small class="text-success mx-1">
                                                            <span class="text-danger"
                                                                style="font-size: 14px;">Allowed:</span>
                                                            <b class="text-danger">[</b>
                                                            <span style="font-size: 13px;">JPG, JPEG, PNG, GIF, WEBP
                                                            </span>
                                                            <b class="text-danger">].</b>
                                                            Maximum: 2 MB.
                                                        </small>
                                                    </div>

                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <!-- File name -->
                                                        <div>
                                                            <span class="text-danger" style="font-size: 14px;">
                                                                Filename:
                                                            </span>
                                                            <b class="text-danger">[</b>
                                                            <span class="text-primary fileNameText"
                                                                style="font-size: 14px;">
                                                                No file
                                                            </span>
                                                            <b class="text-danger">]</b>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input name="name" type="text" class="form-control"
                                                            value="{{ old('name', $user->name ?? '') }}">

                                                        @error('name')
                                                            <span class="text-danger d-block">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-md-4 col-lg-3 col-form-label">About</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <textarea name="about" class="form-control" style="height: 100px">{{ $profile->about }}</textarea>

                                                        @error('about')
                                                            <span class="text-danger d-block">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-md-4 col-lg-3 col-form-label">Company</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input name="company" type="text" class="form-control"
                                                            value="{{ old('company', $profile->company ?? '') }}">

                                                        @error('company')
                                                            <span class="text-danger d-block">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-md-4 col-lg-3 col-form-label">Job</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input name="job" type="text" class="form-control"
                                                            value="{{ old('job', $profile->job ?? '') }}">

                                                        @error('job')
                                                            <span class="text-danger d-block">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-md-4 col-lg-3 col-form-label">Country</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input name="country" type="text" class="form-control"
                                                            value="{{ old('country', $profile->country ?? '') }}">

                                                        @error('country')
                                                            <span class="text-danger d-block">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-md-4 col-lg-3 col-form-label">Address</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input name="address" type="text" class="form-control"
                                                            value="{{ old('address', $profile->address ?? '') }}">

                                                        @error('address')
                                                            <span class="text-danger d-block">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-md-4 col-lg-3 col-form-label">Phone</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input name="phone" type="text" class="form-control"
                                                            value="{{ old('phone', $user->phone ?? '') }}">

                                                        @error('phone')
                                                            <span class="text-danger d-block">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-md-4 col-lg-3 col-form-label">Email</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input name="email" type="email" class="form-control"
                                                            value="{{ old('email', $user->email ?? '') }}">

                                                        @error('email')
                                                            <span class="text-danger d-block">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-md-4 col-lg-3 col-form-label">Twitter Link</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input name="twitter_profile" type="text" class="form-control"
                                                            value="{{ old('twitter_profile', $profile->twitter ?? '') }}">

                                                        @error('twitter_profile')
                                                            <span class="text-danger d-block">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-md-4 col-lg-3 col-form-label">Facebook Link</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input name="facebook_profile" type="text"
                                                            class="form-control"
                                                            value="{{ old('facebook_profile', $profile->facebook ?? '') }}">

                                                        @error('facebook_profile')
                                                            <span class="text-danger d-block">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-md-4 col-lg-3 col-form-label">Instagram Link</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input name="instagram_profile" type="text"
                                                            class="form-control"
                                                            value="{{ old('instagram_profile', $profile->instagram ?? '') }}">

                                                        @error('instagram_profile')
                                                            <span class="text-danger d-block">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-md-4 col-lg-3 col-form-label">Linkedin Link</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input name="linkedin_profile" type="text"
                                                            class="form-control"
                                                            value="{{ old('linkedin_profile', $profile->linkedin ?? '') }}">

                                                        @error('linkedin_profile')
                                                            <span class="text-danger d-block">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="text-end">
                                                    <button type="submit" class="btn btn-outline-success">
                                                        Update Profile
                                                    </button>
                                                </div>
                                            </form>
                                            <!-- edit profile form end here -->
                                        </div>

                                        <div class="tab-pane fade pt-3" id="profile-settings">
                                            <!-- Settings change start here-->
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

                                                <div class="text-end">
                                                    <button type="submit" class="btn btn-outline-success">Save
                                                        Changes</button>
                                                </div>
                                            </form>
                                            <!-- settings change end here -->
                                        </div>

                                        <div class="tab-pane fade pt-3" id="profile-change-password">
                                            <!-- Change Password Form start here-->
                                            <form method="POST" action="{{ route('admin.profile.update-password') }}">
                                                @csrf
                                                <div class="row mb-4">
                                                    <label for="currentPassword"
                                                        class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input name="password" type="password" class="form-control"
                                                            id="currentPassword">

                                                        @error('password')
                                                            <span class="text-danger d-block">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mb-4">
                                                    <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New
                                                        Password</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input name="newpassword" type="password" class="form-control"
                                                            id="newPassword">

                                                        @error('newpassword')
                                                            <span class="text-danger d-block">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mb-4">
                                                    <label for="renewPassword"
                                                        class="col-md-4 col-lg-3 col-form-label">Confirm Password</label>
                                                    <div class="col-md-8 col-lg-9">
                                                        <input name="renewpassword" type="password" class="form-control"
                                                            id="renewPassword">

                                                        @error('renewpassword')
                                                            <span class="text-danger d-block">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="text-end">
                                                    <button type="submit" class="btn btn-outline-success">
                                                        Change Password
                                                    </button>
                                                </div>
                                            </form>
                                            <!-- Change Password Form end here-->
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
