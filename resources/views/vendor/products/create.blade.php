@extends('layouts.master_layout', ['title' => 'product create'])
@section('content')
    @include('inc.headers.vendor.vendor_header')
    @include('inc.asidebar.admin.admin_asidebar')
    <main id="main">
        <div class="row">
            <div class="col-12">
                <div class="mt-3 p-2">
                    <div class="pagetitle">
                        <span class="btn btn-outline-secondary p-1 text-capitalize video-thumbnail">
                            {{ Auth::check() ? Auth::user()->role : 'Guest' }}
                        </span>
                        <nav aria-label="breadcrumb" class="d-flex my-1">
                            <ol class="breadcrumb m-0 mb-1">

                                <!-- Dashboard Breadcrumb -->
                                <li class="breadcrumb-item">
                                    <a href="{{ route('vendor.dashboard') }}">
                                        <span class="small">Dashboard</span>
                                    </a>
                                </li>

                                <!-- Products Breadcrumb -->
                                <li class="breadcrumb-item active" aria-current="page">
                                    <a href="{{ route('vendor.products.index') }}">
                                        <span class="small">Products</span>
                                    </a>
                                </li>

                                <!-- Active Breadcrumb -->
                                <li class="breadcrumb-item active" aria-current="page">
                                    <span>Add</span>
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
                        <h1 class="table-heading">Add New Product</h1>
                    </div>
                    <div class="mt-2">
                        <form action="{{ route('vendor.products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-7 p-1">
                                    {{-- product information starts here --}}
                                    <div class="card p-2 mb-1">
                                        <div class="card-header p-0 border-0">
                                            <h3 class="card-title text-center fw-bold">Product information</h3>
                                        </div>
                                        <div class="card-body">
                                            <!-- Name -->
                                            <div class="mb-4">
                                                <label for="product_name" class="form-label">
                                                    Product Name: <span class="text-danger" aria-hidden="true">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="product_name" name="name"
                                                    autocomplete="off" required oninput="slugGenerateFromName()">

                                                @error('name')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- short description -->
                                            <div class="mb-4">
                                                <label for="short_description" class="form-label">Short Description:
                                                    <span class="text-danger" aria-hidden="true">*</span>
                                                </label>
                                                <textarea class="form-control" id="short_description" name="short_description" rows="3"
                                                    style="resize: none; overflow-y: scroll" required></textarea>
                                                @error('short_description')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Full Description -->
                                            <div class="mb-4">
                                                <label for="full_description" class="form-label">
                                                    Full Description: <span class="text-danger" aria-hidden="true">*</span>
                                                </label>
                                                <textarea class="form-control" id="full_description" name="full_description" rows="5"
                                                    style="resize: none; overflow-y: scroll" required></textarea>
                                                @error('full_description')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Slug -->
                                            <div class="form-group mb-3">
                                                <label for="product_slug" class="form-label">
                                                    SLUG: <span class="fw-bolder">[ SEO-Friendly URL ]</span>
                                                </label>
                                                <input type="text" class="form-control product_field" id="product_slug"
                                                    name="slug" readonly>
                                                @error('slug')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- SKU -->
                                            <div class="form-group mb-4">
                                                <label for="product_sku" class="form-label">
                                                    SKU: <span class="fw-bolder">[ Stock Keeping Unit ]</span>
                                                </label>
                                                <input type="text" class="form-control" id="product_sku" name="sku">
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
                                                <label for="category_id" class="form-label pt-2">
                                                    Select Category: <span class="text-danger">*</span>
                                                </label>
                                                <select class="form-select" id="category_id" name="category_id" required>
                                                    <option disabled selected hidden>select any item</option>
                                                    @foreach ($categorieIdName as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('category_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- Subcategory -->
                                            <div class="form-group mb-4">
                                                <label for="subcategory_id" class="form-label pt-2">
                                                    Select Sub-category: <span class="text-danger">*</span>
                                                </label>
                                                <select class="form-select" id="subcategory_id" name="subcategory_id"
                                                    required>
                                                    <option disabled selected hidden>select any item</option>
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
                                            <!-- Choose Image Upload -->
                                            {{-- <div class="form-group mb-4">
                                                <label for="product_image" class="form-label ms-1">
                                                    Choose File: <span class="text-danger" aria-hidden="true">*</span>
                                                </label>
                                                <input type="file" class="form-control" id="product_image"
                                                    name="image[]" accept="image/*" capture="camera" multiple required>

                                                @error('image')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror

                                                <!-- File Allowed Info -->
                                                <div class="d-flex mt-2">
                                                    <small class="text-success mx-1">
                                                        <span class="text-danger" style="font-size: 14px;">Allowed:</span>
                                                        <b class="text-danger">[</b>
                                                        <span style="font-size: 13px;">JPG, JPEG, PNG, GIF, SVG, WEBP
                                                        </span>
                                                        <b class="text-danger">].</b>
                                                        Maximum: 2 MB.
                                                    </small>
                                                </div>

                                                <div class="d-flex align-items-center justify-content-between">
                                                    <!-- File name -->
                                                    <div>
                                                        <span class="text-danger" style="font-size: 14px;">
                                                            Filename:
                                                        </span>
                                                        <b class="text-danger">[</b>
                                                        <span id="fileNameText" class="text-primary"
                                                            style="font-size: 14px;">
                                                            No file
                                                        </span>
                                                        <b class="text-danger">]</b>
                                                    </div>

                                                    <!-- Image display -->
                                                    <div id="imageDisplay"
                                                        style="width:60px; height:60px; border-radius: 5px;"
                                                        class="btn btn-outline-success p-1 border border-1 border-dark d-flex align-items-center text-center justify-content-center">
                                                    </div>
                                                </div>

                                                @error('image')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div> --}}

                                            @include('partials.global_file.create_file')

                                            <!-- Video URL -->
                                            <div class="mb-4">
                                                <label for="video_url" class="form-label">Video URL:</label>
                                                <input type="url" class="form-control" id="video_url"
                                                    name="video_url" placeholder="optional">
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
                                                <label for="product_visibility" class="form-label">Select
                                                    Visibility:</label>
                                                <select name="visibility" id="product_visibility" class="form-select">
                                                    <option value="visible" selected>Visible</option>
                                                    <option value="hidden">Hidden</option>
                                                </select>
                                                @error('visibility')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- Status -->
                                            <div class="mb-4">
                                                <label for="product_status" class="form-label">Select Status:</label>
                                                <select name="status" id="product_status" class="form-select">
                                                    <option value="1" selected>Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                                @error('status')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- Featured -->
                                            {{-- <fieldset class="mb-4">
                                                <legend class="form-label me-5 h6">Featured:</legend>

                                                <div class="form-check form-check-inline">
                                                    <input type="radio" class="form-check-input border border-dark p-2"
                                                        id="featured_no" name="featured" value="0" checked>
                                                    <label class="form-check-label" for="featured_no">No</label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input type="radio" class="form-check-input border border-dark p-2"
                                                        id="featured_yes" name="featured" value="1">
                                                    <label class="form-check-label" for="featured_yes">Yes</label>
                                                </div>

                                                @error('featured')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </fieldset> --}}

                                            <!-- Featured -->
                                            <div class="mb-4">
                                                <label class="form-label me-5">Featured:</label>

                                                <div class="form-check form-check-inline">
                                                    <input type="radio"
                                                        class="form-check-input border border-dark product_field"
                                                        id="featured_no" name="featured" value="0" checked>
                                                    <label class="form-check-label" for="featured_no">No</label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input type="radio"
                                                        class="form-check-input border border-dark product_field"
                                                        id="featured_yes" name="featured" value="1">
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
                                                <label for="stock_quantity" class="form-label">Stock Quantity:</label>
                                                <input type="number" class="form-control" id="stock_quantity"
                                                    name="stock_quantity" min="1" required>
                                                @error('stock_quantity')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- Stock Status -->
                                            <div class="mb-4">
                                                <label for="stock_status" class="form-label">Stock Status:</label>
                                                <select name="stock_status" id="stock_status" class="form-select">
                                                    <option value="in_stock" selected>In Stock</option>
                                                    <option value="out_of_stock">Out of Stock</option>
                                                </select>

                                                @error('stock_status')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- Manage Stock -->
                                            <div class="form-check mb-3">
                                                <input type="checkbox" class="form-check-input border-2 border-danger p-2"
                                                    id="manage_stock" name="manage_stock" value="1">
                                                <label class="form-check-label ms-1" for="manage_stock">
                                                    Manage Stock
                                                </label>
                                                @error('manage_stock')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Inventory ends here --}}
                                </div>

                                <div class="col-md-5 p-1">
                                    {{-- pricing starts here --}}
                                    <div class="card p-2 mb-1">
                                    <div class="card-header border-0 p-0">
                                            <h3 class="card-title text-center fw-bold">Pricing</h3>
                                        </div>
                                        <div class="card-body">
                                            <!-- Regular Price-->
                                            <div class="mb-4">
                                                <label for="regular_price" class="form-label">
                                                    Regular Price: <span class="text-danger" aria-hidden="true">*</span>
                                                </label>
                                                <input type="number" class="form-control" id="regular_price"
                                                    name="regular_price" step="0.01" min="0" required>
                                                @error('regular_price')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Selling Price-->
                                            <div class="mb-4">
                                                <label for="selling_price" class="form-label">
                                                    Selling Price: <span class="text-danger">*</span>
                                                </label>
                                                <input type="number" class="form-control" id="selling_price"
                                                    name="selling_price" step="0.01" min="0" required>
                                                @error('selling_price')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Discount Type -->
                                            <fieldset class="mb-4 border-0">
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

                                            {{-- discount value --}}
                                           <div class="form-group mb-5">
                                                <label for="discount_value" class="form-label">Discount Value</label>

                                                <input type="number" class="form-control product_field"
                                                    id="discount_value" name="discount_value" min="0">

                                                <small class="text-success d-block mt-1">
                                                    Enter percentage if percent is selected, Or fixed amount if flat.
                                                </small>

                                                @error('discount_value')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Discount Start -->
                                         <div class="mb-4 pb-2">
                                                <label for="discount_start" class="form-label">Discount Start:</label>
                                                <input type="datetime-local" id="discount_start" name="discount_start"
                                                    class="form-control" placeholder="dd-mm-yyyy hh:mm AM/PM">
                                                @error('discount_start')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- Discount End -->
                                            <div class="mb-4">
                                                <label for="discount_end" class="form-label">Discount End:</label>
                                                <input type="datetime-local" id="discount_end" name="discount_end"
                                                    class="form-control" placeholder="dd-mm-yyyy hh:mm AM/PM">
                                                @error('discount_end')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    {{-- pricing ends here --}}

                                    {{-- specification starts here --}}
                                  <div class="card p-2 mb-2">
                                    <div class="card-header p-0 border-0 mb-2">
                                            <h3 class="card-title text-center fw-bold">Specification</h3>
                                        </div>
                                        <div class="card-body">
                                            <!-- Brand -->
                                            <div class="mb-4">
                                                <label for="brand" class="form-label">Brand:</label>
                                                <input type="text" class="form-control" id="brand" name="brand"
                                                    placeholder="optional">
                                                @error('brand')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- Model -->
                                            <div class="mb-4">
                                                <label for="model" class="form-label">Model:</label>
                                                <input type="text" class="form-control" id="model" name="model"
                                                    placeholder="optional">
                                                @error('model')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- Size -->
                                            <div class="mb-4">
                                                <label for="size" class="form-label">Select Size:</label>
                                                <select name="size" class="form-select" id="size">
                                                    <option selected hidden disabled>Select any size</option>
                                                    <option value="free">Free</option>
                                                    <option value="small">S</option>
                                                    <option value="medium">M</option>
                                                    <option value="large">L</option>
                                                    <option value="xlarge">XL</option>
                                                    <option value="xxlarge">XXL</option>
                                                </select>
                                                @error('size')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- Color -->
                                            <div class="mb-4">
                                                <label for="color" class="form-label">Select Color:</label>
                                                <select class="form-select" id="color" name="color">
                                                    <option selected hidden disabled>select any color</option>
                                                    <option value="aliceblue">AliceBlue</option>
                                                    <option value="antiquewhite">AntiqueWhite</option>
                                                    <option value="aqua">Aqua</option>
                                                    <option value="aquamarine">Aquamarine</option>
                                                    <option value="azure">Azure</option>
                                                    <option value="beige">Beige</option>
                                                    <option value="bisque">Bisque</option>
                                                    <option value="black">Black</option>
                                                    <option value="blanchedalmond">BlanchedAlmond</option>
                                                    <option value="blue">Blue</option>
                                                    <option value="blueviolet">BlueViolet</option>
                                                    <option value="brown">Brown</option>
                                                    <option value="burlywood">Burlywood</option>
                                                    <option value="cadetblue">CadetBlue</option>
                                                    <option value="chartreuse">Chartreuse</option>
                                                    <option value="chocolate">Chocolate</option>
                                                    <option value="coral">Coral</option>
                                                    <option value="cornflowerblue">CornflowerBlue</option>
                                                    <option value="cornsilk">Cornsilk</option>
                                                    <option value="crimson">Crimson</option>
                                                    <option value="cyan">Cyan</option>
                                                    <option value="darkblue">DarkBlue</option>
                                                    <option value="darkcyan">DarkCyan</option>
                                                    <option value="darkgoldenrod">DarkGoldenrod</option>
                                                    <option value="darkgray">DarkGray</option>
                                                    <option value="darkgreen">DarkGreen</option>
                                                    <option value="darkkhaki">DarkKhaki</option>
                                                    <option value="darkmagenta">DarkMagenta</option>
                                                    <option value="darkolivegreen">DarkOliveGreen</option>
                                                    <option value="darkorange">DarkOrange</option>
                                                    <option value="darkorchid">DarkOrchid</option>
                                                    <option value="darkred">DarkRed</option>
                                                    <option value="darksalmon">DarkSalmon</option>
                                                    <option value="darkseagreen">DarkSeaGreen</option>
                                                    <option value="darkslateblue">DarkSlateBlue</option>
                                                    <option value="darkslategray">DarkSlateGray</option>
                                                    <option value="darkturquoise">DarkTurquoise</option>
                                                    <option value="darkviolet">DarkViolet</option>
                                                    <option value="deeppink">DeepPink</option>
                                                    <option value="deepskyblue">DeepSkyBlue</option>
                                                    <option value="dimgray">DimGray</option>
                                                    <option value="dodgerblue">DodgerBlue</option>
                                                    <option value="firebrick">FireBrick</option>
                                                    <option value="floralwhite">FloralWhite</option>
                                                    <option value="forestgreen">ForestGreen</option>
                                                    <option value="fuchsia">Fuchsia</option>
                                                    <option value="gainsboro">Gainsboro</option>
                                                    <option value="ghostwhite">GhostWhite</option>
                                                    <option value="gold">Gold</option>
                                                    <option value="goldenrod">Goldenrod</option>
                                                    <option value="gray">Gray</option>
                                                    <option value="greenyellow">GreenYellow</option>
                                                    <option value="honeydew">Honeydew</option>
                                                    <option value="hotpink">HotPink</option>
                                                    <option value="indianred">IndianRed</option>
                                                    <option value="indigo">Indigo</option>
                                                    <option value="ivory">Ivory</option>
                                                    <option value="khaki">Khaki</option>
                                                    <option value="lavender">Lavender</option>
                                                    <option value="lavenderblush">LavenderBlush</option>
                                                    <option value="lawngreen">LawnGreen</option>
                                                    <option value="lemonchiffon">LemonChiffon</option>
                                                    <option value="lightblue">LightBlue</option>
                                                    <option value="lightcoral">LightCoral</option>
                                                    <option value="lightcyan">LightCyan</option>
                                                    <option value="lightgoldenrodyellow">LightGoldenrodYellow</option>
                                                    <option value="lightgray">LightGray</option>
                                                    <option value="lightgreen">LightGreen</option>
                                                    <option value="lightpink">LightPink</option>
                                                    <option value="lightsalmon">LightSalmon</option>
                                                    <option value="lightseagreen">LightSeaGreen</option>
                                                    <option value="lightskyblue">LightSkyBlue</option>
                                                    <option value="lightslategray">LightSlateGray</option>
                                                    <option value="lightsteelblue">LightSteelBlue</option>
                                                    <option value="lightyellow">LightYellow</option>
                                                    <option value="lime">Lime</option>
                                                    <option value="limegreen">LimeGreen</option>
                                                    <option value="linen">Linen</option>
                                                    <option value="magenta">Magenta</option>
                                                    <option value="mediumaquamarine">MediumAquamarine</option>
                                                    <option value="mediumblue">MediumBlue</option>
                                                    <option value="mediumorchid">MediumOrchid</option>
                                                    <option value="mediumpurple">MediumPurple</option>
                                                    <option value="mediumseagreen">MediumSeaGreen</option>
                                                    <option value="mediumslateblue">MediumSlateBlue</option>
                                                    <option value="mediumspringgreen">MediumSpringGreen</option>
                                                    <option value="mediumturquoise">MediumTurquoise</option>
                                                    <option value="mediumvioletred">MediumVioletRed</option>
                                                    <option value="midnightblue">MidnightBlue</option>
                                                    <option value="mintcream">MintCream</option>
                                                    <option value="mistyrose">MistyRose</option>
                                                    <option value="moccasin">Moccasin</option>
                                                    <option value="navajowhite">NavajoWhite</option>
                                                    <option value="oldlace">OldLace</option>
                                                    <option value="olive">Olive</option>
                                                    <option value="olivedrab">OliveDrab</option>
                                                    <option value="orange">Orange</option>
                                                    <option value="orangered">OrangeRed</option>
                                                    <option value="orchid">Orchid</option>
                                                    <option value="palegoldenrod">PaleGoldenrod</option>
                                                    <option value="palegreen">PaleGreen</option>
                                                    <option value="paleturquoise">PaleTurquoise</option>
                                                    <option value="palevioletred">PaleVioletRed</option>
                                                    <option value="papayawhip">PapayaWhip</option>
                                                    <option value="peachpuff">PeachPuff</option>
                                                    <option value="peru">Peru</option>
                                                    <option value="pink">Pink</option>
                                                    <option value="plum">Plum</option>
                                                    <option value="powderblue">PowderBlue</option>
                                                    <option value="purple">Purple</option>
                                                    <option value="rebeccapurple">RebeccaPurple</option>
                                                    <option value="red">Red</option>
                                                    <option value="rosybrown">RosyBrown</option>
                                                    <option value="royalblue">RoyalBlue</option>
                                                    <option value="saddlebrown">SaddleBrown</option>
                                                    <option value="salmon">Salmon</option>
                                                    <option value="sandybrown">SandyBrown</option>
                                                    <option value="seashell">Seashell</option>
                                                    <option value="sienna">Sienna</option>
                                                    <option value="silver">Silver</option>
                                                    <option value="skyblue">SkyBlue</option>
                                                    <option value="slateblue">SlateBlue</option>
                                                    <option value="slategray">SlateGray</option>
                                                    <option value="snow">Snow</option>
                                                    <option value="springgreen">SpringGreen</option>
                                                    <option value="steelblue">SteelBlue</option>
                                                    <option value="tan">Tan</option>
                                                    <option value="teal">Teal</option>
                                                    <option value="thistle">Thistle</option>
                                                    <option value="tomato">Tomato</option>
                                                    <option value="turquoise">Turquoise</option>
                                                    <option value="violet">Violet</option>
                                                    <option value="wheat">Wheat</option>
                                                    <option value="white">White</option>
                                                    <option value="whitesmoke">WhiteSmoke</option>
                                                    <option value="yellow">Yellow</option>
                                                    <option value="yellowgreen">YellowGreen</option>
                                                </select>
                                                @error('color')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- Weight -->
                                            <div class="mb-4">
                                                <label for="product_weight" class="form-label">Weight <strong>[ gm ]
                                                        :</strong></label>
                                                <input type="number" class="form-control" id="product_weight"
                                                    name="product_weight" step="0.001" min="0"
                                                    placeholder="optional">
                                                @error('product_weight')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- warenty -->
                                            <div class="mb-4">
                                                <label for="warranty" class="form-label">Warranty:</label>
                                                <input type="text" class="form-control" id="warranty"
                                                    name="warranty" placeholder="optional">
                                                @error('warranty')
                                                    <span class="text-danger">{{ $message }}</span>
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
                                                    Meta Title: <span class="text-danger" aria-hidden="true">*</span>
                                                </label>
                                                <textarea style="resize: none; overflow-y: scroll" id="meta_title" name="meta_title" class="form-control"
                                                    rows="5" required placeholder="Enter meta title here..."></textarea>

                                                @error('meta_title')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <!-- Meta Description -->
                                            <div class="mb-4">
                                                <label for="meta_description" class="form-label ms-1">
                                                    Meta Description: <span class="text-danger"
                                                        aria-hidden="true">*</span>
                                                </label>

                                                <textarea id="meta_description" name="meta_description" class="form-control" rows="6" required
                                                    style="resize: none; overflow-y: scroll" placeholder="Enter meta description here..."></textarea>

                                                @error('meta_description')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- Meta Keywords -->
                                            <div>
                                                <label for="meta_keywords" class="form-label ms-1">
                                                    Meta Keywords: <span class="text-danger" aria-hidden="true">*</span>
                                                </label>

                                                <textarea style="resize: none; overflow-y: scroll" id="meta_keywords" name="meta_keywords" class="form-control p-2"
                                                    rows="5" required placeholder="Enter meta keywords comma-separated here..."></textarea>

                                                @error('meta_keywords')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    {{-- SEO ends here --}}

                                    <!-- Submit Button -->
                                    <div class="d-flex justify-content-between mx-2">
                                        <button type="reset" class="btn btn-outline-danger">Cancel</button>
                                        <button type="submit" class="btn btn-outline-success">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

<script>
    function slugGenerateFromName() {
        let name = document.getElementById('product_name').value;
        if (name == '') {
            document.getElementById('product_slug').value = '';
            return;
        }
        let slugGenerate = name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
        let random11String = Math.random().toString(36).substring(2, 13); // 11 character random
        let randomSlugGenerate = document.getElementById('product_slug').value = slugGenerate + '-' + random11String;
    }
</script>
