@extends('layouts.master_layout', ['title' => 'product show'])
@section('content')
    @include('inc.headers.vendor.vendor_header')
    @include('inc.asidebar.vendor.vendor_asidebar')
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
                                <a href="{{ route('vendor.dashboard') }}">
                                    <span class="small">Dshboard</span>
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('vendor.products.index') }}">
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
            <div class="col-md-6">
                {{-- Product Name --}}
                <ul class="list-group mb-2">
                    <li class="list-group-item d-flex justify-content-between">
                        <strong class="fw-bolder">Product<kbd class="pt-0 ms-1">name:</kbd></strong>
                        <p>{{ $productDetails->name }}</p>
                    </li>
                </ul>

                {{-- Category Name --}}
                <ul class="list-group mb-2">
                    <li class="list-group-item d-flex justify-content-between">
                        <strong class="fw-bolder">Category<kbd class="pt-0 ms-1">name:</kbd></strong>
                        <p>{{ optional(optional($productDetails->subcategory)->category)->name ?? 'N/A' }}</p>
                    </li>
                </ul>

                {{-- Subcategory Name --}}
                <ul class="list-group mb-2">
                    <li class="list-group-item d-flex justify-content-between">
                        <strong class="fw-bolder">Subcategory<kbd class="pt-0 ms-1">name:</kbd></strong>
                        <p>{{ optional($productDetails->subcategory)->subcategory_name ?? 'N/A' }}</p>
                    </li>
                </ul>

                {{-- Regular Price --}}
                <ul class="list-group mb-2">
                    <li class="list-group-item d-flex justify-content-between">
                        <strong class="fw-bolder">Regular<kbd class="pt-0 ms-1">price:</kbd></strong>
                        <p>{{ optional($productDetails->price)->regular_price ?? 'N/A' }}</p>
                    </li>
                </ul>

                {{-- Selling Price --}}
                <ul class="list-group mb-2">
                    <li class="list-group-item d-flex justify-content-between">
                        <strong class="fw-bolder">Selling<kbd class="pt-0 ms-1">price:</kbd></strong>
                        <p>{{ optional($productDetails->price)->selling_price ?? 'N/A' }}</p>
                    </li>
                </ul>

                {{-- Discount Value --}}
                <ul class="list-group mb-2">
                    <li class="list-group-item d-flex justify-content-between">
                        <strong class="fw-bolder">Discount<kbd class="pt-0 ms-1">value:</kbd></strong>
                        <p class="{{ optional($productDetails->price)->discount_value ? '' : 'text-danger' }}">
                            {{ optional($productDetails->price)->discount_value ?? 'Discount Value Empty' }}
                        </p>
                    </li>
                </ul>

                {{-- Discount Type --}}
                <ul class="list-group mb-2">
                    <li class="list-group-item d-flex justify-content-between">
                        <strong class="fw-bolder">Discount<kbd class="pt-0 ms-1">type:</kbd></strong>
                        <p class="{{ optional($productDetails->price)->discount_type ? '' : 'text-danger' }}">
                            {{ optional($productDetails->price)->discount_type ?? 'Discount Type Empty' }}
                        </p>
                    </li>
                </ul>

                {{-- Discount Start --}}
                <ul class="list-group mb-2">
                    <li class="list-group-item d-flex justify-content-between">
                        <strong class="fw-bolder">Discount<kbd class="pt-0 ms-1">start:</kbd></strong>
                        @if (optional($productDetails->price)->discount_start)
                            <p>{{ \Carbon\Carbon::parse($productDetails->price->discount_start)->format('d-m-Y h:i A') }}
                            </p>
                        @else
                            <p class="text-danger">Discount Start Empty</p>
                        @endif
                    </li>
                </ul>

                {{-- Discount End --}}
                <ul class="list-group mb-2">
                    <li class="list-group-item d-flex justify-content-between">
                        <strong class="fw-bolder">Discount<kbd class="pt-0 ms-1">end:</kbd></strong>
                        @if (optional($productDetails->price)->discount_end)
                            <p>{{ \Carbon\Carbon::parse($productDetails->price->discount_end)->format('d-m-Y h:i A') }}
                            </p>
                        @else
                            <p class="text-danger">Discount End Empty</p>
                        @endif
                    </li>
                </ul>

                {{-- Product Weight --}}
                <ul class="list-group mb-2">
                    <li class="list-group-item d-flex justify-content-between">
                        <strong class="">Weight<kbd class="pt-0 ms-1">KG:</kbd></strong>
                        <p class="{{ $productDetails->product_weight ? '' : 'text-danger' }}">
                            {{ $productDetails->product_weight ?? 'Weight Empty' }}
                        </p>
                    </li>
                </ul>

                {{-- Stock Quantity --}}
                <ul class="list-group mb-2">
                    <li class="list-group-item d-flex justify-content-between">
                        <strong class="fw-bolder">Stock<kbd class="pt-0 ms-1">quantity:</kbd></strong>
                        <p>{{ $productDetails->stock_quantity }}</p>
                    </li>
                </ul>

                {{-- Stock Status --}}
                <ul class="list-group mb-2">
                    <li class="list-group-item d-flex justify-content-between">
                        <strong class="fw-bolder">Stock<kbd class="pt-0 ms-1">status:</kbd></strong>
                        <p>{{ $productDetails->stock_status }}</p>
                    </li>
                </ul>

                {{-- Manage Stock --}}
                <ul class="list-group mb-2">
                    <li class="list-group-item d-flex justify-content-between">
                        <strong class="fw-bolder">Stock<kbd class="pt-0 ms-1">manage:</kbd></strong>
                        <p>{{ $productDetails->manage_stock }}</p>
                    </li>
                </ul>

                {{-- SKU --}}
                <ul class="list-group mb-2">
                    <li class="list-group-item d-flex justify-content-between">
                        <strong class="fw-bolder">SKU:</strong>
                        <p>{{ $productDetails->sku }}</p>
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
                        <p class="{{ $productDetails->brand ? '' : 'text-danger' }}">
                            {{ $productDetails->brand ?? 'Brand Empty' }}
                        </p>
                    </li>
                </ul>

                {{-- Model --}}
                <ul class="list-group mb-2">
                    <li class="list-group-item d-flex justify-content-between">
                        <strong class="fw-bolder">Model:</strong>
                        <p class="{{ $productDetails->model ? '' : 'text-danger' }}">
                            {{ $productDetails->model ?? 'Model Empty' }}
                        </p>
                    </li>
                </ul>

                {{-- Color --}}
                <ul class="list-group mb-2">
                    <li class="list-group-item d-flex justify-content-between">
                        <strong class="fw-bolder">Color:</strong>
                        <p class="{{ $productDetails->color ? '' : 'text-danger' }}">
                            {{ $productDetails->color ?? 'Color Empty' }}
                        </p>
                    </li>
                </ul>

                {{-- Size --}}
                <ul class="list-group mb-2">
                    <li class="list-group-item d-flex justify-content-between">
                        <strong class="fw-bolder">Size:</strong>
                        <p class="{{ $productDetails->size ? '' : 'text-danger' }}">
                            {{ $productDetails->size ?? 'Size Empty' }}
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
                            {{ $productDetails->warranty ?? 'Warranty Empty' }}
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

                {{-- Visibility --}}
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

                {{-- Status --}}
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
                {{-- Image --}}
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
                    {{-- image public path --}}
                    <li class="list-group-item d-flex align-items-center justify-content-between py-3">
                        <strong class="fw-bolder">
                            File<kbd class="pt-0 ms-1">name:</kbd>
                        </strong>

                        @if ($productDetails->images && $productDetails->images->count())
                            <span>
                                {{ $productDetails->images->pluck('file_name')->implode(', ') }}
                            </span>
                        @else
                            <span class="text-danger">File name Empty</span>
                        @endif
                    </li>
                    {{-- alter text --}}
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

                    {{-- video link --}}
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

                {{-- Created --}}
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

                {{-- Updated --}}
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
