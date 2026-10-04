@extends('layouts.master_layout', ['title' => 'Brand Create'])

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
                    <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#brandCreateModal">
                        Add New Brand
                    </button>
                </div>

                <div class="modal fade" id="brandCreateModal" data-bs-backdrop="static" data-bs-keyboard="false"
                    tabindex="-1" aria-labelledby="brandCreateModalLabel" aria-hidden="true">

                    <div
                        class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-shadow custom_modal_dialog mx-auto">

                        <div class="modal-content modal-shadow">
                            <div class="modal-header bg-secondary">
                                <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal">
                                </button>
                            </div>

                            <div class="text-center mt-1">
                                <h1 class="modal-heading">Create New Brand</h1>
                            </div>

                            <div class="modal-body custom_modal_body">

                                <form action="{{ route('admin.brands.CRUD.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf

                                    @include('partials.global_file.create_single_file')

                                    <div class="mb-4 mt-3">
                                        <label class="form-label fw-bold">
                                            Brand Name <span class="text-danger">*</span>
                                        </label>

                                        <input type="text" class="form-control custom-border" name="name"
                                            placeholder="Enter brand name..." required>
                                    </div>

                                    <div class="mb-5">
                                        <label class="form-label fw-bold">
                                            Brand Status <span class="text-danger">*</span>
                                        </label>

                                        <select name="status" class="form-select custom-border" required>
                                            <option hidden>Select one</option>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>

                                    <div class="modal-footer border-0 d-flex justify-content-between">
                                        <button type="submit" class="btn btn-outline-success">
                                            Save
                                        </button>

                                        <button type="reset" class="btn btn-outline-danger reset">
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
