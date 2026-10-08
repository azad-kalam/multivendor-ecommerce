@extends('layouts.master_layout', ['title' => 'Model Create'])

@section('content')
    @include('inc.headers.admin.admin_header')
    @include('inc.asidebar.admin.admin_asidebar')

    <main id="main" style="margin-top: 80px; padding: 10px">

        <div class="row">
            <div class="col-12">
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
                                <a href="{{ route('admin.product_models.CRUD.index') }}">
                                    <span class="small">Models</span>
                                </a>
                            </li>

                            <li class="breadcrumb-item active">
                                <span>Add Model</span>
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
                    <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#modelCreateModal">
                        Add New Model
                    </button>
                </div>

                <div class="modal fade" id="modelCreateModal" data-bs-backdrop="static" data-bs-keyboard="false"
                    tabindex="-1" aria-labelledby="modelCreateModalLabel" aria-hidden="true">

                    <div
                        class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-shadow custom_modal_dialog mx-auto">

                        <div class="modal-content modal-shadow">
                            <div class="modal-header bg-secondary">
                                <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal">
                                </button>
                            </div>

                            <div class="text-center mt-1">
                                <h1 class="modal-heading">Create New Model</h1>
                            </div>

                            <div class="modal-body custom_modal_body">

                                <form action="{{ route('admin.product_models.CRUD.store') }}" method="POST">
                                    @csrf

                                    <!-- Brand Select -->
                                    <div class="mb-4 mt-3">
                                        <label class="form-label fw-bold">
                                            Brand Select <span class="text-danger">*</span>
                                        </label>

                                        <select name="brand_id" class="form-select custom-border" required>
                                            <option value="" hidden>Select Brand</option>
                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand->id }}">
                                                    {{ $brand->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Multiple Model Inputs -->
                                    <div class="mb-4 mt-3">
                                        <label class="form-label fw-bold">
                                            Model Names <span class="text-danger">*</span>
                                        </label>

                                        <div id="model-wrapper">
                                            <input type="text" name="name[]" class="form-control mb-2"
                                                placeholder="Enter model name..." required>
                                        </div>

                                        <!-- Add More Button -->
                                        <button type="button" class="btn btn-sm btn-primary mt-2"
                                            onclick="addModelInput()">
                                            + Add More Model
                                        </button>
                                    </div>

                                    <!-- Status -->
                                    <div class="mb-5">
                                        <label class="form-label fw-bold">Status</label>

                                        <select name="status" class="form-select custom-border" required>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>

                                    <div class="modal-footer border-0 d-flex justify-content-between">
                                        <button type="submit" class="btn btn-outline-success px-3">
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

<script>
    function addModelInput() {
        let wrapper = document.getElementById('model-wrapper');

        let input = document.createElement('input');
        input.type = 'text';
        input.name = 'name[]';
        input.className = 'form-control mb-2';
        input.placeholder = 'Enter model name...';
        input.required = true;

        wrapper.appendChild(input);
    }
</script>
