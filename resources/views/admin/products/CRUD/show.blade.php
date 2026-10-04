@extends('layouts.master_layout', ['title' => 'product show'])
@section('content')
    @include('inc.headers.admin.admin_header')
    @include('inc.asidebar.admin.admin_asidebar')
    <main id="main" style="margin-top: 80px; padding: 10px">
        <div class="row">
            <div class="col-12">
                <div class="pagetitle">
                    <span class="btn btn-outline-secondary p-1 text-capitalize video-thumbnail">
                        {{ Auth::check() ? Auth::user()->role : 'Guest' }}
                    </span>
                    <nav aria-label="breadcrumb" class="d-flex my-1">
                        <ol class="breadcrumb m-0 mb-1">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">
                                    <span class="small">Dshboard</span>
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.products.CRUD.index') }}">
                                    <span class="small">Products</span>
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <span>Show</span>
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
                    <h1 class="table-heading">Show Single Product</h1>
                </div>
            </div>
        </div>

        <div class="row">
            @php
                $variant = $productDetails->variants->first();
            @endphp

            <div class="col-md-6">
                <ul class="list-group mb-2">
                    <li class="list-group-item d-flex justify-content-between">
                        <strong class="fw-bolder">Product <kbd class="pt-0 ms-1">name:</kbd> </strong>

                        @if ($productDetails->name)
                            <p>{{ $productDetails->name }}</p>
                        @else
                            <p class="text-danger">Not available</p>
                        @endif
                    </li>
                </ul>

                <ul class="list-group mb-2">
                    <li class="list-group-item d-flex justify-content-between">
                        <strong class="fw-bolder">Category<kbd class="pt-0 ms-1">name:</kbd></strong>

                        @if (optional($productDetails->subcategory?->category)->name)
                            <p>{{ $productDetails->subcategory->category->name }}</p>
                        @else
                            <p class="text-danger">Not available</p>
                        @endif
                    </li>
                </ul>

                <ul class="list-group mb-2">
                    <li class="list-group-item d-flex justify-content-between">
                        <strong class="fw-bolder">Subcategory<kbd class="pt-0 ms-1">name:</kbd></strong>

                        @if (optional($productDetails->subcategory)->subcategory_name)
                            <p>{{ $productDetails->subcategory->subcategory_name }}</p>
                        @else
                            <p class="text-danger">Not available</p>
                        @endif
                    </li>
                </ul>

                <ul class="list-group mb-2">
                    <li class="list-group-item d-flex justify-content-between">
                        <strong class="fw-bolder">Regular<kbd class="pt-0 ms-1">price:</kbd></strong>
                        @if ($variant?->regular_price)
                            <p>{{ number_format($variant->regular_price, 2) }}</p>
                        @else
                            <p class="text-danger">Not available</p>
                        @endif
                    </li>
                </ul>

                <ul class="list-group mb-2">
                    <li class="list-group-item d-flex justify-content-between">
                        <strong class="fw-bolder">Selling<kbd class="pt-0 ms-1">price:</kbd></strong>
                        @if ($variant?->selling_price)
                            <p>{{ $variant->selling_price }}</p>
                        @else
                            <p class="text-danger">Not available</p>
                        @endif
                    </li>
                </ul>

                <ul class="list-group mb-2">
                    <li class="list-group-item d-flex justify-content-between">
                        <strong class="fw-bolder">Discount<kbd class="pt-0 ms-1">value:</kbd></strong>
                        @if ($variant?->discount_value)
                            {{ $variant->discount_value }}
                        @else
                            <span class="text-danger">Not available</span>
                        @endif
                    </li>
                </ul>

                <ul class="list-group mb-2">
                    <li class="list-group-item d-flex justify-content-between">
                        <strong class="fw-bolder">Discount<kbd class="pt-0 ms-1">type:</kbd></strong>
                        @if ($variant?->discount_type)
                            {{ $variant->discount_type }}
                        @else
                            <span class="text-danger">Not available</span>
                        @endif
                    </li>
                </ul>

                {{-- Discount Start --}}
                <ul class="list-group mb-2">
                    <li class="list-group-item d-flex justify-content-between">
                        <strong class="fw-bolder">Discount<kbd class="pt-0 ms-1">start:</kbd></strong>
                        @if ($variant?->discount_start)
                            <p>{{ \Carbon\Carbon::parse($variant->discount_start)->format('d-m-Y h:i A') }}
                            </p>
                        @else
                            <p class="text-danger">Not available</p>
                        @endif
                    </li>
                </ul>

                {{-- Discount End --}}
                <ul class="list-group mb-2">
                    <li class="list-group-item d-flex justify-content-between">
                        <strong class="fw-bolder">Discount<kbd class="pt-0 ms-1">end:</kbd></strong>
                        @if ($variant?->discount_end)
                            <p>{{ \Carbon\Carbon::parse($variant->discount_end)->format('d-m-Y h:i A') }}
                            </p>
                        @else
                            <p class="text-danger">Not available</p>
                        @endif
                    </li>
                </ul>

                {{-- Product Weight --}}
                <ul class="list-group mb-2">
                    <li class="list-group-item d-flex justify-content-between">
                        <strong class="">Weight<kbd class="pt-0 ms-1">KG:</kbd></strong>
                        <p class="{{ $productDetails->product_weight ? '' : 'text-danger' }}">
                            {{ $productDetails->product_weight ?? 'Not available' }}
                        </p>
                    </li>
                </ul>

                {{-- Stock Quantity --}}
                <ul class="list-group mb-2">
                    <li class="list-group-item d-flex justify-content-between">
                        <strong class="fw-bolder">Stock<kbd class="pt-0 ms-1">quantity:</kbd></strong>
                        @if ($variant?->stock_quantity !== null)
                            <p>{{ $variant->stock_quantity }}</p>
                        @else
                            <p class="text-danger">Stock Quantity Empty</p>
                        @endif
                    </li>
                </ul>

                {{-- Stock Status --}}
                <ul class="list-group mb-2">
                    <li class="list-group-item d-flex justify-content-between">
                        <strong class="fw-bolder">Stock<kbd class="pt-0 ms-1">status:</kbd></strong>
                        @if ($variant?->stock_status)
                            <p>{{ ucfirst($variant->stock_status) }}</p>
                        @else
                            <p class="text-danger">Not available</p>
                        @endif
                    </li>
                </ul>

                {{-- Manage Stock --}}
                <ul class="list-group mb-2">
                    <li class="list-group-item d-flex justify-content-between">
                        <strong class="fw-bolder">Stock<kbd class="pt-0 ms-1">manage:</kbd></strong>
                        @if ($variant?->manage_stock)
                            <span class="btn btn-outline-success py-1">
                                Yes
                            </span>
                        @else
                            <span class="btn btn-outline-danger py-1">
                                No
                            </span>
                        @endif
                    </li>
                </ul>

                {{-- SKU --}}
                <ul class="list-group mb-2">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <strong class="fw-bolder">SKU:</strong>

                        <div class="text-start">
                            <ul style="list-style-type: disc;">
                                @forelse ($productDetails->variants as $variant)
                                    <li>{{ $variant->sku }}</li>
                                @empty
                                    <p class="text-danger mb-0">
                                        Not Available
                                    </p>
                                @endforelse
                            </ul>
                        </div>
                    </li>
                </ul>

                {{-- Slug --}}
                <ul class="list-group mb-2">
                    <li class="list-group-item d-flex py-2 justify-content-between">
                        <strong class="heading-shadow" style="width: 52%">Slug:</strong>
                        <p>{{ $productDetails->slug }}</p>
                    </li>
                </ul>

                {{-- Brand --}}
                <ul class="list-group mb-2">
                    <li class="list-group-item d-flex justify-content-between">
                        <strong class="fw-bolder">Brand:</strong>
                        @if ($productDetails->brand)
                            <p>{{ $productDetails->brand->name }}</p>
                        @else
                            <p class="text-danger">Brand Empty</p>
                        @endif
                    </li>
                </ul>

                {{-- Model --}}
                <ul class="list-group mb-2">
                    <li class="list-group-item d-flex justify-content-between">
                        <strong class="fw-bolder">Model:</strong>
                        @if ($productDetails->productModel)
                            <p>{{ $productDetails->productModel->name }}</p>
                        @else
                            <p class="text-danger">Model Empty</p>
                        @endif
                    </li>
                </ul>

                {{-- Color --}}
                <ul class="list-group mb-2">
                    <li class="list-group-item d-flex justify-content-between">
                        <strong class="fw-bolder">Color:</strong>
                        <div>
                            @php
                                $colors = $productDetails->variants->pluck('color.name')->filter()->unique();
                            @endphp

                            @if ($colors->count())
                                @foreach ($colors as $color)
                                    <span class="badge bg-primary ms-2 p-2">
                                        {{ $color }}
                                    </span>
                                @endforeach
                            @else
                                <span class="text-danger">
                                    Not available
                                </span>
                            @endif
                        </div>
                    </li>
                </ul>

                <ul class="list-group mb-2">
                    <li class="list-group-item d-flex justify-content-between">
                        <strong class="fw-bolder">Size:</strong>
                        <p class="{{ $productDetails->size ? '' : 'text-danger' }}">
                        <div class="d-flex ms-auto">
                            @php
                                $sizes = $productDetails->variants
                                    ->pluck('size.name')
                                    ->filter()
                                    ->unique()
                                    ->map(fn($size) => strtoupper($size));
                            @endphp

                            @if ($sizes->count())
                                @foreach ($sizes as $size)
                                    <span class="badge bg-success ms-2 p-2">
                                        {{ $size }}
                                    </span>
                                @endforeach
                            @else
                                <span class="text-danger">
                                    Not available
                                </span>
                            @endif
                        </div>
                        </p>
                    </li>
                </ul>
            </div>

            <div class="col-md-6">
                {{-- Full Description --}}
                <ul class="list-group mb-2">
                    <li class="list-group-item d-flex flex-column align-items-start p-1">
                        <strong class="fw-bolder ms-3 mb-2">Description<kbd class="pt-0 ms-1">full:</kbd></strong>
                        @if ($productDetails->full_description != null)
                            <textarea class="form-control border border-primary" rows="8" style="resize: none;" readonly>{{ $productDetails->full_description }}</textarea>
                        @else
                            <textarea class="form-control text-danger" rows="2" readonly>Full Description Empty</textarea>
                        @endif
                    </li>
                </ul>

                {{-- Short Description --}}
                <ul class="list-group mb-2">
                    <li class="list-group-item d-flex flex-column align-items-start p-1">
                        <strong class="fw-bolder ms-3 mb-2">Description<kbd class="pt-0 ms-1">short:</kbd></strong>
                        @if ($productDetails->short_description != null)
                            <textarea class="form-control border border-primary" rows="6" style="resize: none;" readonly>{{ $productDetails->short_description }}</textarea>
                        @else
                            <textarea class="form-control text-danger" rows="3" readonly>Short Description Empty</textarea>
                        @endif
                    </li>
                </ul>

                {{-- Meta Description --}}
                <ul class="list-group mb-2">
                    <li class="list-group-item d-flex flex-column align-items-start p-1">
                        <strong class="fw-bolder ms-3 mb-2">Meta<kbd class="pt-0 ms-1">description:</kbd></strong>
                        @if ($productDetails->meta_description)
                            <textarea class="form-control border border-primary" rows="6" style="resize: none;" readonly>{{ $productDetails->meta_description }}
                                </textarea>
                        @else
                            <textarea class="form-control text-danger" rows="2" style="resize: none;" readonly>
                                            Meta Description Empty
                                </textarea>
                        @endif
                    </li>
                </ul>
                {{-- Meta Title --}}
                <ul class="list-group mb-2">
                    <li class="list-group-item d-flex flex-column align-items-start p-1">
                        <strong class="fw-bolder ms-2 mb-2">Meta<kbd class="pt-0 ms-1">title:</kbd></strong>
                        @if ($productDetails->meta_title)
                            <textarea class="form-control border border-primary" rows="4" style="resize: none;" readonly>{{ $productDetails->meta_title }}
                                </textarea>
                        @else
                            <textarea class="form-control text-danger" rows="2" style="resize: none;" readonly>
                                        Meta Title Empty
                                </textarea>
                        @endif
                    </li>
                </ul>
                {{-- Meta Keywords --}}
                <ul class="list-group mb-3">
                    <li class="list-group-item d-flex flex-column align-items-start p-1">
                        <strong class="fw-bolder ms-2 mb-2">Meta<kbd class="pt-0 ms-1">keyword:</kbd></strong>
                        @if ($productDetails->meta_keywords)
                            <textarea class="form-control border border-primary" rows="4" style="resize: none;" readonly>{{ $productDetails->meta_keywords }}
                                </textarea>
                        @else
                            <textarea class="form-control text-danger" rows="2" style="resize: none;" readonly>
                                                Meta Keywords Empty
                                </textarea>
                        @endif
                    </li>
                </ul>

                {{-- Warranty --}}
                <ul class="list-group mb-2">
                    <li class="list-group-item d-flex justify-content-between">
                        <strong class="fw-bolder">Warranty:</strong>
                        <p class="{{ $productDetails->warranty ? '' : 'text-danger' }}">
                            {{ $productDetails->warranty ?? 'Not available' }}
                        </p>
                    </li>
                </ul>

                {{-- Featured --}}
                <ul class="list-group mb-2">
                    <li class="list-group-item d-flex py-2 justify-content-between align-items-center">
                        <strong class="fw-bolder">Featured:</strong>
                        @if ($productDetails->featured === 1)
                            <button class="btn btn-outline-success px-3 py-1">Yes</button>
                        @elseif ($productDetails->featured === 0)
                            <button class="btn btn-outline-danger px-3 py-1">No</button>
                        @else
                            <p class="text-danger mb-0">Featured Unknown</p>
                        @endif
                    </li>
                </ul>

                <ul class="list-group mb-2">
                    <li class="list-group-item d-flex align-items-center justify-content-between py-2">
                        <strong class="heading-shadow" style="width: 52%">Visibility:</strong>
                        @if ($productDetails->visibility === 'visible')
                            <button class="btn btn-outline-success py-1">{{ $productDetails->visibility }}</button>
                        @else
                            <button class="btn btn-outline-danger py-1">{{ $productDetails->visibility }}</button>
                        @endif
                    </li>
                </ul>

                <ul class="list-group">
                    <li class="list-group-item d-flex align-items-center justify-content-between py-2">
                        <strong class="heading-shadow" style="width: 52%">Status:</strong>
                        @if ($productDetails->status == 1)
                            <button class="btn btn-outline-success py-1">Active</button>
                        @else
                            <button class="btn btn-outline-danger py-1">Inactive</button>
                        @endif
                    </li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 mt-4 mb-4">

                <ul class="list-group mb-4 border border-1 border-dark">
                    <li class="list-group-item d-flex align-items-center justify-content-between">
                        <strong class="fw-bolder">
                            Product<kbd class="pt-0 ms-1">image:</kbd>
                        </strong>

                        <div class="d-flex flex-wrap gap-2">
                            @if ($productDetails->images && $productDetails->images->isNotEmpty())
                                @foreach ($productDetails->images as $image)
                                    <div class="mx-auto d-flex align-items-center justify-content-center
                            btn btn-outline-success p-1 border border-1 border-info rounded"
                                        style="width: 70px; height: 70px;">

                                        <img src="{{ asset($image->public_path) }}" class="h-100 w-100 rounded"
                                            alt="{{ $image->alt_text ?? 'Product Image' }}" />
                                    </div>
                                @endforeach
                            @else
                                <span class="text-danger">Images Not Available</span>
                            @endif
                        </div>
                    </li>

                    <li class="list-group-item d-flex align-items-center justify-content-between py-3">
                        <strong class="fw-bolder">
                            Alt<kbd class="pt-0 ms-1">text:</kbd>
                        </strong>

                        @if ($productDetails->images && $productDetails->images->isNotEmpty())
                            <p class="d-flex align-items-center my-auto">
                                {{ $productDetails->images->first()->alt_text ?? 'N/A' }}
                            </p>
                        @else
                            <p class="text-danger">Alt Text Empty</p>
                        @endif
                    </li>

                    <li class="list-group-item d-flex align-items-center justify-content-between py-3">
                        <strong class="fw-bolder">
                            Image<kbd class="pt-0 ms-1">path:</kbd>
                        </strong>

                        @if ($productDetails->images && $productDetails->images->isNotEmpty())
                            <p class="d-flex align-items-center my-auto">
                                {{ $productDetails->images->first()->public_path }}
                                <span class="text-danger ms-1">[ First ]</span>
                            </p>
                        @else
                            <p class="text-danger">Image Path Not Found</p>
                        @endif
                    </li>

                    <li class="list-group-item d-flex align-items-center justify-content-between py-3">
                        <strong class="fw-bolder">
                            Video<kbd class="pt-0 ms-1">link:</kbd>
                        </strong>
                        @php
                            $video = null;

                            if ($productDetails->images) {
                                $video = $productDetails->images->first()->video_url ?? null;
                            }
                        @endphp
                        @if ($video)
                            <a href="{{ $video }}" class="d-flex align-items-center my-auto" target="_blank"
                                rel="noopener noreferrer">
                                {{ $video }}
                            </a>
                        @else
                            <p class="text-danger">Video Link Not Found</p>
                        @endif
                    </li>
                </ul>

                <ul class="list-group mb-2">
                    <li class="list-group-item d-flex align-items-center justify-content-between py-3">
                        <strong class="heading-shadow" style="width: 52%">Created:</strong>
                        @if ($productDetails->created_at)
                            <p class="d-flex align-items-center my-auto">
                                {{ \Carbon\Carbon::parse($productDetails->created_at)->format('d-m-Y h:i A') }}
                            </p>
                        @else
                            <p class="text-danger mb-0">Created Date Not Found</p>
                        @endif
                    </li>
                </ul>

                <ul class="list-group mb-2">
                    <li class="list-group-item d-flex align-items-center justify-content-between py-3">
                        <strong class="heading-shadow" style="width: 52%">Updated:</strong>
                        @if ($productDetails->created_at == $productDetails->updated_at)
                            <p class="text-danger ms-auto mb-0">Product Not Updated Yet</p>
                        @elseif ($productDetails->updated_at)
                            <p class="d-flex align-items-center my-auto">
                                {{ \Carbon\Carbon::parse($productDetails->updated_at)->format('d-m-Y h:i A') }}
                            </p>
                        @else
                            <p class="text-danger mb-0">Updated Date Not Found</p>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </main>
@endSection
