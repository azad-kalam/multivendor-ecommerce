@extends('layouts.master_layout', ['title' => 'Size Create'])

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
                                <a href="{{ route('admin.sizes.CRUD.index') }}">
                                    <span class="small">Sizes</span>
                                </a>
                            </li>

                            <li class="breadcrumb-item active">
                                <span>Add Size</span>
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
                    <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#sizeCreateModal">
                        Add New Size
                    </button>
                </div>

                <!-- MODAL -->
                <div class="modal fade" id="sizeCreateModal" data-bs-backdrop="static" data-bs-keyboard="false"
                    tabindex="-1" aria-labelledby="sizeCreateModalLabel" aria-hidden="true">

                    <div class="modal-dialog modal-dialog-centered custom_modal_dialog mx-auto">

                        <div class="modal-content modal-shadow">

                            <!-- HEADER -->
                            <div class="modal-header bg-secondary">
                                <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal">
                                </button>
                            </div>

                            <div class="text-center mt-1">
                                <h1 class="modal-heading">Create New Size</h1>
                            </div>

                            <!-- BODY -->
                            <div class="modal-body custom_modal_body">
                                <form action="{{ route('admin.sizes.CRUD.store') }}" method="POST">
                                    @csrf
                                    @method('POST')

                                    <!-- SIZE NAME -->
                                    <div class="mb-4 mt-3">
                                        <label class="form-label fw-bold">
                                            Size Name <span class="text-danger">*</span>
                                        </label>

                                        <input type="text" class="form-control custom-border" name="name"
                                            placeholder="S, M, L, XL, XXL ..." required>
                                    </div>

                                    <!-- STATUS -->
                                    <div class="mb-5">
                                        <label class="form-label fw-bold">
                                            Size Status <span class="text-danger">*</span>
                                        </label>

                                        <select name="status" class="form-select custom-border" required>
                                            <option value="" hidden>Select one</option>
                                            <option value="1">Active</option>
                                            <option value="0">Block</option>
                                        </select>
                                    </div>

                                    <!-- FOOTER -->
                                    <div class="modal-footer border-0 d-flex justify-content-between">
                                        <button type="submit" class="btn btn-outline-success px-3" id="createSizeBtn">
                                            Save
                                        </button>
                                        <button type="reset" class="btn btn-outline-danger px-3">
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
