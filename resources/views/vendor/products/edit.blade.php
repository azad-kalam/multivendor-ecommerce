@extends('layouts.master_layout', ['title' => 'product edit'])
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
                                <a href="{{ route('admin.dashboard') }}">
                                    <span class="small">Home</span>
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

                <div class="m-2">
                    <form action="{{ route('vendor.products.update', $productFind->id) }}" id="editProductForm') }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-7 p-1">
                                {{-- product information starts here --}}
                                <div class="card p-2 mb-1">
                                    <div class="card-header p-0 border-0">
                                        <h3 class="card-title text-center fw-bold">Product Information</h3>
                                    </div>
                                    <div class="card-body">
                                        <!-- Name -->
                                        <div class="mb-4">
                                            <label for="name" class="form-label ms-1">
                                                Product Name:
                                            </label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ old('name', $productFind->name) }}" autocomplete="off">

                                            @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <!-- short description -->
                                        <div class="mb-4">
                                            <label for="short_description" class="form-label ms-1">Short
                                                Description:
                                            </label>
                                            <textarea class="form-control" id="short_description" name="short_description" rows="3"
                                                style="resize: none; overflow-y: scroll">{{ old('short_description', $productFind->short_description) }}
                                            </textarea>
                                            @error('short_description')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Full Description -->
                                        <div class="mb-3">
                                            <label for="full_description" class="form-label ms-1">
                                                Full Description:
                                            </label>
                                            <textarea class="form-control" id="full_description" name="full_description" rows="5"
                                                style="resize: none; overflow-y: scroll">{{ old('full_description', $productFind->full_description) }}
                                            </textarea>
                                            @error('full_description')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Slug -->
                                        <div class="form-group mb-3">
                                            <label for="slug" class="form-label ms-1">
                                                Slug: <span class="fw-bolder">[ SEO-Friendly URL ]</span>
                                            </label>
                                            <input type="text" class="form-control" id="slug" name="slug"
                                                value="{{ old('slug', $productFind->slug) }}">
                                            @error('slug')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- SKU -->
                                        <div class="form-group mb-4">
                                            <label for="product_sku" class="form-label">
                                                SKU: <span class="fw-bolder">[ Stock Keeping Unit ]</span>
                                            </label>
                                            <input type="text" class="form-control" id="product_sku" name="sku"
                                                value="{{ old('sku', $productFind->sku) }}">
                                            @error('sku')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                {{-- product information ends here --}}

                                {{-- Categorization starts here --}}
                                <div class="card p-2 mb-1">
                                    <div class="card-header p-0 border-0">
                                        <h3 class="card-title text-center fw-bold">Categorization</h3>
                                    </div>
                                    <div class="card-body">
                                        <!-- Category -->
                                        <div class="form-group mb-4">
                                            <label for="category_id" class="form-label ms-1 pt-2">Category
                                                Select:</label>
                                            <select class="form-select" id="category_id" name="category_id"
                                                aria-label="Category selection" required>
                                                <option value="{{ $productFind->subcategory->category->id }}">
                                                    {{ $productFind->subcategory->category->name }}
                                                </option>
                                            </select>
                                            @error('category_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- Subcategory -->
                                        <div class="form-group mb-4">
                                            <label for="subcategory_id" class="form-label ms-1 pt-2">
                                                Sub-category Select:
                                            </label>
                                            <select class="form-select" id="subcategory_id" name="subcategory_id"
                                                aria-label="Subcategory selection" required>
                                                <option class="hidden"
                                                    value="{{ old('subcategory_id', $productFind->subcategory->id) }}">
                                                    {{ $productFind->subcategory->subcategory_name }}
                                                </option>
                                            </select>
                                            @error('subcategory_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                {{-- Categorization ends here --}}

                                {{-- Media starts here --}}
                                <div class="card p-2 mb-1">
                                    <div class="card-header p-0 border-0">
                                        <h3 class="card-title text-center fw-bold">Media</h3>
                                    </div>

                                    <div class="card-body">
                                        <!-- Image Upload -->
                                        {{-- <div class="form-group mb-3">
                                            <label for="image_update" class="form-label ms-1">
                                                Image Choose:
                                            </label>

                                            <input type="file" class="form-control" id="image" name="image"
                                                accept="image/*" capture="camera">

                                            <small class="text-muted d-block mt-2">
                                                <span class="text-danger">Allowed:</span> [ JPG, JPEG, PNG, GIF, SVG,
                                                WEBP
                                                ].
                                                Maximum:
                                                2MB.
                                            </small>

                                            <div class="d-flex align-items-center justify-content-between">
                                                <!-- File Name -->
                                                <div class="mt-1">
                                                    <span class="text-danger" style="font-size: 15px;">File
                                                        name:</span>
                                                    <span>[</span>
                                                    <span id="updatefileNameText" class="text-primary"
                                                        style="font-size: 15px;">
                                                        {{ $productFind->images->first()->filename ?? 'No file' }}
                                                    </span>
                                                    <span>]</span>
                                                </div>

                                                @if (
                                                    !empty($productFind->images->first()?->public_path) &&
                                                        file_exists(public_path($productFind->images->first()->public_path)))
                                                    <div class="btn btn-outline-success p-1 border border-1 border-dark rounded"
                                                        style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">

                                                        <div id="updateimageDisplay"
                                                            data-old='
                                                            <img src="{{ asset($productFind->images->first()->public_path) }}"
                                                                style="width:50px; height:50px; border-radius: 5px;" alt="Image">
                                                        '>
                                                            <img src="{{ asset($productFind->images->first()->public_path) }}"
                                                                style="width:50px; height:50px; border-radius: 5px;"
                                                                alt="Image">
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="btn btn-outline-success p-1 border border-1 border-dark rounded"
                                                        style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                                                        <div id="updateimageDisplay"
                                                            data-old='<small class="text-danger">No Found</small>'>
                                                            <small class="text-danger">No Image</small>
                                                        </div>
                                                    </div>
                                                @endif

                                            </div>
                                            @error('image')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div> --}}

                                        @include('partials.global_file.edit_file')

                                        <!-- Video URL -->
                                        <div class="form-group mb-4">
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
                                {{-- Media ends here --}}

                                {{-- Visibility & Status starts here --}}
                                <div class="card p-2 mb-1">
                                    <div class="card-header p-0 border-0">
                                        <h3 class="card-title text-center fw-bold">Visibility & Status</h3>
                                    </div>
                                    <div class="card-body">
                                        <!-- Visibility -->
                                        <div class="mb-4">
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
                                        <div class="mb-4">
                                            <label for="status" class="form-label ms-1">Select Status:</label>
                                            <select name="status" class="form-select">
                                                <option value="1"
                                                    {{ old('status', $productFind->status) == 1 ? 'selected' : '' }}>
                                                    Active
                                                </option>
                                                <option value="0"
                                                    {{ old('status', $productFind->status) == 0 ? 'selected' : '' }}>
                                                    Inactive
                                                </option>
                                            </select>
                                            @error('status')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- Featured -->
                                        <div class="mb-4">
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

                                {{-- Inventory starts here --}}
                                <div class="card p-2 mb-1">
                                    <div class="card-header p-0 border-0">
                                        <h3 class="card-title text-center fw-bold">Inventory</h3>
                                    </div>
                                    <div class="card-body">
                                        <!-- Stock Quantity -->
                                        <div class="mb-4">
                                            <label for="stock_quantity" class="form-label ms-1">Stock
                                                Quantity:</label>
                                            <input type="number" class="form-control" id="stock_quantity"
                                                name="stock_quantity"
                                                value="{{ old('stock_quantity', $productFind->stock_quantity ?? 1) }}"
                                                min="1" required>
                                            @error('stock_quantity')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- Stock Status -->
                                        <div class="mb-4">
                                            <label for="stock_status" class="form-label ms-1">Stock Status:</label>
                                            <select name="stock_status" id="stock_status" class="form-select">
                                                <option value="in_stock"
                                                    {{ old('stock_status', $productFind->stock_status ?? 'in_stock') === 'in_stock' ? 'selected' : '' }}>
                                                    In Stock
                                                </option>
                                                <option value="out_of_stock"
                                                    {{ old('stock_status', $productFind->stock_status ?? 'in_stock') === 'out_of_stock' ? 'selected' : '' }}>
                                                    Out of Stock
                                                </option>
                                            </select>

                                            @error('stock_status')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- Manage Stock -->
                                        <div class="form-check mb-4">
                                            <input type="hidden" name="manage_stock" value="0">
                                            <!-- fallback -->

                                            <input type="checkbox" class="form-check-input border-2 border-danger p-2"
                                                id="manage_stock" name="manage_stock" value="1"
                                                {{ old('manage_stock', $productFind->manage_stock ?? false) ? 'checked' : '' }}>

                                            <label class="form-check-label ms-1" for="manage_stock">Manage
                                                Stock:</label>

                                            @error('manage_stock')
                                                <div id="manageStockError" class="text-danger mt-1">{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                {{-- Inventory ends here --}}
                            </div>

                            <div class="col-md-5 p-1">
                                {{-- pricing starts here --}}
                                <div class="card p-2 mb-1">
                                    <div class="card-header border-none p-0">
                                        <h3 class="card-title text-center fw-bold">Pricing</h3>
                                    </div>
                                    <div class="card-body">
                                        <!-- Regular Price-->
                                        <div class="mb-4">
                                            <label for="regular_price" class="form-label ms-1">
                                                Regular Price:
                                            </label>
                                            <input type="number" class="form-control" id="regular_price"
                                                name="regular_price"
                                                value="{{ old('regular_price', $productFind->price->regular_price ?? '') }}"
                                                step="0.01" min="0" required>
                                            @error('regular_price')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Selling Price-->
                                        <div class="mb-4">
                                            <label for="selling_price" class="form-label ms-1">
                                                Selling Price:
                                            </label>
                                            <input type="number" class="form-control" id="selling_price"
                                                name="selling_price"
                                                value="{{ old('selling_price', $productFind->price->selling_price ?? '') }}"
                                                step="0.01" min="0" required>
                                            @error('selling_price')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Discount value-->
                                        <div class="mb-5">
                                            <label for="discount_value" class="form-label ms-1">Discount
                                                Value:</label>
                                            <input type="number" class="form-control" id="discount_value"
                                                name="discount_value"
                                                value="{{ old('discount_value', $productFind->price->discount_value ?? '') }}"
                                                step="0.01" min="0">
                                            @error('discount_value')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Discount Type -->
                                        <fieldset class="mb-5 border-0">
                                            <legend class="form-label me-5 h6">Discount Type:</legend>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input border border-dark p-2" type="radio"
                                                    name="discount_type" id="discount_none" value="none"
                                                    {{ old('discount_type', 'none') == 'none' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="discount_none">None</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input border border-dark p-2" type="radio"
                                                    name="discount_type" id="discount_flat" value="flat"
                                                    {{ old('discount_type') == 'flat' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="discount_flat">Flat</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input border border-dark p-2" type="radio"
                                                    name="discount_type" id="discount_percent" value="percent"
                                                    {{ old('discount_type') == 'percent' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="discount_percent">Percent</label>
                                            </div>

                                            @error('discount_type')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </fieldset>

                                        <!-- Discount Start -->
                                         <div class="mb-4 pb-2">
                                            <label for="discount_start" class="form-label ms-1">Discount
                                                Start:</label>
                                            <input type="datetime-local" id="discount_start" name="discount_start"
                                                class="form-control"
                                                value="{{ \Carbon\Carbon::parse($productFind->price->discount_start)->format('Y-m-d\TH:i') }}">

                                            @if (empty($productFind->price->discount_start))
                                                <small class="mt-1 ms-1 text-danger">Data Empty.</small>
                                            @endif

                                            @error('discount_start')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <!-- Discount End -->
                                        <div class="mb-4">
                                            <label for="discount_end" class="form-label ms-1">Discount End:</label>
                                            <input type="datetime-local" id="discount_end" name="discount_end"
                                                class="form-control" placeholder="dd-mm-yyyy hh:mm AM/PM"
                                                value="{{ $productFind->price->discount_end ? \Carbon\Carbon::parse($productFind->price->discount_end)->format('Y-m-d\TH:i') : '' }}">

                                            @if (empty($productFind->price->discount_end))
                                                <small class="mt-1 ms-1 text-danger">Data Empty.</small>
                                            @endif
                                            @error('discount_end')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                {{-- pricing ends here --}}

                                {{-- specification starts here --}}
                                <div class="card p-2 mb-1">
                                    <div class="card-header p-0 border-none">
                                        <h3 class="card-title text-center fw-bold">Specification</h3>
                                    </div>
                                    <div class="card-body">
                                        <!-- Brand -->
                                        <div class="mb-4">
                                            <label for="brand" class="form-label ms-1">Brand:</label>

                                            @if (!empty($productFind->brand))
                                                <input type="text" class="form-control" id="brand" name="brand"
                                                    placeholder="optional"
                                                    value="{{ old('brand', $productFind->brand) }}">
                                            @else
                                                <small class="mt-1 ms-1 text-danger">Brand is not set.</small>
                                            @endif

                                            @error('brand')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <!-- Model -->
                                        <div class="mb-4">
                                            <label for="model" class="form-label ms-1">Model:</label>

                                            <input type="text" class="form-control" id="model" name="model"
                                                placeholder="optional" value="{{ old('model', $productFind->model) }}">

                                            @if (empty($productFind->model))
                                                <small class="mt-1 ms-1 text-danger">Model is not set.</small>
                                            @endif

                                            @error('model')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <!-- Size -->
                                        <div class="mb-4">
                                            <label for="size" class="form-label ms-1">Select Size:</label>

                                            <select name="size" class="form-select" id="size">
                                                <option value="" disabled
                                                    {{ old('size', $productFind->size) ? '' : 'selected' }}>
                                                    Select any size (Optional)
                                                </option>
                                                <option value="free"
                                                    {{ old('size', $productFind->size) === 'free' ? 'selected' : '' }}>
                                                    Free
                                                </option>
                                                <option value="small"
                                                    {{ old('size', $productFind->size) === 'small' ? 'selected' : '' }}>
                                                    S
                                                </option>
                                                <option value="medium"
                                                    {{ old('size', $productFind->size) === 'medium' ? 'selected' : '' }}>
                                                    M
                                                </option>
                                                <option value="large"
                                                    {{ old('size', $productFind->size) === 'large' ? 'selected' : '' }}>
                                                    L
                                                </option>
                                                <option value="xlarge"
                                                    {{ old('size', $productFind->size) === 'xlarge' ? 'selected' : '' }}>
                                                    XL
                                                </option>
                                                <option value="xxlarge"
                                                    {{ old('size', $productFind->size) === 'xxlarge' ? 'selected' : '' }}>
                                                    XXL
                                                </option>
                                            </select>

                                            @if (empty(old('size', $productFind->size)))
                                                <small class="mt-1 ms-1 text-danger">Size is not set.</small>
                                            @endif

                                            @error('size')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- Color -->
                                        <div class="mb-4">
                                            <label for="color" class="form-label ms-1">Select Color:</label>

                                            @php
                                                $colors = [
                                                    'aliceblue',
                                                    'antiquewhite',
                                                    'aqua',
                                                    'aquamarine',
                                                    'azure',
                                                    'beige',
                                                    'bisque',
                                                    'black',
                                                    'blanchedalmond',
                                                    'blue',
                                                    'blueviolet',
                                                    'brown',
                                                    'burlywood',
                                                    'cadetblue',
                                                    'chartreuse',
                                                    'chocolate',
                                                    'coral',
                                                    'cornflowerblue',
                                                    'cornsilk',
                                                    'crimson',
                                                    'cyan',
                                                    'darkblue',
                                                    'darkcyan',
                                                    'darkgoldenrod',
                                                    'darkgray',
                                                    'darkgreen',
                                                    'darkkhaki',
                                                    'darkmagenta',
                                                    'darkolivegreen',
                                                    'darkorange',
                                                    'darkorchid',
                                                    'darkred',
                                                    'darksalmon',
                                                    'darkseagreen',
                                                    'darkslateblue',
                                                    'darkslategray',
                                                    'darkturquoise',
                                                    'darkviolet',
                                                    'deeppink',
                                                    'deepskyblue',
                                                    'dimgray',
                                                    'dodgerblue',
                                                    'firebrick',
                                                    'floralwhite',
                                                    'forestgreen',
                                                    'fuchsia',
                                                    'gainsboro',
                                                    'ghostwhite',
                                                    'gold',
                                                    'goldenrod',
                                                    'gray',
                                                    'greenyellow',
                                                    'honeydew',
                                                    'hotpink',
                                                    'indianred',
                                                    'indigo',
                                                    'ivory',
                                                    'khaki',
                                                    'lavender',
                                                    'lavenderblush',
                                                    'lawngreen',
                                                    'lemonchiffon',
                                                    'lightblue',
                                                    'lightcoral',
                                                    'lightcyan',
                                                    'lightgoldenrodyellow',
                                                    'lightgray',
                                                    'lightgreen',
                                                    'lightpink',
                                                    'lightsalmon',
                                                    'lightseagreen',
                                                    'lightskyblue',
                                                    'lightslategray',
                                                    'lightsteelblue',
                                                    'lightyellow',
                                                    'lime',
                                                    'limegreen',
                                                    'linen',
                                                    'magenta',
                                                    'mediumaquamarine',
                                                    'mediumblue',
                                                    'mediumorchid',
                                                    'mediumpurple',
                                                    'mediumseagreen',
                                                    'mediumslateblue',
                                                    'mediumspringgreen',
                                                    'mediumturquoise',
                                                    'mediumvioletred',
                                                    'midnightblue',
                                                    'mintcream',
                                                    'mistyrose',
                                                    'moccasin',
                                                    'navajowhite',
                                                    'oldlace',
                                                    'olive',
                                                    'olivedrab',
                                                    'orange',
                                                    'orangered',
                                                    'orchid',
                                                    'palegoldenrod',
                                                    'palegreen',
                                                    'paleturquoise',
                                                    'palevioletred',
                                                    'papayawhip',
                                                    'peachpuff',
                                                    'peru',
                                                    'pink',
                                                    'plum',
                                                    'powderblue',
                                                    'purple',
                                                    'rebeccapurple',
                                                    'red',
                                                    'rosybrown',
                                                    'royalblue',
                                                    'saddlebrown',
                                                    'salmon',
                                                    'sandybrown',
                                                    'seashell',
                                                    'sienna',
                                                    'silver',
                                                    'skyblue',
                                                    'slateblue',
                                                    'slategray',
                                                    'snow',
                                                    'springgreen',
                                                    'steelblue',
                                                    'tan',
                                                    'teal',
                                                    'thistle',
                                                    'tomato',
                                                    'turquoise',
                                                    'violet',
                                                    'wheat',
                                                    'white',
                                                    'whitesmoke',
                                                    'yellow',
                                                    'yellowgreen',
                                                ];
                                                $selectedColor = old('color', $productFind->color);
                                            @endphp

                                            <select class="form-select" id="color" name="color">
                                                <option value="" disabled
                                                    {{ empty($selectedColor) ? 'selected' : '' }}>
                                                    Select any color (Optional)
                                                </option>

                                                @foreach ($colors as $color)
                                                    <option value="{{ $color }}"
                                                        {{ $selectedColor === $color ? 'selected' : '' }}>
                                                        {{ ucwords(str_replace('-', ' ', $color)) }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            @if (empty($selectedColor))
                                                <small class="mt-1 ms-1 text-danger">Color is not set.</small>
                                            @endif

                                            @error('color')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <!-- Weight -->
                                        <div class="mb-4">
                                            <label for="product_weight" class="form-label ms-1">Weight <strong>[ gm ]
                                                    :</strong></label>

                                            <input type="number" class="form-control" id="product_weight"
                                                name="product_weight" step="0.001" min="0"
                                                placeholder="optional"
                                                value="{{ old('product_weight', $productFind->product_weight) }}">

                                            @if (empty(old('product_weight', $productFind->product_weight)))
                                                <small class="mt-1 ms-1 text-danger">Weight is not set.</small>
                                            @endif

                                            @error('product_weight')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <!-- warenty -->
                                        <div class="mb-4">
                                            <label for="warranty" class="form-label ms-1">Warranty:</label>

                                            <input type="text" class="form-control" id="warranty" name="warranty"
                                                placeholder="optional"
                                                value="{{ old('warranty', $productFind->warranty) }}">

                                            @if (empty(old('warranty', $productFind->warranty)))
                                                <small class="mt-1 ms-1 text-danger">Warranty is not set.</small>
                                            @endif

                                            @error('warranty')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                {{-- specification ends here --}}

                                {{-- SEO starts here --}}
                               <div class="card p-2 pb-1 mb-2">
                                    <div class="card-header p-0 border-0">
                                        <h3 class="card-title text-center fw-bold">SEO</h3>
                                    </div>
                                    <div class="card-body">
                                        <!-- Meta Title -->
                                        <div class="mb-4">
                                            <label for="meta_title" class="form-label ms-1">
                                                Meta Title:
                                            </label>
                                            <textarea style="resize: none; overflow-y: scroll" id="meta_title" name="meta_title" class="form-control" rows="5" required
                                                placeholder="Enter meta title here...">{{ old('meta_title', $productFind->meta_title) }}</textarea>

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

                                            <textarea id="meta_description" name="meta_description" class="form-control" rows="7" required
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
                                            <textarea style="resize: none; overflow-y: scroll" id="meta_keywords" name="meta_keywords" class="form-control p-2" rows="5"
                                                required placeholder="Enter comma-separated keywords">{{ old('meta_keywords', $productFind->meta_keywords) }}</textarea>

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


                                <!-- Submit Button -->
                                <div class="d-flex justify-content-between mx-2">
                                    <button type="reset" class="btn btn-danger">Cancel</button>
                                    <button type="submit" class="btn btn-success">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
