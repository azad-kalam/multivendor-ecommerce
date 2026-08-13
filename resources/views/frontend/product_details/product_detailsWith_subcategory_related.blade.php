@extends('layouts.master_layout', ['title' => 'Product Details'])
@section('content')
    @include('inc.headers.global.global_header')
    @include('inc.homepage.sidebar.homepage_offcanvas')

    <section class="section" style="margin-top: 80px;">
        <div class="container-fluid pt-3">
            @php
                $variantData = $product->variants->map(function ($variant) {
                    return [
                        'id' => $variant->id,
                        'size_id' => $variant->size_id,
                        'color_id' => $variant->color_id,
                        'regular_price' => $variant->regular_price,
                        'selling_price' => $variant->selling_price,
                        'discount_type' => $variant->discount_type,
                        'discount_value' => $variant->discount_value,
                        'discount_start' => $variant->discount_start,
                        'discount_end' => $variant->discount_end,
                        'stock_quantity' => $variant->stock_quantity,
                        'stock_status' => $variant->stock_status,
                        'images' => $variant->images
                            ->map(function ($img) {
                                return asset($img->public_path);
                            })
                            ->values(),
                    ];
                });
            @endphp

            {{-- product details start here --}}
            <div class="row bg-info">
                <!--Left thumbnail images start here -->
                <div class="col-md-2">
                    <div class="thumbnail-wrapper">
                        <button type="button" class="thumbnail-arrow thumbnail-arrow-up" id="thumbnailPrev"
                            aria-label="Previous thumbnail">
                            <i class="fa fa-chevron-up"></i>
                        </button>

                        <div id="product-thumbnails" class="thumb-slider vertical-slider">
                            @foreach ($product->images as $index => $image)
                                <div class="slide-item" data-index="{{ $index }}"
                                    data-image="{{ asset($image->public_path) }}">
                                    <img src="{{ asset($image->public_path) }}" class="img-fluid thumb-img"
                                        alt="{{ $image->alt_text ?? 'Thumb image' }}">
                                </div>
                            @endforeach
                        </div>

                        <button type="button" class="thumbnail-arrow thumbnail-arrow-down" id="thumbnailNext"
                            aria-label="Next thumbnail">
                            <i class="fa fa-chevron-down"></i>
                        </button>
                    </div>
                </div>
                <!-- Left thumbnail images end here -->

                <!-- Right main Image start here -->
                <div class="col-md-5">
                    <div id="product-main-img" class="main-slider border border-1 border-danger rounded-1">
                        @foreach ($product->images as $image)
                            <div class="product-preview">
                                <img src="{{ asset($image->public_path) }}" class="main-img img-fluid"
                                    alt="{{ $image->alt_text ?? 'Product image' }}">
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- Right main Image end here -->

                <div class="col-md-5">
                    {{-- <div class="product-details">
                        <div class="d-flex">
                            <h2 class="product-name">Product Name:</h2>
                            <h2 class="product-name text-success ms-2">{{ $product->name }}</h2>
                        </div>

                        <div>
                            <div class="product-rating text-warning">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star-o"></i>
                            </div>
                            <a class="review-link" href="#">10 Review(s) | Add your review</a>
                        </div>

                        @php
                            $variant = $product->variants->first();
                        @endphp

                        <div class="d-flex align-items-center">
                            <h3 class="product-price w-50">
                                @if ($variant)
                                    @switch($variant->discount_type)
                                        @case('none')
                                            <span class="text-dark fw-bold">
                                                <i class="fa-solid fa-bangladeshi-taka-sign"></i>
                                                {{ number_format($variant->regular_price, 2) }}
                                            </span>
                                        @break

                                        @case('fixed')
                                        @case('percent')
                                            <span class="text-dark fw-bold">
                                                <i class="fa-solid fa-bangladeshi-taka-sign"></i>
                                                {{ number_format($variant->selling_price, 2) }}
                                            </span>

                                            <del class="text-danger ms-2">
                                                <i class="fa-solid fa-bangladeshi-taka-sign"></i>
                                                {{ number_format($variant->regular_price, 2) }}
                                            </del>
                                        @break

                                        @default
                                            <span class="text-danger">
                                                Price not available
                                            </span>
                                    @endswitch
                                @else
                                    <span class="text-danger">
                                        Price not found
                                    </span>
                                @endif
                            </h3>

                            <p class="product-badge w-25 ps-2 mt-2">
                                @if ($variant)
                                    @switch($variant->discount_type)
                                        @case('none')
                                            <span class="badge bg-danger">NEW</span>
                                        @break

                                        @case('fixed')
                                            <span class="badge bg-danger">OFFER</span>
                                        @break

                                        @case('percent')
                                            <span class="badge bg-danger">{{ $variant->discount_value }}% OFF</span>
                                        @break
                                    @endswitch
                                @endif
                            </p>
                            <p class="w-25 mt-2">
                                @if ($variant)
                                    @if ($variant->stock_status === 'in_stock')
                                        <span class="text-success product-available justify-content-center">
                                            In stock
                                        </span>
                                    @else
                                        <span class="text-danger product-available justify-content-center">
                                            Out of stock
                                        </span>
                                    @endif
                                @endif
                            </p>
                        </div>

                        <p>
                            <strong>Available:</strong>
                            <span id="availableQty">{{ $variant->stock_quantity }}</span>
                        </p>

                        <div class="row product-options mb-1 mt-0">
                            <div class="col-md-6">
                                <label for="sizeSelect" class="fw-bold d-block mb-1">
                                    Size:
                                </label>

                                <select id="sizeSelect" class="form-select">
                                    @foreach ($product->variants->unique('size_id') as $variant)
                                        <option value="{{ $variant->size_id }}">
                                            {{ $variant->size?->name ?? 'N/A' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="colorSelect" class="fw-bold d-block mb-1">
                                    Color:
                                </label>

                                <select id="colorSelect" class="form-select">
                                    @foreach ($product->variants->unique('color_id') as $variant)
                                        <option value="{{ $variant->color_id }}">
                                            {{ $variant->color?->name ?? 'N/A' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <label class="fw-bold mb-1">
                                    Quantity:
                                </label>

                                <div class="input-number">
                                    <input type="number" min="1"
                                        max="{{ $product->variants->max('stock_quantity') }}" value="1"
                                        class="form-control">

                                    <span class="quantity_up">+</span>
                                    <span class="quantity_down">-</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="add-to-cart mt-4">
                                    <button type="button" class="add-to-cart-btn mt-4">
                                        <i class="fa fa-shopping-cart"></i>
                                        Add to cart
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold d-block mb-1">Short Description:</label>

                            @if (!empty($product->short_description))
                                <textarea class="form-control border border-dark bg-transparent" rows="2" readonly
                                    style="resize: none; overflow-y: scroll;">{{ $product->short_description }}</textarea>
                            @else
                                <div class="text-danger">Product short description not found</div>
                            @endif
                        </div>

                        <ul class="product-links list-unstyled">
                            <li>Category:</li>
                            <li><a href="#">{{ $product->subcategory->category->name }}</a></li>

                            <li>Sub-category:</li>
                            <li><a href="#">{{ $product->subcategory->subcategory_name }}</a></li>
                        </ul>

                        <div class="d-flex">
                            <ul class="product-btns list-unstyled align-items-center d-flex flex-wrap p-0 m-0">
                                <li>
                                    <a href="#" class="text-decoration-none">
                                        <i class="fa fa-heart-o"></i> Add to wishlist
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="text-decoration-none">
                                        <i class="fa fa-exchange"></i> Add to compare
                                    </a>
                                </li>
                            </ul>

                            <ul class="product-links list-unstyled align-items-center d-flex flex-wrap gap-2 p-0 m-0 ms-4">
                                <li>Share:</li>
                                <li>
                                    <a href="https://www.facebook.com" target="_blank" rel="noopener noreferrer">
                                        <i class="fa-brands fa-facebook"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://twitter.com" target="_blank" rel="noopener noreferrer">
                                        <i class="fa-brands fa-twitter"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.google.com" target="_blank" rel="noopener noreferrer">
                                        <i class="fa-brands fa-google-plus-g"></i>
                                    </a>
                                </li>
                                <li><a href="https://envelope.com" target="_blank" rel="noopener noreferrer">
                                        <i class="fa-solid fa-envelope"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div> --}}

                    <form action="{{ route('frontend.carts.store') }}" id="add_to_cart" method="POST">
                        @csrf

                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="product_variant_id" id="productVariantId">

                        <div class="product-details">

                            <div class="d-flex">
                                <h2 class="product-name">Product Name:</h2>
                                <h2 class="product-name text-success ms-2">
                                    {{ $product->name }}
                                </h2>
                            </div>

                            <div>
                                <div class="product-rating text-warning">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-o"></i>
                                </div>

                                <a class="review-link" href="#">
                                    10 Review(s) | Add your review
                                </a>
                            </div>

                            @php
                                $firstVariant = $product->variants->first();
                            @endphp

                            {{-- Price --}}
                            <div class="d-flex align-items-center">

                                <h3 class="product-price w-50">

                                    @if ($firstVariant)
                                        @switch($firstVariant->discount_type)
                                            @case('none')
                                                <span class="text-dark fw-bold">
                                                    <i class="fa-solid fa-bangladeshi-taka-sign"></i>
                                                    {{ number_format($firstVariant->regular_price, 2) }}
                                                </span>
                                            @break

                                            @case('fixed')
                                            @case('percent')
                                                <span class="text-dark fw-bold">
                                                    <i class="fa-solid fa-bangladeshi-taka-sign"></i>
                                                    {{ number_format($firstVariant->selling_price, 2) }}
                                                </span>

                                                <del class="text-danger ms-2">
                                                    <i class="fa-solid fa-bangladeshi-taka-sign"></i>
                                                    {{ number_format($firstVariant->regular_price, 2) }}
                                                </del>
                                            @break

                                            @default
                                                <span class="text-danger">
                                                    Price not available
                                                </span>
                                        @endswitch
                                    @else
                                        <span class="text-danger">
                                            Price not found
                                        </span>
                                    @endif

                                </h3>


                                {{-- Badge --}}
                                <p class="product-badge w-25 ps-2 mt-2">

                                    @if ($firstVariant)
                                        @switch($firstVariant->discount_type)
                                            @case('none')
                                                <span class="badge bg-danger">
                                                    NEW
                                                </span>
                                            @break

                                            @case('fixed')
                                                <span class="badge bg-danger">
                                                    OFFER
                                                </span>
                                            @break

                                            @case('percent')
                                                <span class="badge bg-danger">
                                                    {{ $firstVariant->discount_value }}% OFF
                                                </span>
                                            @break
                                        @endswitch
                                    @endif

                                </p>


                                {{-- Stock --}}
                                <p class="w-25 mt-2">

                                    @if ($firstVariant)
                                        @if ($firstVariant->stock_status === 'in_stock')
                                            <span class="text-success product-available">
                                                In stock
                                            </span>
                                        @else
                                            <span class="text-danger product-available">
                                                Out of stock
                                            </span>
                                        @endif
                                    @endif

                                </p>

                            </div>


                            {{-- Available Stock --}}
                            <p>
                                <strong>Available:</strong>

                                <span id="availableQty">
                                    {{ $firstVariant?->stock_quantity ?? 0 }}
                                </span>
                            </p>


                            {{-- Size / Color --}}
                            <div class="row product-options mb-1 mt-0">

                                {{-- SIZE --}}
                                <div class="col-md-6">

                                    <label for="sizeSelect" class="fw-bold d-block mb-1">
                                        Size:
                                    </label>

                                    <select id="sizeSelect" name="product_size" class="form-select">

                                        @foreach ($product->variants->whereNotNull('size_id')->unique('size_id') as $variant)
                                            <option value="{{ $variant->size_id }}">
                                                {{ $variant->size?->name ?? 'N/A' }}
                                            </option>
                                        @endforeach

                                    </select>

                                </div>


                                {{-- COLOR --}}
                                <div class="col-md-6">

                                    <label for="colorSelect" class="fw-bold d-block mb-1">
                                        Color:
                                    </label>

                                    <select id="colorSelect" class="form-select">

                                        @foreach ($product->variants->whereNotNull('color_id')->unique('color_id') as $variant)
                                            <option value="{{ $variant->color_id }}">
                                                {{ $variant->color?->name ?? 'N/A' }}
                                            </option>
                                        @endforeach

                                    </select>

                                </div>

                            </div>


                            {{-- Quantity --}}
                            <div class="row align-items-center">

                                <div class="col-md-6">

                                    <label class="fw-bold mb-1">
                                        Quantity:
                                    </label>

                                    <div class="input-number">

                                        <input type="number" name="product_quantity" id="productQuantity" min="1"
                                            value="1" class="form-control">

                                        <span class="quantity_up">+</span>
                                        <span class="quantity_down">-</span>

                                    </div>

                                </div>


                                {{-- Add Cart Button --}}
                                <div class="col-md-6">

                                    <div class="add-to-cart mt-4">

                                        <button type="submit" class="add-to-cart-btn mt-4" id="addToCartBtn">
                                            <i class="fa fa-shopping-cart"></i>
                                            Add to cart
                                        </button>

                                    </div>

                                </div>

                            </div>


                            {{-- Short Description --}}
                            <div class="mb-3">

                                <label class="fw-bold d-block mb-1">
                                    Short Description:
                                </label>

                                @if (!empty($product->short_description))
                                    <textarea class="form-control border border-dark bg-transparent" rows="2" readonly
                                        style="resize: none; overflow-y: scroll;">{{ $product->short_description }}</textarea>
                                @else
                                    <div class="text-danger">
                                        Product short description not found
                                    </div>
                                @endif

                            </div>


                            {{-- Category --}}
                            <ul class="product-links list-unstyled">

                                <li>Category:</li>

                                <li>
                                    <a href="#">
                                        {{ $product->subcategory?->category?->name ?? 'N/A' }}
                                    </a>
                                </li>

                                <li>Sub-category:</li>

                                <li>
                                    <a href="#">
                                        {{ $product->subcategory?->subcategory_name ?? 'N/A' }}
                                    </a>
                                </li>

                            </ul>


                            {{-- Wishlist / Compare --}}
                            <div class="d-flex">

                                <ul class="product-btns list-unstyled align-items-center d-flex flex-wrap p-0 m-0">

                                    <li>
                                        <a href="#" class="text-decoration-none">
                                            <i class="fa fa-heart-o"></i>
                                            Add to wishlist
                                        </a>
                                    </li>

                                    <li>
                                        <a href="#" class="text-decoration-none">
                                            <i class="fa fa-exchange"></i>
                                            Add to compare
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <!-- Product details end here -->

            {{-- releted product start here --}}
            <div class="row bg-danger">
                <div class="col-md-12">
                    <h3 class="text-center">Related Products</h3>
                </div>
                @foreach ($relatedProducts as $relatedProduct)
                    @php
                        $variant = $relatedProduct->variants->first();

                        if ($variant) {
                            $old_price = $variant->regular_price ?? 0;
                            $selling_price = $variant->selling_price ?? 0;
                            $discount_value = $variant->discount_value ?? 0;
                            $discount_type = $variant->discount_type ?? 'none';
                        } else {
                            $old_price = 0;
                            $selling_price = 0;
                            $discount_value = 0;
                            $discount_type = 'none';
                        }

                        if ($discount_type == 'percent' && $discount_value > 0) {
                            $discount_price = $old_price - ($old_price * $discount_value) / 100;
                        } elseif ($discount_type == 'fixed' && $discount_value > 0) {
                            $discount_price = $old_price - $discount_value;
                        } else {
                            $discount_price = $selling_price;
                        }

                        $image = $relatedProduct->images->first();

                    @endphp

                    <div class="col-md-3">
                        <div class="product">
                            <div class="product-img text-center" style="height: 200px;">
                                @if ($image)
                                    <img src="{{ asset($image->public_path) }}"
                                        alt="{{ $image->alt_text ?? $relatedProduct->name }}"
                                        class="w-100 h-100 object-fit-contain img-thumbnail">
                                @else
                                    <span class="text-danger w-100 h-100 d-flex justify-content-center align-items-center">
                                        No Image
                                    </span>
                                @endif

                                @if ($variant && $variant->discount_type == 'percent' && $variant->discount_value > 0)
                                    <div class="product-label">
                                        <span class="sale">{{ $variant->discount_value }}%</span>
                                    </div>
                                @elseif ($variant && $variant->discount_type == 'fixed' && $variant->discount_value > 0)
                                    <div class="product-label">
                                        <span class="sale">Fixed</span>
                                    </div>
                                @else
                                    <div class="product-label">
                                        <span class="sale">New</span>
                                    </div>
                                @endif
                            </div>

                            <div class="product-body">

                                <p class="product-category">
                                    {{ $relatedProduct->subcategory->subcategory_name ?? 'subcategory unavailable' }}
                                </p>

                                <h3 class="product-name">
                                    <a href="#">
                                        {{ $relatedProduct->name }}
                                    </a>
                                </h3>

                                <h4 class="product-price">

                                    @if ($variant)
                                        @if ($variant->discount_type == 'percent' && $variant->discount_value > 0)
                                            <del class="text-danger me-2">
                                                ৳ {{ number_format($variant->regular_price, 2) }}
                                            </del>

                                            <span class="text-danger me-2">
                                                ৳ {{ number_format($variant->selling_price, 2) }}
                                            </span>
                                        @elseif ($variant->discount_type == 'fixed' && $variant->discount_value > 0)
                                            <del class="text-danger me-2">
                                                ৳ {{ number_format($variant->regular_price, 2) }}
                                            </del>

                                            <span class="text-danger me-2">
                                                ৳ {{ number_format($variant->selling_price, 2) }}
                                            </span>
                                        @else
                                            <span class="text-danger me-2">
                                                ৳ {{ number_format($variant->regular_price, 2) }}
                                            </span>
                                        @endif
                                    @endif
                                </h4>

                                <div class="product-btns">
                                    <button class="add-to-wishlist">
                                        <i class="fa fa-heart-o"></i>
                                    </button>

                                    <button class="add-to-compare">
                                        <i class="fa fa-exchange"></i>
                                    </button>

                                    <button class="quick-view">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="add-to-cart">
                                <button class="add-to-cart-btn">
                                    <i class="fa fa-shopping-cart"></i> add to cart
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>




            {{-- releted product end here --}}

            <!-- Product description + details + reviews starts here -->
            <div class="row">
                <div class="col-md-12 mt-1">
                    <div id="product-tab" class="m-0">
                        <!-- Tabs Navigation start here -->
                        <ul class="nav nav-tabs d-flex justify-content-center" id="productTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="desc-tab" data-bs-toggle="tab"
                                    data-bs-target="#tab1" type="button" role="tab">
                                    Short Description
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="details-tab" data-bs-toggle="tab" data-bs-target="#tab2"
                                    type="button" role="tab">
                                    Full Description
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#tab3"
                                    type="button" role="tab">
                                    Reviews (3)
                                </button>
                            </li>
                        </ul>
                        <!-- Tabs Navigation end here -->

                        <!-- Tabs Content starts here  -->
                        <div class="tab-content mt-3" id="productTabContent">
                            <!-- Tab 1 -->
                            <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>{{ $product->short_description }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Tab 2  -->
                            <div class="tab-pane fade" id="tab2" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>{{ $product->full_description }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Tab 3  -->
                            <div id="tab3" class="tab-pane">
                                <div class="row">
                                    <!-- Rating progress start here -->
                                    <div class="col-md-3">
                                        <div id="rating">
                                            <div class="rating-avg">
                                                <span>4.5</span>
                                                <div class="rating-stars">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star-o"></i>
                                                </div>
                                            </div>
                                            <ul class="rating">
                                                <!-- rating progress 80% -->
                                                <li>
                                                    <div class="rating-stars">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                    </div>
                                                    <div class="rating-progress">
                                                        <div style="width: 80%;"></div>
                                                    </div>
                                                    <span class="sum">5</span>
                                                </li>
                                                <!-- rating progress 60% -->
                                                <li>
                                                    <div class="rating-stars">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-o"></i>
                                                    </div>
                                                    <div class="rating-progress">
                                                        <div style="width: 60%;"></div>
                                                    </div>
                                                    <span class="sum">4</span>
                                                </li>
                                                <!-- rating progress 40% -->
                                                <li>
                                                    <div class="rating-stars">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                    </div>
                                                    <div class="rating-progress">
                                                        <div style="width: 40%;"></div>
                                                    </div>
                                                    <span class="sum">3</span>
                                                </li>
                                                <!-- rating progress 20% -->
                                                <li>
                                                    <div class="rating-stars">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                    </div>
                                                    <div class="rating-progress">
                                                        <div style="width: 20%;"></div>
                                                    </div>
                                                    <span class="sum">2</span>
                                                </li>
                                                <!-- rating progress 10% -->
                                                <li>
                                                    <div class="rating-stars">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                    </div>
                                                    <div class="rating-progress">
                                                        <div style="width: 10%;"></div>
                                                    </div>
                                                    <span class="sum">1</span>
                                                </li>
                                                <!-- rating progress 0% -->
                                                <li>
                                                    <div class="rating-stars">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                    </div>
                                                    <div class="rating-progress">
                                                        <div></div>
                                                    </div>
                                                    <span class="sum">0</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- Rating progress end here -->

                                    <!-- Review starts here -->
                                    <div class="col-md-6">
                                        <div id="reviews">
                                            <ul class="reviews list-unstyled">
                                                <li>
                                                    <div class="review-heading">
                                                        <h5 class="name">John</h5>
                                                        <p class="date">27 DEC 2018, 8:0 PM</p>
                                                        <div class="review-rating">
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star-o empty"></i>
                                                        </div>
                                                    </div>
                                                    <div class="review-body">
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                                                            eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="review-heading">
                                                        <h5 class="name">John</h5>
                                                        <p class="date">27 DEC 2018, 8:0 PM</p>
                                                        <div class="review-rating">
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star-o empty"></i>
                                                        </div>
                                                    </div>
                                                    <div class="review-body">
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                                                            eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="review-heading">
                                                        <h5 class="name">John</h5>
                                                        <p class="date">27 DEC 2018, 8:0 PM</p>
                                                        <div class="review-rating">
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star-o empty"></i>
                                                        </div>
                                                    </div>
                                                    <div class="review-body">
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                                                            eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
                                                    </div>
                                                </li>
                                            </ul>
                                            {{-- pagination start here --}}


                                            {{-- pagination end here --}}

                                        </div>
                                    </div>
                                    <!-- Review ends here -->

                                    <!-- Review Form starts here -->
                                    <div class="col-md-3">
                                        <div id="review-form">
                                            <form class="review-form">
                                                <input type="text" class="form-control border-1 border-info mb-1"
                                                    placeholder="Type Your Name">
                                                <input type="email"class="form-control border-1 border-info mb-1"
                                                    placeholder="Type Your Email">
                                                <textarea class="form-control border-1 border-info mb-1" id="review" name="review" rows="4"
                                                    placeholder="Type Your Review" required style="resize: none;" aria-label="Type your review here"></textarea>

                                                <!-- your rating start here -->
                                                <div class="input-rating">
                                                    <span>Your Rating: </span>
                                                    <div class="stars">
                                                        <input type="radio" id="star5" name="rating"
                                                            value="5" />
                                                        <label for="star5" title="5 stars"></label>

                                                        <input type="radio" id="star4" name="rating"
                                                            value="4" />
                                                        <label for="star4" title="4 stars"></label>

                                                        <input type="radio" id="star3" name="rating"
                                                            value="3" />
                                                        <label for="star3" title="3 stars"></label>

                                                        <input type="radio" id="star2" name="rating"
                                                            value="2" />
                                                        <label for="star2" title="2 stars"></label>

                                                        <input type="radio" id="star1" name="rating"
                                                            value="1" />
                                                        <label for="star1" title="1 star"></label>
                                                    </div>
                                                </div>
                                                <!-- your rating ends here -->
                                                <div class="d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-outline-success">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- Review Form ends here -->
                                </div>
                            </div>
                        </div>
                        <!-- Tabs Content ends here -->
                    </div>
                </div>
            </div>
            <!-- Product description + details + reviews ends here -->
        </div>
    </section>
    @include('inc.footers.global.global_footer')
@endsection


@push('scripts')
    <script>
        $(document).ready(function() {

            const variants = @json($variantData);

            function getSelectedVariant() {

                let size_id = Number($('#sizeSelect').val());

                let color_id = Number($('#colorSelect').val());

                return variants.find(function(v) {

                    return Number(v.size_id) === size_id &&
                        Number(v.color_id) === color_id;

                });
            }

            function destroySliders() {

                if (
                    $('#product-main-img')
                    .hasClass('slick-initialized')
                ) {

                    $('#product-main-img')
                        .slick('unslick');
                }


                if (
                    $('#product-thumbnails')
                    .hasClass('slick-initialized')
                ) {

                    $('#product-thumbnails')
                        .slick('unslick');
                }

                $('#thumbnailPrev')
                    .prop('disabled', true)
                    .addClass('disabled');

                $('#thumbnailNext')
                    .prop('disabled', true)
                    .addClass('disabled');
            }

            function activeThumb(index) {

                $('#product-thumbnails .slide-item')
                    .removeClass(
                        'border border-danger rounded'
                    );

                $('#product-thumbnails .slide-item')
                    .eq(index)
                    .addClass(
                        'border border-danger rounded'
                    );
            }

            function updateThumbnailArrows() {

                const $slider = $('#product-thumbnails');

                const $up = $('#thumbnailPrev');

                const $down = $('#thumbnailNext');

                if (
                    !$slider.hasClass('slick-initialized')
                ) {

                    $up
                        .prop('disabled', true)
                        .addClass('disabled');

                    $down
                        .prop('disabled', true)
                        .addClass('disabled');

                    return;
                }


                const slick =
                    $slider.slick('getSlick');


                const totalItems =
                    slick.slideCount;


                const visibleItems =
                    Math.min(
                        3,
                        totalItems
                    );

                const currentPosition =
                    slick.currentSlide;

                const lastPosition =
                    Math.max(
                        0,
                        totalItems - visibleItems
                    );

                if (
                    currentPosition <= 0
                ) {

                    $up
                        .prop('disabled', true)
                        .addClass('disabled');

                } else {

                    $up
                        .prop('disabled', false)
                        .removeClass('disabled');
                }

                if (
                    currentPosition >= lastPosition
                ) {

                    $down
                        .prop('disabled', true)
                        .addClass('disabled');

                } else {

                    $down
                        .prop('disabled', false)
                        .removeClass('disabled');
                }
            }

            function initSliders() {

                destroySliders();

                $('#product-main-img').slick({

                    slidesToShow: 1,

                    slidesToScroll: 1,

                    arrows: true,

                    infinite: false,

                    speed: 300
                });

                const $thumbnailSlider =
                    $('#product-thumbnails');


                const thumbnailCount =
                    $thumbnailSlider
                    .children('.slide-item')
                    .length;


                if (thumbnailCount > 0) {

                    $thumbnailSlider.slick({

                        slidesToShow: Math.min(
                            3,
                            thumbnailCount
                        ),

                        slidesToScroll: 1,

                        vertical: true,

                        verticalSwiping: true,


                        arrows: false,

                        focusOnSelect: true,


                        infinite: false,

                        swipeToSlide: false,

                        speed: 300,

                        adaptiveHeight: false
                    });
                }

                if (thumbnailCount > 0) {

                    activeThumb(0);
                }


                updateThumbnailArrows();

                $('#product-main-img')
                    .off('afterChange.productThumbnailSync')
                    .on(
                        'afterChange.productThumbnailSync',
                        function(
                            event,
                            slick,
                            current
                        ) {

                            activeThumb(current);
                        }
                    );

                $thumbnailSlider
                    .off('afterChange.thumbnailArrow')
                    .on(
                        'afterChange.thumbnailArrow',
                        function() {

                            updateThumbnailArrows();
                        }
                    );

                $('#thumbnailPrev')
                    .off('click.thumbnailPrev')
                    .on(
                        'click.thumbnailPrev',
                        function(e) {

                            e.preventDefault();


                            /*
                            |--------------------------------------------------------------------------
                            | Disabled হলে কিছু করবে না
                            |--------------------------------------------------------------------------
                            */

                            if (
                                $(this).prop('disabled')
                            ) {
                                return;
                            }


                            /*
                            |--------------------------------------------------------------------------
                            | Slider check
                            |--------------------------------------------------------------------------
                            */

                            if (
                                !$thumbnailSlider
                                .hasClass(
                                    'slick-initialized'
                                )
                            ) {
                                return;
                            }


                            const slick =
                                $thumbnailSlider
                                .slick('getSlick');


                            const currentPosition =
                                slick.currentSlide;


                            /*
                            |--------------------------------------------------------------------------
                            | First position
                            |--------------------------------------------------------------------------
                            */

                            if (
                                currentPosition <= 0
                            ) {

                                updateThumbnailArrows();

                                return;
                            }


                            /*
                            |--------------------------------------------------------------------------
                            | MOVE EXACTLY 1 ITEM UP
                            |--------------------------------------------------------------------------
                            */

                            $thumbnailSlider.slick(
                                'slickGoTo',
                                currentPosition - 1
                            );
                        }
                    );


                /*
                |--------------------------------------------------------------------------
                | THUMBNAIL DOWN BUTTON
                |--------------------------------------------------------------------------
                |
                | প্রতিবার click করলে EXACTLY 1 item নিচে যাবে।
                |
                |--------------------------------------------------------------------------
                */

                $('#thumbnailNext')
                    .off('click.thumbnailNext')
                    .on(
                        'click.thumbnailNext',
                        function(e) {

                            e.preventDefault();


                            /*
                            |--------------------------------------------------------------------------
                            | Disabled হলে কিছু করবে না
                            |--------------------------------------------------------------------------
                            */

                            if (
                                $(this).prop('disabled')
                            ) {
                                return;
                            }


                            /*
                            |--------------------------------------------------------------------------
                            | Slider check
                            |--------------------------------------------------------------------------
                            */

                            if (
                                !$thumbnailSlider
                                .hasClass(
                                    'slick-initialized'
                                )
                            ) {
                                return;
                            }


                            const slick =
                                $thumbnailSlider
                                .slick('getSlick');


                            const totalItems =
                                slick.slideCount;


                            const visibleItems =
                                Math.min(
                                    3,
                                    totalItems
                                );


                            const currentPosition =
                                slick.currentSlide;


                            /*
                            |--------------------------------------------------------------------------
                            | Last position
                            |--------------------------------------------------------------------------
                            */

                            const lastPosition =
                                Math.max(
                                    0,
                                    totalItems -
                                    visibleItems
                                );


                            /*
                            |--------------------------------------------------------------------------
                            | Already last
                            |--------------------------------------------------------------------------
                            */

                            if (
                                currentPosition >=
                                lastPosition
                            ) {

                                updateThumbnailArrows();

                                return;
                            }


                            /*
                            |--------------------------------------------------------------------------
                            | MOVE EXACTLY 1 ITEM DOWN
                            |--------------------------------------------------------------------------
                            */

                            $thumbnailSlider.slick(
                                'slickGoTo',
                                currentPosition + 1
                            );
                        }
                    );


                /*
                |--------------------------------------------------------------------------
                | Zoom
                |--------------------------------------------------------------------------
                */

                initZoom();
            }


            /*
            |--------------------------------------------------------------------------
            | Thumbnail Click
            |--------------------------------------------------------------------------
            */

            $(document)
                .off(
                    'click.productThumbnail',
                    '.slide-item'
                )
                .on(
                    'click.productThumbnail',
                    '.slide-item',
                    function() {

                        let index =
                            $(this).data('index');


                        if (
                            $('#product-main-img')
                            .hasClass(
                                'slick-initialized'
                            )
                        ) {

                            $('#product-main-img')
                                .slick(
                                    'slickGoTo',
                                    index
                                );
                        }
                    }
                );


            /*
            |--------------------------------------------------------------------------
            | Zoom
            |--------------------------------------------------------------------------
            */

            function initZoom() {

                $('.zoomImg').remove();

                $('.zoom').remove();


                $('#product-main-img .main-img')
                    .each(function() {

                        $(this)
                            .wrap(
                                '<div class="zoom"></div>'
                            );


                        $(this)
                            .parent()
                            .zoom({

                                url: $(this).attr('src'),

                                magnify: 1.5
                            });
                    });
            }


            /*
            |--------------------------------------------------------------------------
            | Get All Variant Images
            |--------------------------------------------------------------------------
            */

            function getAllVariantImages() {

                let images = [];


                variants.forEach(function(variant) {

                    variant.images.forEach(
                        function(img) {

                            if (
                                !images.includes(img)
                            ) {

                                images.push(img);
                            }
                        }
                    );
                });


                return images;
            }


            /*
            |--------------------------------------------------------------------------
            | Update Gallery
            |--------------------------------------------------------------------------
            */

            function updateGallery(selectedImages) {

                let images =
                    getAllVariantImages();


                let thumbs = '';

                let main = '';


                images.forEach(
                    function(img, index) {

                        thumbs += `
                    <div
                        class="slide-item mb-2"
                        data-index="${index}"
                        data-image="${img}"
                    >
                        <img
                            src="${img}"
                            class="img-fluid thumb-img"
                        >
                    </div>
                `;


                        main += `
                    <div class="product-preview">

                        <img
                            src="${img}"
                            class="main-img img-fluid"
                        >

                    </div>
                `;
                    }
                );


                /*
                |--------------------------------------------------------------------------
                | Reinitialize
                |--------------------------------------------------------------------------
                */

                destroySliders();


                $('#product-thumbnails')
                    .html(thumbs);


                $('#product-main-img')
                    .html(main);


                initSliders();


                /*
                |--------------------------------------------------------------------------
                | Selected Image
                |--------------------------------------------------------------------------
                */

                if (
                    selectedImages.length
                ) {

                    let index =
                        images.indexOf(
                            selectedImages[0]
                        );


                    if (
                        index >= 0 &&
                        $('#product-main-img')
                        .hasClass(
                            'slick-initialized'
                        )
                    ) {

                        $('#product-main-img')
                            .slick(
                                'slickGoTo',
                                index
                            );


                        activeThumb(index);
                    }
                }


                /*
                |--------------------------------------------------------------------------
                | Make sure arrows are correct
                |--------------------------------------------------------------------------
                */

                updateThumbnailArrows();
            }


            /*
            |--------------------------------------------------------------------------
            | Update Product
            |--------------------------------------------------------------------------
            */

            function updateProduct(variant) {

                if (!variant) {

                    $('.product-price')
                        .html(
                            '<span class="text-danger">' +
                            'Price not available' +
                            '</span>'
                        );


                    $('.product-badge')
                        .html('');

                    return;
                }


                let priceHtml = '';

                let badgeHtml = '';


                switch (variant.discount_type) {


                    /*
                    |--------------------------------------------------------------------------
                    | NONE
                    |--------------------------------------------------------------------------
                    */

                    case 'none':

                        priceHtml = `
                    <span class="text-dark fw-bold">

                        <i class="fa-solid fa-bangladeshi-taka-sign"></i>

                        ${Number(
                            variant.regular_price
                        ).toFixed(2)}

                    </span>
                `;


                        badgeHtml = `
                    <span class="badge bg-danger">
                        NEW
                    </span>
                `;

                        break;


                        /*
                        |--------------------------------------------------------------------------
                        | FIXED
                        |--------------------------------------------------------------------------
                        */

                    case 'fixed':

                        priceHtml = `
                    <span class="text-dark fw-bold">

                        <i class="fa-solid fa-bangladeshi-taka-sign"></i>

                        ${Number(
                            variant.selling_price
                        ).toFixed(2)}

                    </span>

                    <del class="text-danger ms-2">

                        <i class="fa-solid fa-bangladeshi-taka-sign"></i>

                        ${Number(
                            variant.regular_price
                        ).toFixed(2)}

                    </del>
                `;


                        badgeHtml = `
                    <span class="badge bg-danger">
                        OFFER
                    </span>
                `;

                        break;


                        /*
                        |--------------------------------------------------------------------------
                        | PERCENT
                        |--------------------------------------------------------------------------
                        */

                    case 'percent':

                        priceHtml = `
                    <span class="text-dark fw-bold">

                        <i class="fa-solid fa-bangladeshi-taka-sign"></i>

                        ${Number(
                            variant.selling_price
                        ).toFixed(2)}

                    </span>

                    <del class="text-danger ms-2">

                        <i class="fa-solid fa-bangladeshi-taka-sign"></i>

                        ${Number(
                            variant.regular_price
                        ).toFixed(2)}

                    </del>
                `;


                        badgeHtml = `
                    <span class="badge bg-danger">
                        ${variant.discount_value}% OFF
                    </span>
                `;

                        break;


                        /*
                        |--------------------------------------------------------------------------
                        | DEFAULT
                        |--------------------------------------------------------------------------
                        */

                    default:

                        priceHtml = `
                    <span class="text-danger">
                        Price not available
                    </span>
                `;


                        badgeHtml = `
                    <span class="text-danger">
                        No Offer
                    </span>
                `;

                        break;
                }


                /*
                |--------------------------------------------------------------------------
                | Price
                |--------------------------------------------------------------------------
                */

                $('.product-price')
                    .html(priceHtml);


                /*
                |--------------------------------------------------------------------------
                | Badge
                |--------------------------------------------------------------------------
                */

                $('.product-badge')
                    .html(badgeHtml);


                /*
                |--------------------------------------------------------------------------
                | Stock Status
                |--------------------------------------------------------------------------
                */

                $('.product-available')
                    .removeClass(
                        'text-success text-danger'
                    )
                    .addClass(
                        variant.stock_status === 'in_stock' ?
                        'text-success' :
                        'text-danger'
                    )
                    .text(
                        variant.stock_status === 'in_stock' ?
                        'In Stock' :
                        'Out Of Stock'
                    );


                /*
                |--------------------------------------------------------------------------
                | Available Quantity
                |--------------------------------------------------------------------------
                */

                $('#availableQty')
                    .text(
                        variant.stock_quantity
                    );


                /*
                |--------------------------------------------------------------------------
                | Product Quantity
                |--------------------------------------------------------------------------
                */

                $('.input-number input')
                    .attr(
                        'max',
                        variant.stock_quantity
                    )
                    .val(1);


                /*
                |--------------------------------------------------------------------------
                | Variant Images
                |--------------------------------------------------------------------------
                */

                if (
                    variant.images &&
                    variant.images.length
                ) {

                    updateGallery(
                        variant.images
                    );
                }
            }


            /*
            |--------------------------------------------------------------------------
            | Size Change
            |--------------------------------------------------------------------------
            */

            $('#sizeSelect')
                .on(
                    'change',
                    function() {

                        let variant =
                            getSelectedVariant();


                        if (variant) {

                            updateProduct(
                                variant
                            );
                        }
                    }
                );


            /*
            |--------------------------------------------------------------------------
            | Color Change
            |--------------------------------------------------------------------------
            */

            $('#colorSelect')
                .on(
                    'change',
                    function() {

                        let variant =
                            getSelectedVariant();


                        if (variant) {

                            updateProduct(
                                variant
                            );
                        }
                    }
                );


            /*
            |--------------------------------------------------------------------------
            | Initial Sliders
            |--------------------------------------------------------------------------
            */

            initSliders();


            /*
            |--------------------------------------------------------------------------
            | First Variant
            |--------------------------------------------------------------------------
            */

            let firstVariant =
                getSelectedVariant();


            if (firstVariant) {

                updateProduct(
                    firstVariant
                );
            }

        });


        /*
        |--------------------------------------------------------------------------
        | Quantity UP
        |--------------------------------------------------------------------------
        */

        $(document)
            .off(
                'click.productQuantityUp',
                '.quantity_up'
            )
            .on(
                'click.productQuantityUp',
                '.quantity_up',
                function() {

                    let input =
                        $(this).siblings('input');


                    let value =
                        parseInt(
                            input.val()
                        ) || 1;


                    let max =
                        parseInt(
                            input.attr('max')
                        );


                    if (value < max) {

                        input.val(
                            value + 1
                        );
                    }
                }
            );


        /*
        |--------------------------------------------------------------------------
        | Quantity DOWN
        |--------------------------------------------------------------------------
        */

        $(document)
            .off(
                'click.productQuantityDown',
                '.quantity_down'
            )
            .on(
                'click.productQuantityDown',
                '.quantity_down',
                function() {

                    let input =
                        $(this).siblings('input');


                    let value =
                        parseInt(
                            input.val()
                        ) || 1;


                    let min =
                        parseInt(
                            input.attr('min')
                        ) || 1;


                    if (value > min) {

                        input.val(
                            value - 1
                        );
                    }
                }
            );
    </script>
@endpush
