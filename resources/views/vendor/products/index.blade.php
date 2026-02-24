@extends('layouts.master_layout', ['title' => 'product details'])
@section('content')
    @include('inc.headers.vendor.vendor_header')
    @include('inc.asidebar.vendor.vendor_asidebar')
    <main id="main" style="margin-top: 80px; padding: 10px">
        <div class="row">
            <div class="col-12">
                <div class="pagetitle">
                    <!-- Role Display (User/Guest) -->
                    <span class="btn btn-outline-secondary p-1 text-capitalize user-role video-thumbnail">
                        {{ Auth::check() ? Auth::user()->role : 'Guest' }}
                    </span>
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
                                <span class="small active">Products</span>
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
                    <h1 class="table-heading">All Product Information</h1>
                </div>
                <div class="d-flex mb-3">
                    <div class="me-auto">
                        <a href="{{ route('vendor.products.create') }}" class="btn btn-outline-primary">
                            <i class="fa fa-plus"></i>
                            <span>Add Product</span>
                        </a>
                    </div>
                    <!--Search Bar starts here -->
                    <div class="search-box w-sm-50 w-md-25">
                        <div class="d-flex">
                            <input type="search" class="form-control me-2 border border-1 border-success search"
                                placeholder="Search by ID or Name..." aria-label="Search" id="productsearch"
                                autocomplete="off" autofocus>
                            <button type="submit" class="btn btn-success">Search</button>
                        </div>
                    </div>
                    <!--Search Bar ends here -->
                </div>
                <div class="product_table_container">
                    @include('vendor.products.pagination.product_table')
                </div>
            </div>
        </div>
    </main>
@endsection
