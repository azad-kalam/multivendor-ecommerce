@extends('layouts.master_layout', ['title' => 'product edit'])
@section('content')
    @include('inc.headers.admin.admin_header')
    @include('inc.asidebar.admin.admin_asidebar')
    <main id="main" style="margin-top: 80px; padding: 10px">
        <div class="row">
            <div class="col-12">
                <div class="pagetitle">
                    <!-- Role Display (User/Guest) -->
                    <span class="btn btn-outline-secondary p-1 text-capitalize user-role video-thumbnail">
                        {{ auth()->user()->role ?? 'Guest' }}

                    </span>

                    <nav aria-label="breadcrumb" class="d-flex my-1">
                        <ol class="breadcrumb m-0 mb-1">
                            <!-- Home Breadcrumb -->
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">
                                    <span class="small">Dashboard</span>
                                </a>
                            </li>

                            <!-- Products Breadcrumb -->
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.products.CRUD.index') }}">
                                    <span class="small">Products</span>
                                </a>
                            </li>

                            <!-- Active Breadcrumb -->
                            <li class="breadcrumb-item active" aria-current="page">
                                <span>Edit</span>
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
                <div class="text-center my-2">
                    <h1 class="table-heading">Edit Product</h1>
                </div>
            </div>
        </div>

        <div class="m-2">
            <form action="{{ route('admin.products.CRUD.update', $productFind->id) }}" id="editProductForm" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-7 p-1">
                        {{-- product information starts here --}}
                        <div class="card common_card p-2 mb-2">
                            <div class="card-header p-0 border-0">
                                <h3 class="card-title text-center fw-bold">Product information</h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-4">
                                    <label for="product_name" class="form-label">
                                        Product Name: <span class="text-danger" aria-hidden="true">*</span>
                                    </label>
                                    <input type="text" class="form-control product_field" id="product_name"
                                        name="name" autocomplete="off" value="{{ old('name', $productFind->name) }}"
                                        required>

                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="short_description" class="form-label">
                                        Short Description:
                                    </label>
                                    <textarea class="form-control product_field" id="short_description" name="short_description" rows="3"
                                        style="resize: none; overflow-y: scroll" required>{{ old('short_description', $productFind->short_description) }}</textarea>

                                    @error('short_description')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="full_description" class="form-label">
                                        Full Description:
                                    </label>
                                    <textarea class="form-control product_field" id="full_description" name="full_description" rows="4"
                                        style="resize: none; overflow-y: scroll" required>{{ old('full_description', $productFind->full_description) }}</textarea>

                                    @error('full_description')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div>
                                    <label for="product_slug" class="form-label">
                                        SLUG: <span class="fw-bolder">[ SEO-Friendly URL ]</span>
                                    </label>
                                    <input type="text" class="form-control product_field" name="slug"
                                        value="{{ old('slug', $productFind->slug) }}">

                                    @error('slug')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        {{-- product information ends here --}}
                    </div>

                    <div class="col-md-5 p-1">
                        {{-- Categorization starts here --}}
                        <div class="card common_card p-2 mb-2">
                            <div class="card-header p-0 border-0">
                                <h3 class="card-title text-center fw-bold">Categorization</h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-5">
                                    <label for="category_id" class="form-label ms-1 pt-2">
                                        Category Select: <span class="text-danger" aria-hidden="true">*</span>
                                    </label>
                                    <select class="form-select" id="category_id" name="category_id" required>
                                        <option disabled selected hidden>Select Category</option>

                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $productFind->subcategory->category_id == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach

                                    </select>
                                    @error('category_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-1">
                                    <label for="subcategory_id" class="form-label ms-1 pt-1">
                                        Sub-category Select: <span class="text-danger" aria-hidden="true">*</span>
                                    </label>
                                    <select class="form-select" id="subcategory_id" name="subcategory_id" required>
                                        <option disabled selected hidden>Select Subcategory</option>

                                        @if (isset($subcategories) && $subcategories->count())
                                            @foreach ($subcategories as $sub)
                                                <option value="{{ $sub->id }}"
                                                    {{ old('subcategory_id', $productFind->subcategory_id) == $sub->id ? 'selected' : '' }}>
                                                    {{ $sub->subcategory_name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>

                                    @error('subcategory_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        {{-- Categorization ends here --}}

                        {{-- specification starts here --}}
                        <div class="card common_card p-2 mb-2">
                            <div class="card-header p-0 border-0 mb-2">
                                <h3 class="card-title text-center fw-bold">Specification</h3>
                            </div>
                            <div class="card-body">

                                <!-- Weight -->
                                <div class="mb-4">
                                    <label for="product_weight" class="form-label ms-1">Weight <strong>[ gm ]
                                            :</strong></label>

                                    <input type="number" class="form-control" id="product_weight" name="product_weight"
                                        step="0.001" min="0" placeholder="optional"
                                        value="{{ old('product_weight', $productFind->product_weight) }}">

                                    @if (empty(old('product_weight', $productFind->product_weight)))
                                        <small class="mt-1 ms-1 text-danger">Weight is not set.</small>
                                    @endif

                                    @error('product_weight')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- warenty -->
                                <div>
                                    <label for="warranty" class="form-label ms-1">Warranty:</label>

                                    <input type="text" class="form-control" id="warranty" name="warranty"
                                        placeholder="optional" value="{{ old('warranty', $productFind->warranty) }}">

                                    @if (empty(old('warranty', $productFind->warranty)))
                                        <small class="mt-1 ms-1 text-danger">Not available</small>
                                    @endif

                                    @error('warranty')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        {{-- specification ends here --}}
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-12 px-1">
                        {{-- product variant start here --}}
                        <div class="card common_card px-1 mb-1">
                            <div class="card-header p-0 border-0">
                                <h3 class="card-title text-center fw-bold">Product variant</h3>
                            </div>

                            <div class="card-body p-0">
                                <div class="row" style="margin-bottom: 70px;">
                                    <div class="col-md-6">
                                        <label for="brand_id" class="form-label ms-1">
                                            Brand
                                        </label>

                                        <select class="form-select" id="brand_id" name="brand_id">
                                            <option value="" hidden>
                                                Select Brand
                                            </option>

                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand->id }}"
                                                    {{ old('brand_id', $productFind->brand_id) == $brand->id ? 'selected' : '' }}>

                                                    {{ $brand->name }}

                                                </option>
                                            @endforeach
                                        </select>

                                        @error('brand_id')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="product_model_id" class="form-label ms-1">
                                            Model Select
                                        </label>

                                        <select class="form-select" id="product_model_id" name="product_model_id">
                                            <option value="" hidden>
                                                Select Model
                                            </option>

                                            @foreach ($product_models as $model)
                                                <option value="{{ $model->id }}"
                                                    {{ old('product_model_id', $productFind->product_model_id) == $model->id ? 'selected' : '' }}>

                                                    {{ $model->name }}

                                                </option>
                                            @endforeach
                                        </select>

                                        @error('product_model_id')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div id="variationWrapper">
                                    @foreach ($productFind->variants as $index => $variant)
                                        <input type="hidden" name="variant_id[]" value="{{ $variant->id }}">

                                        <div class="variation-block border rounded mb-1">
                                            <div class="d-flex align-items-center gap-2 border border-1 border-danger">
                                                <div style="display: flex; overflow-x: auto">
                                                    <div class="table-responsive table_horizontal_scroll">

                                                        <table class="table table-bordered align-middle mb-0"
                                                            style="table-layout: fixed; width: 100%;">
                                                            <thead>

                                                                <tr class="text-center">
                                                                    <th style="width: 16%">Color <span class="text-danger"
                                                                            aria-hidden="true">*</span></th>

                                                                    <th style="width: 16%">Size <span class="text-danger"
                                                                            aria-hidden="true">*</span></th>

                                                                    <th style="width: 19%">SKU</th>

                                                                    <th style="width: 19%">Regular price <span
                                                                            class="text-danger"
                                                                            aria-hidden="true">*</span>
                                                                    </th>

                                                                    <th style="width: 14%">Selling price</th>

                                                                    <th style="width: 16%">Stock quantity</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <select class="form-select" name="color_id[]">
                                                                            <option value="" disabled selected>
                                                                                Select Color
                                                                            </option>

                                                                            @foreach ($colors as $color)
                                                                                <option value="{{ $color->id }}"
                                                                                    {{ $variant->color_id == $color->id ? 'selected' : '' }}>
                                                                                    {{ $color->name }}
                                                                                </option>
                                                                            @endforeach

                                                                        </select>
                                                                    </td>

                                                                    <td>
                                                                        <select class="form-select" name="size_id[]">
                                                                            <option value="" disabled selected>
                                                                                Select Size
                                                                            </option>

                                                                            @foreach ($sizes as $size)
                                                                                <option value="{{ $size->id }}"
                                                                                    {{ $variant->size_id == $size->id ? 'selected' : '' }}>
                                                                                    {{ $size->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>

                                                                    <td>
                                                                        <input type="text" class="form-control"
                                                                            name="sku[]"
                                                                            value="{{ old('sku.' . $index, $variant->sku) }}">
                                                                    </td>

                                                                    <td>
                                                                        <input type="number" class="form-control"
                                                                            name="regular_price[]" min="0"
                                                                            step="0.01"
                                                                            value="{{ old('regular_price.' . $loop->index, $variant->regular_price) }}"
                                                                            required>
                                                                    </td>

                                                                    <td>
                                                                        <input type="number" class="form-control"
                                                                            name="selling_price[]" min="0"
                                                                            step="0.01"
                                                                            value="{{ old('selling_price.' . $loop->index, $variant->selling_price) }}"
                                                                            required>
                                                                    </td>

                                                                    <td>
                                                                        <input type="number" class="form-control"
                                                                            name="stock_quantity[]" min="0"
                                                                            value="{{ old('stock_quantity.' . $loop->index, $variant->stock_quantity) }}"
                                                                            required>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>

                                                        <table class="table table-bordered align-middle mb-0"
                                                            style="table-layout: fixed; width: 100%;">
                                                            <thead>
                                                                <tr class="text-center">
                                                                    <th style="width: 16%">Discount type</th>
                                                                    <th style="width: 16%">Discount value</th>
                                                                    <th style="width: 19%">Discount start</th>
                                                                    <th style="width: 19%">Discount end</th>
                                                                    <th style="width: 14%">Manage stock</th>
                                                                    <th style="width: 16%">Stock status</th>
                                                                </tr>

                                                            </thead>

                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <select class="form-select"
                                                                            name="discount_type[]">
                                                                            <option value="none"
                                                                                {{ old('discount_type.' . $index, $variant->discount_type) == 'none' ? 'selected' : '' }}>
                                                                                None
                                                                            </option>

                                                                            <option value="fixed"
                                                                                {{ old('discount_type.' . $index, $variant->discount_type) == 'fixed' ? 'selected' : '' }}>
                                                                                Fixed
                                                                            </option>

                                                                            <option value="percent"
                                                                                {{ old('discount_type.' . $index, $variant->discount_type) == 'percent' ? 'selected' : '' }}>
                                                                                Percent
                                                                            </option>
                                                                        </select>
                                                                    </td>

                                                                    <td>
                                                                        <input type="number"
                                                                            class="form-control product_field discount_value"
                                                                            name="discount_value[]" min="0"
                                                                            value="{{ old('discount_value.' . $index, $variant->discount_value) }}"
                                                                            placeholder="Active for Fixed and Percent">
                                                                    </td>

                                                                    <td>
                                                                        <input type="datetime-local" class="form-control"
                                                                            name="discount_start[]"
                                                                            value="{{ old('discount_start.' . $index, $variant->discount_start?->format('Y-m-d\TH:i')) }}">
                                                                    </td>

                                                                    <td>
                                                                        <input type="datetime-local" class="form-control"
                                                                            name="discount_end[]"
                                                                            value="{{ old('discount_end.' . $index, $variant->discount_end?->format('Y-m-d\TH:i')) }}">
                                                                    </td>

                                                                    <td>
                                                                        <select class="form-select" name="manage_stock[]">
                                                                            <option value="1"
                                                                                {{ old('manage_stock.' . $index, $variant->manage_stock) == 1 ? 'selected' : '' }}>
                                                                                Yes
                                                                            </option>
                                                                            <option value="0"
                                                                                {{ old('manage_stock.' . $index, $variant->manage_stock) == 0 ? 'selected' : '' }}>
                                                                                No
                                                                            </option>
                                                                        </select>
                                                                    </td>

                                                                    <td>
                                                                        <select class="form-select" name="stock_status[]">
                                                                            <option value="in_stock"
                                                                                {{ old('stock_status.' . $index, $variant->stock_status) == 'in_stock' ? 'selected' : '' }}>
                                                                                In Stock
                                                                            </option>

                                                                            <option value="out_of_stock"
                                                                                {{ old('stock_status.' . $index, $variant->stock_status) == 'out_of_stock' ? 'selected' : '' }}>
                                                                                Out Of Stock
                                                                            </option>
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                        {{-- product variant end here --}}
                    </div>
                </div>

                {{-- Media starts here --}}
                <div class="row">
                    <div class="col-md-7 px-1">
                        <div class="card common_card p-2 mb-2">
                            <div class="card-header p-0 border-0">
                                <h3 class="card-title text-center fw-bold">Media</h3>
                            </div>

                            <div class="card-body">
                                @php
                                    $images = $productFind->images ?? collect();
                                    $firstImage = $images->first();
                                @endphp
                                <!-- Image Upload -->
                                @include('partials.global_file.edit_file')

                                <!-- Video URL -->
                                <div class="mb-1">
                                    <label for="video_url" class="form-label ms-1">Video URL:</label>
                                    <input type="url" class="form-control" id="video_url" name="video_url"
                                        value="{{ old('video_url', $productFind->images->first()->video_url ?? '') }}">

                                    @if (!$productFind->images->first()?->video_url)
                                        <small class="text-danger ms-1">No video link available</small>
                                    @endif

                                    @error('video_url')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Visibility & Status starts here --}}
                        <div class="card common_card p-2 mb-2">
                            <div class="card-header p-0 border-0">
                                <h3 class="card-title text-center fw-bold">Visibility & Feature</h3>
                            </div>
                            <div class="card-body">
                                <!-- Visibility -->
                                <div style="margin-bottom: 60px;">
                                    <label for="visibility" class="form-label ms-1">Select Visibility:</label>
                                    <select name="visibility" class="form-select">
                                        <option value="visible"
                                            {{ old('visibility', $productFind->visibility) === 'visible' ? 'selected' : '' }}>
                                            Visible</option>
                                        <option value="hidden"
                                            {{ old('visibility', $productFind->visibility) === 'hidden' ? 'selected' : '' }}>
                                            Hidden</option>
                                    </select>
                                    @error('visibility')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div style="margin-bottom: 60px;">
                                    <label for="status" class="form-label ms-1">Select Status:</label>
                                    <select name="status" class="form-select">
                                        <option value="1"
                                            {{ old('status', $productFind->status) === 1 ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="0"
                                            {{ old('status', $productFind->status) === 0 ? 'selected' : '' }}>
                                            Inactive
                                        </option>
                                    </select>
                                    @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Featured -->
                                <div style="margin-bottom: 44px;">
                                    <label class="form-label ms-1 me-5">Featured:</label>

                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input border border-dark"
                                            id="featured_no" name="featured" value="0"
                                            {{ old('featured', $productFind->featured ?? 0) == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="featured_no">No</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input border border-dark"
                                            id="featured_yes" name="featured" value="1"
                                            {{ old('featured', $productFind->featured ?? 0) == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="featured_yes">Yes</label>
                                    </div>

                                    @error('featured')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        {{-- Visibility & Status ends here --}}

                    </div>

                    <div class="col-md-5 px-1">
                        {{-- SEO starts here --}}
                        <div class="card common_card p-2 pb-1 mb-2">
                            <div class="card-header p-0 border-0">
                                <h3 class="card-title text-center fw-bold">SEO</h3>
                            </div>
                            <div class="card-body">
                                <!-- Meta Title -->
                                <div class="mb-4">
                                    <label for="meta_title" class="form-label ms-1">
                                        Meta Title:
                                    </label>
                                    <textarea style="resize: none; overflow-y: scroll" id="meta_title" name="meta_title"
                                        class="form-control product_field" rows="6" placeholder="Enter meta title here...">{{ old('meta_title', $productFind->meta_title) }}</textarea>

                                    @if (empty(old('meta_title', $productFind->meta_title)))
                                        <small class="text-danger ms-1">Meta title is not set.</small>
                                    @endif

                                    @error('meta_title')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <!-- Meta Description -->
                                <div class="mb-4">
                                    <label for="meta_description" class="form-label ms-1">
                                        Meta Description:
                                    </label>

                                    <textarea id="meta_description" name="meta_description" class="form-control" rows="10"
                                        style="resize: none; overflow-y: scroll" placeholder="Enter meta description here...">{{ old('meta_description', $productFind->meta_description) }}</textarea>

                                    @if (empty(old('meta_description', $productFind->meta_description)))
                                        <small class="text-danger ms-1">Meta description is not set.</small>
                                    @endif

                                    @error('meta_description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- Meta Keywords -->
                                <div>
                                    <label for="meta_keywords" class="form-label ms-1">
                                        Meta Keywords:
                                    </label>
                                    <textarea style="resize: none; overflow-y: scroll" id="meta_keywords" name="meta_keywords"
                                        class="form-control product_field p-2" rows="6" placeholder="Enter comma-separated keywords">{{ old('meta_keywords', $productFind->meta_keywords) }}</textarea>

                                    @if (empty(old('meta_keywords', $productFind->meta_keywords)))
                                        <small class="text-danger ms-1">Meta keywords are not set.</small>
                                    @endif

                                    @error('meta_keywords')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        {{-- SEO ends here --}}
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-7"></div>
                    <div class="col-md-5">
                        <div class="card common_card border-0">
                            <div class="d-flex justify-content-between">
                                <button type="reset" class="btn btn-outline-danger">Reset</button>
                                <button type="submit" class="btn btn-outline-success">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </main>
@endsection

@include('custom_global_components.products.auto_generate')
