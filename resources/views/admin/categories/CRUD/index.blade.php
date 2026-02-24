@extends('layouts.master_layout', ['title' => 'Admin Dashboard'])
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
                                <a href="{{ route('admin.categories.CRUD.index') }}">
                                    <span class="small active">Categories</span>
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
                    <h1 class="table-heading">All Category Information</h1>
                </div>

                <div class="d-flex mb-3">
                    <div class="me-auto">
                        <!-- Trigger Button -->
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                            data-bs-target="#admin_createCategory_modal">
                            <i class="fa fa-plus"></i>
                            <span>Add Category</span>
                        </button>
                    </div>

                    <!--Search Bar starts here -->
                    <div class="search-box w-sm-50 w-md-25" id="searchBox">
                        <div class="d-flex">
                            <input type="search" class="form-control me-2 border border-1 border-dark"
                                placeholder="Search by ID or Name..." aria-label="Search" id="categorySearchField"
                                name="categorysearch" autocomplete="off" autofocus>
                            <button type="submit" class="btn btn-success" id="categorySearchBtn">Search</button>
                        </div>
                    </div>
                    <!--Search Bar ends here -->
                </div>

                <div class="category_table_container table-responsive" style="scrollbar-width: thin">
                    @include('admin.categories.pagination.category_table')
                </div>
            </div>
        </div>
        @include('admin.categories.CRUD.create')
        @include('admin.categories.CRUD.show')
        @include('admin.categories.CRUD.edit')
        @include('admin.categories.CRUD.delete')
    </main>
@endsection
