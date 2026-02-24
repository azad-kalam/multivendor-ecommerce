@extends('layouts.master_layout', ['title' => 'Vendor Dashboard'])
@section('content')
    @include('inc.headers.vendor.vendor_header')
    @include('inc.asidebar.vendor.vendor_asidebar')
    <main id="main">
        <div class="row">
            <div class="col-md-12">
                <div class="pagetitle mt-3 p-1">
                    <span class="btn btn-outline-secondary p-1 text-capitalize user-role video-thumbnail">
                        {{ Auth::check() ? Auth::user()->role : 'Guest' }}
                    </span>

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
        <!-- vendor info card start heere -->
        <div class="container-fluid mt-2 px-0">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-5 mx-auto">
                    <div class="card custom_card mb-2">
                        <div class="card-header p-2 bg-primary">
                            <h5 class="text-center text-white mb-0 custom_font_style_1">Vendor</h5>
                        </div>

                        <div class="card-body">
                            <div class="d-flex justify-content-between px-2 py-1">
                                <p class="mb-0 fw-semibold">Name:</p>
                                <p class="mb-0 fw-semibold">[ {{ $vendor_name }} ]</p>
                            </div>
                        </div>

                        <div class="card-footer border-0 px-1 py-0">
                            <div class="text-center mb-1">
                                <small class="text-muted">
                                     Last updated {{ $vendor_last_updated->diffForHumans() }}
                                </small><br>
                                <small class="text-muted">
                                    {{ $vendor_last_updated?->timezone('Asia/Dhaka')->format('d/m/Y') }}
                                    <i class="fa-regular fa-clock mx-1 text-dark"></i>
                                    {{ $vendor_last_updated?->timezone('Asia/Dhaka')->format('h:i A') }}
                                </small>
                            </div>

                            <div class="d-flex justify-content-end">
                                <a href="{{ route('vendor.details.index') }}"
                                    class="btn btn-sm btn-outline-warning text-danger mb-1">
                                    More views ...
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- vendor info card end heere -->

        <div class="row">
            <!-- vendor product card start heere -->
            <div class="col-md-3">
                <div class="card custom_card mb-2">
                    <div class="card-header p-2">
                        <h5 class="text-center text-white mb-0 custom_font_style_1">Product</h5>
                    </div>

                    <div class="card-body">
                        <div class="d-flex justify-content-between px-2 py-1">
                            <p class="mb-0 fw-semibold">Total:</p>
                            <p class="mb-0 fw-semibold">[ {{ $vendor_products_total_count }} ]</p>
                        </div>
                    </div>

                    <div class="card-footer border-0 px-1 py-0">
                        <div class="text-center mb-1">
                            @if ($vendor_product_last_updated)
                                <small class="text-muted">
                                    Last updated {{ $vendor_product_last_updated->updated_at->diffForHumans() }}
                                </small><br>
                                <small class="text-muted">
                                    {{ $vendor_product_last_updated->updated_at->timezone('Asia/Dhaka')->format('d/m/Y') }}
                                    <i class="fa-regular fa-clock mx-1 text-dark"></i>
                                    {{ $vendor_product_last_updated->updated_at->timezone('Asia/Dhaka')->format('h:i A') }}
                                </small>
                            @else
                                <small class="text-muted">Last updated: N/A</small>
                            @endif

                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('vendor.products.index') }}"
                                class="btn btn-sm btn-outline-warning text-danger mb-1">
                                More views ...
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- vendor product card end heere -->
        </div>
    </main>
@endsection
