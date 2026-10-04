@extends('layouts.master_layout', ['title' => 'Banner Create'])

@section('content')
    @include('inc.headers.admin.admin_header')
    @include('inc.asidebar.admin.admin_asidebar')

    <main id="main" style="margin-top: 80px; padding: 10px">

        <div class="row">
            <div class="col-12">

                <!-- PAGE TITLE -->
                <div class="pagetitle">

                    <span class="btn btn-outline-secondary p-1 text-capitalize video-thumbnail">
                        @auth
                            {{ auth()->user()->role }}
                        @else
                            Guest
                        @endauth
                    </span>

                    <nav aria-label="breadcrumb" class="d-flex my-1">
                        <ol class="breadcrumb m-0 mb-1">

                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">
                                    <span class="small">Dashboard</span>
                                </a>
                            </li>

                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.brands.CRUD.index') }}">
                                    <span class="small">Brands</span>
                                </a>
                            </li>

                            <li class="breadcrumb-item active">
                                <span>Add Brand</span>
                            </li>

                            <li>
                                <a href="{{ url()->previous() }}" class="btn btn-dark text-white ms-2 px-1 py-0">
                                    <i class="fa-solid fa-arrow-left me-1"></i> Back
                                </a>
                            </li>

                        </ol>
                    </nav>
                </div>

                <div class="text-center mt-3 mb-3">
                    <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#bannerCreateModal">
                        Add New Banner
                    </button>
                </div>

                <div class="modal fade" id="bannerCreateModal" data-bs-backdrop="static" data-bs-keyboard="false"
                    tabindex="-1" aria-labelledby="bannerCreateModalLabel" aria-hidden="true">

                    <div
                        class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-shadow custom_modal_dialog mx-auto">

                        <div class="modal-content modal-shadow">
                            <div class="modal-header bg-secondary">
                                <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal">
                                </button>
                            </div>

                            <div class="text-center mt-1">
                                <h1 class="modal-heading">Create New Banner</h1>
                            </div>

                            <div class="modal-body custom_modal_body">

                                <form action="{{ route('admin.banners.CRUD.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf

                                    @include('partials.global_file.create_multiple_file')

                                    <div class="mb-4">
                                        <label class="form-label">Title:<span class="text-danger">*</span></label>
                                        <input type="text" name="title" class="form-control" required>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Select Type:<span class="text-danger">*</span></label>
                                        <select name="type" class="form-control" required>
                                            <option hidden>select any item</option>
                                            <option value="hero">Hero [Top large banner] </option>
                                            <option value="slider">Slider [Homepage Slider] </option>
                                            <option value="offer">Offer [Discount/offer Banner] </option>
                                            <option value="popup">Popup [Popup Banner] </option>
                                            <option value="featured">Featured [Featured Promotion Banner] </option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Occasion:</label>
                                        <input type="text" name="occasion" class="form-control">
                                    </div>

                                    <div class="mb-4 form-group">
                                        <label for="start_date">Start Date:</label>
                                        <input type="datetime-local" name="start_date" id="start_date" class="form-control">
                                    </div>

                                    <div class="mb-4 form-group">
                                        <label for="end_date">End Date:</label>
                                        <input type="datetime-local" name="end_date" id="end_date" class="form-control">
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Select Offer:</label>
                                        <select name="offer_type" class="form-control">
                                            <option value="">select any item</option>
                                            <option value="percentage">Percentage (%)</option>
                                            <option value="fixed">Fixed Amount</option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Offer Value:</label>
                                        <input type="number" step="0.01" name="offer_value" class="form-control">
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Slug:</label>
                                        <input type="text" name="slug" class="form-control" placeholder="create or auto generate">
                                    </div>

                                    <div style="margin-bottom: 60px;">
                                        <label class="form-label">Status:</label>
                                        <select name="status" class="form-control">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>



                                    <div class="d-flex justify-content-between">
                                        <button type="submit" class="btn btn-outline-success">
                                            Save
                                        </button>

                                        <button type="reset" class="btn btn-outline-danger">
                                            Reset
                                        </button>
                                    </div>
                                </form>

                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </div>

    </main>
@endsection
