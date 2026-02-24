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

                    <nav aria-label="breadcrumb" class="d-flex mt-1">
                        <ol class="breadcrumb m-0 mb-1">
                            <!-- Home Breadcrumb -->
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">
                                    <span class="small">Dashboard</span>
                                </a>
                            </li>

                            <!-- Products Breadcrumb -->
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.sub_categories.CRUD.index') }}">
                                    <span class="small active">Sub-categories</span>
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
                    <h1 class="table-heading">All Sub-category Information</h1>
                </div>

                <div class="d-flex mb-3">
                    <!--add button start here -->
                    <div class="me-auto">
                        <a href="#" class="btn btn-outline-primary px-1" data-bs-toggle="modal"
                            data-bs-target="#admin_createSubCategory_modal">
                            <i class="fa fa-plus"></i>
                            <span>Add Sub-category</span>
                        </a>
                    </div>
                    <!--add button end here -->

                    <!--Search Bar starts here -->
                    <div class="search-box w-sm-50 w-md-25" id="searchBox">
                        <div class="d-flex">
                            <input type="search" class="form-control me-1 border border-1 border-dark"
                                placeholder="Search by ID or Name..." aria-label="Search" id="subCategorySearchField"
                                name="subCategorysearch" autocomplete="off" autofocus>
                            <button type="submit" class="btn btn-success" id="subCategorySearchBtn">Search</button>
                        </div>
                    </div>
                    <!--Search Bar ends here -->
                </div>

                <div class="subcategory_table_container" style="scrollbar-width: thin">
                    @include('admin.sub_categories.pagination.sub_category_table')
                </div>

            </div>
        </div>
        @include('admin.sub_categories.CRUD.create')
        @include('admin.sub_categories.CRUD.show')
        @include('admin.sub_categories.CRUD.edit')
        @include('admin.sub_categories.CRUD.delete')
    </main>
@endsection
