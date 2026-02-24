@extends('layouts.master_layout', ['title' => 'Admin Dashboard'])

@section('content')
    @include('inc.headers.admin.admin_header')
    @include('inc.asidebar.admin.admin_asidebar')
    <main id="main">
        <div class="row">
            <div class="col-md-12">
                <div class="pagetitle mt-3 p-1">

                    @auth
                        <a href="{{ route('admin.dashboard') }}"
                            class="btn btn-outline-secondary p-1 text-capitalize user-role video-thumbnail">
                            {{ auth()->user()->role }}
                        </a>
                    @else
                        <span class="btn btn-outline-secondary p-1 text-capitalize user-role disabled">Guest</span>
                    @endauth

                    <nav aria-label="breadcrumb" class="mt-1">
                        <ol class="breadcrumb m-0">

                            <li class="breadcrumb-item">
                                <a href="{{ route('homepage.index') }}">
                                    <span class="small">Home</span>
                                </a>
                            </li>

                            <li class="breadcrumb-item">
                                <span class="small active">Dashboard</span>
                            </li>

                            <li>
                                <a href="{{ url()->previous() }}" class="btn btn-dark text-white back ms-2 px-1 py-0"
                                    aria-label="Go back">
                                    <i class="fa-solid fa-arrow-left me-1"></i> Back
                                </a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <!-- All register card start here -->
            <div class="col-md-3">
                <div class="card custom_card mb-2">
                    <div class="card-header p-2" style="background-color:teal">
                        <h5 class="text-center text-white mb-0 custom_font_style_1">All
                            Register
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between px-2">
                            <p class="mb-0 fw-semibold">Total:</p>
                            <p class="mb-0 fw-semibold">[ {{ $total_count }} ]</p>
                        </div>

                        <div class="row p-0 m-0">
                            <div class="col-6 ps-0 m-0 d-flex align-items-start justify-content-start">
                                <small>
                                    <ol class="m-0">
                                        <li>Admin (s): </li>
                                        <li>Vendor (s): </li>
                                        <li>Customer (s): </li>
                                    </ol>
                                </small>
                            </div>
                            <div class="col-6 pe-2 m-0 d-flex align-items-end justify-content-end">
                                <small>
                                    <ol class="m-0 list-unstyled text-end">
                                        <li>[ {{ $adminCount }} ]</li>
                                        <li>[ {{ $vendorCount }} ]</li>
                                        <li>[ {{ $userCount }} ]</li>
                                    </ol>
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer border-0 p-0 m-1">
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.all_register_info.index') }}"
                                class="btn btn-sm btn-outline-warning text-danger"> More views ...
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- All register card end here -->

            <!-- Admin card start here -->
            <div class="col-md-3">
                <div class="card custom_card mb-2">
                    <div class="card-header p-2">
                        <h5 class="text-center text-white mb-0 custom_font_style_1">Admin</h5>
                    </div>

                    <div class="card-body">
                        <div class="d-flex justify-content-between px-2">
                            <p class="mb-0 fw-semibold">Total:</p>
                            <p class="mb-0 fw-semibold">[ {{ $adminCount }} ]</p>
                        </div>
                    </div>

                    <div class="card-footer border-0 p-1">
                        <div class="text-center mb-3">
                            <small class="text-muted">
                                Last updated {{ $updated['admin']?->updated_at?->diffForHumans() ?? 'N/A' }}
                            </small><br>
                            <small class="text-muted">
                                @if ($updated['admin'])
                                    {{ $updated['admin']?->updated_at?->timezone('Asia/Dhaka')->format('d/m/Y') }}
                                    <i class="fa-regular fa-clock mx-1 text-dark"></i>
                                    {{ $updated['admin']?->updated_at?->timezone('Asia/Dhaka')->format('h:i A') }}
                                @else
                                    Data not found
                                @endif
                            </small>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.details.index') }}"
                                class="btn btn-sm btn-outline-warning text-danger">
                                More views ...
                            </a>
                        </div>

                    </div>
                </div>
            </div>
            <!-- Admin card end here -->

            <!-- vendor card start here -->
            <div class="col-md-3">
                <div class="card custom_card mb-2">
                    <div class="card-header p-2">
                        <h5 class="text-center text-white mb-0 custom_font_style_1">Vendor</h5>
                    </div>

                    <div class="card-body">
                        <div class="d-flex justify-content-between px-2">
                            <p class="mb-0 fw-semibold">Total:</p>
                            <p class="mb-0 fw-semibold">[ {{ $vendorCount }} ]</p>
                        </div>
                    </div>

                    <div class="card-footer border-0 p-1">
                        <div class="text-center mb-3">
                            <small class="text-muted">
                                Last updated {{ $updated['vendor']?->updated_at?->diffForHumans() ?? 'N/A' }}
                            </small><br>
                            <small class="text-muted">
                                @if ($updated['vendor'])
                                    {{ $updated['vendor']?->updated_at?->timezone('Asia/Dhaka')->format('d/m/Y') }}
                                    <i class="fa-regular fa-clock mx-1 text-dark"></i>
                                    {{ $updated['vendor']?->updated_at?->timezone('Asia/Dhaka')->format('h:i A') }}
                                @else
                                    Data not found
                                @endif
                            </small>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.all_vendor.index') }}"
                                class="btn btn-sm btn-outline-warning text-danger">
                                More views ...
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- vendor card end here -->

            <!-- user card start here -->
            <div class="col-md-3">
                <div class="card custom_card mb-2">
                    <div class="card-header p-2">
                        <h5 class="text-center text-white mb-0 custom_font_style_1">Customer</h5>
                    </div>

                    <div class="card-body">
                        <div class="d-flex justify-content-between px-2">
                            <p class="mb-0 fw-semibold">Total:</p>
                            <p class="mb-0 fw-semibold">[ {{ $userCount }} ]</p>
                        </div>
                    </div>

                    <div class="card-footer border-0 p-1">
                        <div class="text-center mb-3">
                            <small class="text-muted">
                                Last updated {{ $updated['user']?->updated_at?->diffForHumans() ?? 'N/A' }}
                            </small><br>
                            <small class="text-muted">
                                @if ($updated['user'])
                                    {{ $updated['user']?->updated_at?->timezone('Asia/Dhaka')->format('d/m/Y') }}
                                    <i class="fa-regular fa-clock mx-1 text-dark"></i>
                                    {{ $updated['user']?->updated_at?->timezone('Asia/Dhaka')->format('h:i A') }}
                                @else
                                    Data not found
                                @endif
                            </small>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.all_user.index') }}"
                                class="btn btn-sm btn-outline-warning text-danger">
                                More views ...
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- user card end here -->
        </div>

        <div class="row">
            <!-- category card start here -->
            <div class="col-md-3">
                <div class="card custom_card mb-2">
                    <div class="card-header p-2">
                        <h5 class="text-center text-white mb-0 custom_font_style_1">Category</h5>
                    </div>

                    <div class="card-body">
                        <div class="d-flex justify-content-between px-2">
                            <p class="mb-0 fw-semibold">Total:</p>
                            <p class="mb-0 fw-semibold">[ {{ $categories_count }} ]</p>
                        </div>
                    </div>

                    <div class="card-footer border-0 p-1">
                        <div class="text-center mb-3">
                            <small class="text-muted">
                                Last updated {{ $updated['category']?->updated_at?->diffForHumans() ?? 'N/A' }}
                            </small><br>
                            <small class="text-muted">
                                @if ($updated['category'])
                                    {{ $updated['category']?->updated_at?->timezone('Asia/Dhaka')->format('d/m/Y') }}
                                    <i class="fa-regular fa-clock mx-1 text-dark"></i>
                                    {{ $updated['category']?->updated_at?->timezone('Asia/Dhaka')->format('h:i A') }}
                                @else
                                    Data not found
                                @endif
                            </small>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.categories.CRUD.index') }}"
                                class="btn btn-sm btn-outline-warning text-danger">
                                More views ...
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- category card end here -->

            <!-- sub-category card start here -->
            <div class="col-md-3">
                <div class="card custom_card mb-2">
                    <div class="card-header p-2">
                        <h5 class="text-center text-white mb-0 custom_font_style_1">Sub-category</h5>
                    </div>

                    <div class="card-body">
                        <div class="d-flex justify-content-between px-2">
                            <p class="mb-0 fw-semibold">Total:</p>
                            <p class="mb-0 fw-semibold">[ {{ $subcategories_count }} ]</p>
                        </div>
                    </div>

                    <div class="card-footer border-0 p-1">
                        <div class="text-center mb-3">
                            <small class="text-muted">
                                Last updated {{ $updated['subcategory']?->updated_at?->diffForHumans() ?? 'N/A' }}
                            </small><br>
                            <small class="text-muted">
                                @if ($updated['subcategory'])
                                    {{ $updated['subcategory']?->updated_at?->timezone('Asia/Dhaka')->format('d/m/Y') }}
                                    <i class="fa-regular fa-clock mx-1 text-dark"></i>
                                    {{ $updated['subcategory']?->updated_at?->timezone('Asia/Dhaka')->format('h:i A') }}
                                @else
                                    Data not found
                                @endif
                            </small>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.sub_categories.CRUD.index') }}"
                                class="btn btn-sm btn-outline-warning text-danger">
                                More views ...
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- sub-category card end here -->

            <!-- product card start here -->
            <div class="col-md-3">
                <div class="card custom_card mb-2">
                    <div class="card-header p-2">
                        <h5 class="text-center text-white mb-0 custom_font_style_1">Product</h5>
                    </div>

                    <div class="card-body">
                        <div class="d-flex justify-content-between px-2">
                            <p class="mb-0 fw-semibold">Total:</p>
                            <p class="mb-0 fw-semibold">[ {{ $products_count }} ]</p>
                        </div>
                    </div>

                    <div class="card-footer border-0 p-1">
                        <div class="text-center mb-3">
                            <small class="text-muted d-block">
                                Last updated {{ $updated['product']?->updated_at?->diffForHumans() ?? 'N/A' }}
                            </small>
                            @if (!empty($updated['product']?->updated_at))
                                <small class="text-muted">
                                    {{ $updated['product']->updated_at->timezone('Asia/Dhaka')->format('d/m/Y') }}
                                    <i class="fa-regular fa-clock mx-1 text-dark"></i>
                                    {{ $updated['product']->updated_at->timezone('Asia/Dhaka')->format('h:i A') }}
                                </small>
                            @else
                                <small class="text-muted">Data not found</small>
                            @endif
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.products.CRUD.index') }}"
                                class="btn btn-sm btn-outline-warning text-danger">
                                More views ...
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- product card end here -->
        </div>
    </main>
@endsection
