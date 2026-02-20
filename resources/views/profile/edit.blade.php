
@extends('layouts.masterLayout', ['title' => 'Profile Information'])
@section('content')
<main id="main" class="main">
    <div class="row">
      <div class="col-12">
        <div class="pagetitle">
            <h1>Profile</h1>
            <nav>
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">Users</li>
                <li class="breadcrumb-item active">Profile</li>
              </ol>
            </nav>
          </div>
        <div class="card">
            @include('profile.partials.update-profile-information-form')
        </div>
        <div class="mt-4 card">
            @include('profile.partials.update-password-form')
        </div>
        <div class="mt-4 card">
            @include('profile.partials.delete-user-form')
        </div>
      </div>
    </div>
  </main>










    {{-- <main id="main" class="main w-100 mt-3">
        <div class="py-12">
            <div class="mx-auto space-y-6">
            <div class="p-4 bg-white shadow">
                <div class="w-100">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="w-100">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="w-100">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
            </div>
        </div>
    </main> --}}
@endsection

