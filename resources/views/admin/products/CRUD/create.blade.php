@extends('layouts.master_layout', ['title' => 'product create'])
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
                                <a href="{{ route('admin.products.CRUD.index') }}">
                                    <span class="small">Products</span>
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <span>Add</span>
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

                <div class="text-center mb-3">
                    <h1 class="table-heading">Add New Product</h1>
                </div>
                <div class="m-2">
                    <form action="{{ route('admin.products.CRUD.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

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
                                                name="name" value="{{ old('name') }}" placeholder="Enter product name"
                                                autocomplete="off" required>

                                            @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-4">
                                            <label for="short_description" class="form-label">
                                                Short Description:
                                            </label>
                                            <textarea class="form-control product_field" placeholder="Enter short description" id="short_description"
                                                name="short_description" rows="3" style="resize: none; overflow-y: scroll"></textarea>

                                            @error('short_description')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-4">
                                            <label for="full_description" class="form-label">
                                                Full Description:
                                            </label>
                                            <textarea class="form-control product_field" placeholder="Enter full description" id="full_description"
                                                name="full_description" rows="4" style="resize: none; overflow-y: scroll"></textarea>

                                            @error('full_description')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="product_slug" class="form-label">
                                                SLUG: <span class="text-danger" aria-hidden="true">*</span> <span
                                                    class="fw-bolder">[ SEO-Friendly URL ]</span>
                                            </label>
                                            <input type="text" class="form-control product_field" id="product_slug"
                                                name="slug" placeholder="readonly" readonly>

                                            @error('slug')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                {{-- product information end here --}}
                            </div>

                            <div class="col-md-5 p-1">
                                {{-- Categorization starts here --}}
                                <div class="card common_card p-2 mb-2">
                                    <div class="card-header p-0 border-0">
                                        <h3 class="card-title text-center fw-bold">Categorization</h3>
                                    </div>
                                    <div class="card-body">

                                        <div class="mb-5">
                                            <label for="category_id" class="form-label pt-2">
                                                Category Select: <span class="text-danger" aria-hidden="true">*</span>
                                            </label>
                                            <select class="form-select product_field" id="category_id" name="category_id"
                                                aria-label="Category selection" required>
                                                <option disabled selected hidden>select any item</option>
                                                @foreach ($categorieIdName as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- Subcategory -->
                                        <div class="mb-1">
                                            <label for="subcategory_id" class="form-label pt-2">
                                                Sub-category Select: <span class="text-danger" aria-hidden="true">*</span>
                                            </label>
                                            <select class="form-select product_field" id="subcategory_id"
                                                name="subcategory_id" aria-label="Subcategory selection" required>
                                                <option disabled selected hidden>select any item</option>
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
                                    <div class="card-header p-0 border-0">
                                        <h3 class="card-title text-center fw-bold">Specification</h3>
                                    </div>
                                    <div class="card-body">

                                        <!-- Weight -->
                                        <div class="mb-4">
                                            <label for="product_weight" class="form-label ms-1">Weight <strong>[ gm ]
                                                    :</strong></label>
                                            <input type="number" class="form-control product_field" id="product_weight"
                                                name="product_weight" step="0.001" min="0"
                                                placeholder="optional">
                                            @error('product_weight')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- warenty -->
                                        <div>
                                            <label for="warranty" class="form-label ms-1">Warranty:</label>
                                            <input type="text" class="form-control product_field" id="warranty"
                                                name="warranty" placeholder="optional">
                                            @error('warranty')
                                                <span class="text-danger">{{ $message }}</span>
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
                                                <label for="brand_id" class="form-label ms-1">Brand</label>
                                                <select class="form-select" id="brand_id" name="brand_id">
                                                    <option value="" disabled selected hidden>Select Brand</option>
                                                    @foreach ($brands as $brand)
                                                        <option value="{{ $brand->id }}">{{ $brand->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('brand_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label for="product_model_id" class="form-label ms-1">
                                                    Model Select:
                                                </label>

                                                <select class="form-select" id="product_model_id"
                                                    name="product_model_id">
                                                    <option value="" disabled selected hidden>Select Model</option>
                                                </select>
                                                @error('product_model_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div id="variationWrapper">
                                            <div class="variation-block border rounded mb-1">
                                                <div class="d-flex align-items-center gap-2 border border-1 border-danger">
                                                    <div style="display: flex; overflow-x: auto">
                                                        <div class="table-responsive table_horizontal_scroll">

                                                            <table class="table table-bordered align-middle mb-0"
                                                                style="table-layout: fixed; width: 100%;">
                                                                <thead>

                                                                    <tr class="text-center">
                                                                        <th style="width: 16%">Color <span
                                                                                class="text-danger"
                                                                                aria-hidden="true">*</span></th>

                                                                        <th style="width: 16%">Size <span
                                                                                class="text-danger"
                                                                                aria-hidden="true">*</span></th>

                                                                        <th style="width: 19%">SKU</th>

                                                                        <th style="width: 19%">Regular price <span
                                                                                class="text-danger"
                                                                                aria-hidden="true">*</span></th>

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
                                                                                    <option value="{{ $color->id }}">
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
                                                                                    <option value="{{ $size->id }}">
                                                                                        {{ $size->name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </td>

                                                                        <td>
                                                                            <input type="text" class="form-control"
                                                                                name="sku[]"
                                                                                placeholder="Create OR auto generate">
                                                                        </td>

                                                                        <td>
                                                                            <input type="number" class="form-control"
                                                                                name="regular_price[]" min="0"
                                                                                step="0.01" required>
                                                                        </td>

                                                                        <td>
                                                                            <input type="number" class="form-control"
                                                                                name="selling_price[]" min="0"
                                                                                step="0.01">
                                                                        </td>

                                                                        <td>
                                                                            <input type="number" class="form-control"
                                                                                name="stock_quantity[]" min="0"
                                                                                value="0">
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

                                                                                <option value="none" id="discount_none"
                                                                                    class="product_field">None</option>
                                                                                <option value="fixed" id="discount_flat"
                                                                                    class="product_field">Fixed</option>
                                                                                <option value="percent"
                                                                                    id="discount_percent"
                                                                                    class="product_field">Percent</option>
                                                                            </select>
                                                                        </td>

                                                                        <td>
                                                                            <input type="number"
                                                                                class="form-control product_field discount_value"
                                                                                name="discount_value[]" min="0"
                                                                                placeholder="Active for Fixed and Percent">
                                                                        </td>

                                                                        <td>
                                                                            <input type="datetime-local"
                                                                                class="form-control"
                                                                                name="discount_start[]">
                                                                        </td>

                                                                        <td>
                                                                            <input type="datetime-local"
                                                                                class="form-control"
                                                                                name="discount_end[]">
                                                                        </td>

                                                                        <td>
                                                                            <select class="form-select"
                                                                                name="manage_stock[]">
                                                                                <option value="1">Yes</option>
                                                                                <option value="0">No</option>
                                                                            </select>
                                                                        </td>

                                                                        <td>
                                                                            <select class="form-select"
                                                                                name="stock_status[]">

                                                                                <option value="in_stock">
                                                                                    In Stock
                                                                                </option>

                                                                                <option value="out_of_stock">
                                                                                    Out Of Stock
                                                                                </option>
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <div
                                                        class="variation-action d-flex justify-content-center align-items-center">
                                                        <button type="button"
                                                            class="btn btn-sm btn-success addBlock me-2">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                {{-- product variant end here --}}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-7 px-1">
                                {{-- Media starts here --}}
                                <div class="card common_card p-2 mb-2">
                                    <div class="card-header p-0 border-0">
                                        <h3 class="card-title text-center fw-bold">Media</h3>
                                    </div>

                                    <div class="card-body">

                                        @include('partials.global_file.create_multiple_file')

                                        <div class="mb-1">
                                            <label for="video_url" class="form-label">Video URL:</label>
                                            <input type="url" class="form-control product_field" id="video_url"
                                                name="video_url" placeholder="optional">
                                        </div>
                                    </div>
                                </div>
                                {{-- Media starts here --}}

                                {{-- Video URL start here --}}
                                <div class="card common_card p-2 mb-2">
                                    <div class="card-header p-0 border-0">
                                        <h3 class="card-title text-center fw-bold">Visibility & Feature</h3>
                                    </div>
                                    <div class="card-body">
                                        <!-- Visibility -->
                                        <div style="margin-bottom: 60px;">
                                            <label for="product_visibility" class="form-label">Select
                                                Visibility: <span class="text-danger" aria-hidden="true">*</span>
                                            </label>
                                            <select name="visibility" id="product_visibility"
                                                class="form-select product_field">
                                                <option value="visible" selected>Visible</option>
                                                <option value="hidden">Hidden</option>
                                            </select>
                                            @error('visibility')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- Status -->
                                        <div style="margin-bottom: 60px;">
                                            <label for="product_status" class="form-label">
                                                Status Select: <span class="text-danger" aria-hidden="true">*</span>
                                            </label>
                                            <select name="status" id="product_status" class="form-select product_field">
                                                <option value="1" selected>Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                            @error('status')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- Featured -->
                                        <div style="margin-bottom: 24px;">
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
                                {{-- Video URL end here --}}
                            </div>

                            <div class="col-md-5 p-1">
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
                                                class="form-control product_field" rows="6" placeholder="Enter meta title"></textarea>

                                            @error('meta_title')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <!-- Meta Description -->
                                        <div class="mb-4">
                                            <label for="meta_description" class="form-label ms-1">
                                                Meta Description:
                                            </label>

                                            <textarea id="meta_description" name="meta_description" class="form-control product_field" rows="10"
                                                style="resize: none; overflow-y: scroll" placeholder="Enter meta description"></textarea>

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
                                                class="form-control p-2 product_field" rows="6" placeholder="Enter meta keywords comma-separated"></textarea>

                                            @error('meta_keywords')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                {{-- SEO ends here --}}
                            </div>
                        </div>

                        <div class="row mt-3">
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
            </div>
        </div>
    </main>
@endsection

@include('custom_global_components.products.auto_generate')


@push('scripts')
    <script>
        $(function() {
            let maxVariantLimit = 0;
            let selectedImages = [];

            // IMAGE COUNT ONLY FOR VARIANT LIMIT
            $(document).on('change', '.product_image', function() {
                selectedImages = [];

                maxVariantLimit = this.files.length;

                // Remove old variant except first
                $('#variationWrapper .variation-block:not(:first)').remove();

                if (maxVariantLimit === 0) {
                    updateAddButton();
                    return;
                }

                $.each(this.files, function(index, file) {

                    let serial = index + 1;

                    selectedImages.push({
                        serial: serial,
                        name: file.name
                    });

                    // First Variant Image Mapping
                    if (serial === 1) {
                        $('.variation-block:first').attr('data-image', file.name)
                            .attr('data-variant', serial);

                    } else {

                        createVariantBlock(serial, file.name);
                    }
                });
                updateAddButton();
            });

            // CREATE VARIANT BLOCK
            function createVariantBlock(serial, imageName) {

                let clone = $('#variationWrapper .variation-block:first').clone();

                clone.removeAttr('data-image');
                clone.removeAttr('data-variant');

                // Clear input
                clone.find('input').each(function() {

                    if ($(this).attr('type') !== 'file') {
                        $(this).val('');
                    }
                });

                // Reset select
                clone.find('select').prop('selectedIndex', 0);

                // Image mapping
                clone.attr('data-image', imageName);
                clone.attr('data-variant', serial);

                clone.find('.variation-action')
                    .html(`<button type="button"
                            class="btn btn-sm btn-danger removeBlock">
                            <i class="fa fa-minus"></i>
                        </button>`);
                $('#variationWrapper').append(clone);
            }

            // PLUS BUTTON
            $(document).on('click', '.addBlock', function() {
                let currentVariant = $('.variation-block').length;

                if (maxVariantLimit === 0) {

                    toastr.warning('Please select image first.');

                    return false;
                }

                if (currentVariant >= maxVariantLimit) {

                    toastr.warning(
                        'Maximum ' + maxVariantLimit +
                        ' Variant allowed according to selected image.'
                    );
                    return false;
                }

                let nextSerial = currentVariant + 1;

                let imageData = selectedImages[nextSerial - 1];

                createVariantBlock(nextSerial, imageData ? imageData.name : '');

                updateAddButton();
            });

            // REMOVE BUTTON
            $(document).on('click', '.removeBlock', function() {

                if ($('.variation-block').length > 1) {

                    $(this).closest('.variation-block').remove();
                }
                updateAddButton();
            });

            // PLUS BUTTON CONTROL
            function updateAddButton() {

                let current = $('.variation-block').length;

                if (current >= maxVariantLimit) {

                    $('.addBlock').prop('disabled', true).addClass('disabled');

                } else {

                    $('.addBlock').prop('disabled', false).removeClass('disabled');
                }
            }
        });
    </script>
@endpush
