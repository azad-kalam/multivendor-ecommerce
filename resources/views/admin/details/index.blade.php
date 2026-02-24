@extends('layouts.master_layout', ['title' => 'Admin Details'])
@section('content')
    @include('inc.headers.admin.admin_header')
    @include('inc.asidebar.admin.admin_asidebar')
    <main id="main">
        <div class="row">
            <div class="col-12">
                <div class="pagetitle mt-3 p-1">
                    <!-- Role Display (User/Guest) -->
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
                                <a href="{{ route('admin.details.index') }}">
                                    <span class="small active">Admins</span>
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

                <div class="text-center mb-3">
                    <h1 class="table-heading">All Admin Information</h1>
                </div>

                <div class="d-flex mb-3">
                    <div class="me-auto">
                        <!-- Add Admin Button -->
                        <a class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#create_admin_modal">
                            <i class="fa fa-plus"></i>
                            <span>Add Admin</span>
                        </a>
                    </div>

                    <!--Search Bar starts here -->
                    <div class="search-box w-sm-50 w-md-25" id="searchBox">
                        <div class="d-flex">
                            <input type="search" id="admin_search"
                                class="form-control me-2 border border-1 border-dark" placeholder="search by name or phone..."
                                autocomplete="off" autofocus>
                            <button type="button" class="btn btn-success">search</button>
                        </div>
                    </div>
                    <!--Search Bar ends here -->
                </div>

                <div class="admin_table_container table table-responsive" style="scrollbar-width: thin">
                    @include('admin.details.pagination.admin_table')
                </div>

            </div>
        </div>
        @include('admin.details.modals.create_modal')
        @include('admin.details.modals.show_modal')
        @include('admin.details.modals.edit_modal')
    </main>
@endsection
