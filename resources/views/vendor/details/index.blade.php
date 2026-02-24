@extends('layouts.master_layout', ['title' => 'Vendor Details'])
@section('content')
@include('inc.headers.vendor.vendor_header')
@include('inc.asidebar.vendor.vendor_asidebar')
    <main id="main">
        <div class="row">
            <div class="col-12">
                <div class="pagetitle mt-3 p-1">
                    <!-- Role Display Auth -->
                    <a href="{{ route('vendor.dashboard') }}"
                        class="btn btn-outline-secondary p-1 text-capitalize user-role video-thumbnail">
                        {{ Auth::check() ? Auth::user()->role : 'Guest' }}
                    </a>

                    <nav aria-label="breadcrumb" class="d-flex my-1">
                        <ol class="breadcrumb m-0 mb-1">
                            <!-- Home Breadcrumb -->
                            <li class="breadcrumb-item">
                                <a href="{{ route('vendor.dashboard') }}">
                                    <span class="small">Dashboard</span>
                                </a>
                            </li>

                            <!-- Products Breadcrumb -->
                            <li class="breadcrumb-item">
                                <span class="small active">Vendors</span>
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

                <div class="text-center mb-3">
                    <h1 class="table-heading">All Vendor Information</h1>
                </div>

                <div class="d-flex mb-3">
                    <div class="me-auto">
                        <!-- Add Admin Button -->
                        <a class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#add_vendor_modal">
                            <i class="fa fa-plus"></i>
                            <span>Add Vendor</span>
                        </a>
                    </div>

                    <!--Search Bar starts here -->
                    <div class="search-box w-sm-50 w-md-25" id="searchBox">
                        <form id="admin_searchForm">
                            <div class="d-flex">
                                <input type="search" class="form-control me-2 border border-1 border-dark"
                                    placeholder="Search by ID or Phone..." autocomplete="off" autofocus>
                                <button type="submit" class="btn btn-success">Search</button>
                            </div>
                        </form>
                    </div>
                    <!--Search Bar ends here -->
                </div>

                <div class="vendor_table_container table table-responsive">
                    @include('vendor.details.pagination.vendor_table')
                </div>

            </div>
        </div>
        @include('vendor.details.modals.create_modal')
        @include('vendor.details.modals.show_modal')
        @include('vendor.details.modals.edit_modal')
    </main>
@endsection
