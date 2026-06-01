@extends('layouts.master_layout', ['title' => 'Brand wise products'])
@section('content')
    @include('inc.headers.global.global_header')
    @include('inc.homepage.sidebar.homepage_offcanvas')

    <!-- banner section start here -->
    <section class="mt-5 mt-md-0">
        <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
            <!-- Carousel Indicators -->
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true"
                    aria-label="Slide 1">
                </button>

                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>

            <!-- Carousel Inner -->
            <div class="carousel-inner">
                <!-- Slide 1 -->
                <div class="carousel-item active">
                    <div>
                        <img src="{{ asset('assets/images/homepage/img/banner.jpg') }}"
                            class="d-block w-100 h-auto img-fluid object-fit-cover" alt="Sale Banner 1">
                    </div>
                    <div class="carousel-caption text-start d-none d-md-block">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-md-7 col-lg-6">
                                    <div class="detail-box">
                                        <h1 class="fw-bold mb-3">
                                            <span class="text-warning">Sale 25% Off</span><br>
                                            On Everything
                                        </h1>
                                        <p class="mb-4">
                                            Enjoy exclusive discounts and the best quality products. Explore now and find
                                            everything you need for your lifestyle.
                                        </p>
                                        <a href="#"
                                            class="btn btn-warning text-dark fw-semibold px-4 py-2 rounded-pill shadow">
                                            Shop Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="carousel-item">
                    <div>
                        <img src="{{ asset('assets/images/homepage/img/banner.jpg') }}"
                            class="d-block w-100 h-auto img-fluid object-fit-cover" alt="New Collection">
                    </div>
                    <div class="carousel-caption text-start d-none d-md-block">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-md-7 col-lg-6">
                                    <div class="detail-box">
                                        <h1 class="fw-bold mb-3">
                                            <span class="text-warning">New Arrivals</span><br>
                                            Fresh Styles Every Day
                                        </h1>
                                        <p class="mb-4">
                                            Discover fresh arrivals curated just for you. Upgrade your style with our
                                            latest trends and essentials.
                                        </p>
                                        <a href="#"
                                            class="btn btn-warning text-dark fw-semibold px-4 py-2 rounded-pill shadow">
                                            Explore Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slide 3 -->
                <div class="carousel-item">
                    <div>
                        <img src="{{ asset('assets/images/homepage/img/banner.jpg') }}"
                            class="d-block w-100 h-auto img-fluid object-fit-cover" alt="Big Sale">
                    </div>
                    <div class="carousel-caption text-start d-none d-md-block">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-md-7 col-lg-6">
                                    <div class="detail-box">
                                        <h1 class="fw-bold mb-3">
                                            <span class="text-warning">Big Sale</span><br>
                                            Up to 50% Off
                                        </h1>
                                        <p class="mb-4">
                                            Don’t miss out on our limited-time offers. Save more with exclusive discounts
                                            across all categories.
                                        </p>
                                        <a href="#"
                                            class="btn btn-warning text-dark fw-semibold px-4 py-2 rounded-pill shadow">
                                            Get Offer
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- banner section end here -->

    <!-- why section -->
    <section class="why_section layout_padding">
        <div class="container-fluid">
            <div class="heading_container heading_center">
                <h2>
                    Why Shop With Us
                </h2>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="box ">
                        <div class="img-box">
                            <i class="fa-solid fa-truck-fast text-primary fa-3x"></i>
                        </div>
                        <div class="detail-box">
                            <h5>
                                Fast Delivery
                            </h5>
                            <p>
                                variations of passages of Lorem Ipsum available
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box ">
                        <div class="img-box">
                            <i class="fa-solid fa-users text-success fa-3x"></i>
                        </div>
                        <div class="detail-box">
                            <h5>
                                Free Shiping
                            </h5>
                            <p>
                                variations of passages of Lorem Ipsum available
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box ">
                        <div class="img-box">
                            <i class="fa-solid fa-award text-warning fa-3x"></i>
                        </div>
                        <div class="detail-box">
                            <h5>
                                Best Quality
                            </h5>
                            <p>
                                variations of passages of Lorem Ipsum available
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end why section -->

    <!-- latest products start here-->
    <section class="product_section">
        <div class="container-fluid">
            <div class="heading_container heading_center">
                <h2>Latest <span>products</span></h2>
            </div>

            <div class="row">
                @foreach ($latestProducts ?? [] as $product)
                    <div class="col-md-3 mb-3">
                        <div class="card homepage_card" style="height: 360px;">

                            <div class="card-header" style="width: 170px; height: 170px; margin:0 auto;">
                                @php $image = $product->images->first(); @endphp
                                @if ($image)
                                    <a href="{{ route('frontend.show', $product->id) }}">
                                        <img src="{{ asset($image->public_path) }}" style="width: 150px; height: 150px;">
                                    </a>
                                @else
                                    <a href="javascript:void(0)"
                                        class="text-decoration-none w-100 h-100 d-flex justify-content-center align-items-center">
                                        <span class="text-danger">No Image</span>
                                    </a>
                                @endif
                            </div>

                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mx-2 mb-1">
                                    <span class="fw-bold">Name:</span>
                                    <span>{{ $product->name ?? 'N/A' }}</span>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mx-2 mb-1">
                                    <span class="fw-bold">Price:</span>
                                    @if ($product->price)
                                        <span>{{ $product->price->regular_price }}</span>
                                    @else
                                        <span class="text-danger">N/A</span>
                                    @endif
                                </div>

                                <div class="d-flex justify-content-between align-items-center mx-1 mb-1">
                                    <span class="fw-bold">Category:</span>
                                    <span>
                                        {{ $product->subcategory && $product->subcategory->category ? $product->subcategory->category->name : 'N/A' }}
                                    </span>
                                </div>

                                <div>
                                    <span class="fw-bold ms-1">Short Description:</span>
                                    @if ($product->short_description)
                                        <textarea class="form-control border border-1 border-dark bg-transparent" rows="2" readonly
                                            style="resize: none; overflow-y: scroll;">{{ $product->short_description }}</textarea>
                                    @else
                                        <span class="text-danger">N/A</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- latest products end here -->

    <!-- category wise products start here -->
    <section class="product_section">
        <div class="container-fluid">
            <div class="heading_container heading_center">
                <h2>
                    Category <span>Products</span>
                </h2>
            </div>

            <ul class="list-unstyled d-flex flex-wrap align-items-center bg-success p-1 rounded">
                @foreach ($categories as $cat)
                    <li class="me-4">
                        <a class="navbar_btn btn p-1 text-white text-decoration-none"
                            href="{{ route('frontend.category_wise_product_show', ['id' => $cat->id, 'name' => $cat->name]) }}">
                            {{ $cat->name }}
                        </a>
                    </li>
                @endforeach
            </ul>

            <div class="row">
                @foreach ($categories as $category)
                    @foreach ($category->subcategories as $subcategory)
                        @php
                            $product = $subcategory->products->first();
                        @endphp
                        @if ($product)
                            <div class="col-md-3 mb-4">
                                <div class="product-card">
                                    <div class="product-img">
                                        @if ($product->images->first())
                                            <img src="{{ asset($product->images->first()->public_path) }}"
                                                class="img-fluid">
                                        @endif

                                    </div>
                                    <div class="product-body text-center">
                                        <p class="product-category">
                                            {{ $category->name ?? 'Category name empty' }}
                                        </p>
                                        <p>
                                            {{ $subcategory->subcategory_name ?? 'Subcategory name empty' }}
                                        </p>

                                        <h5 class="product-name">
                                            {{ $product->name }}
                                        </h5>

                                        <div class="product-price">
                                            <span class="new-price">
                                                ৳{{ $product->price->regular_price ?? 'not available' }}
                                            </span>

                                            <span class="old-price">
                                                ৳{{ $product->price->selling_price ?? 'not available' }}
                                            </span>
                                        </div>
                                        <div class="product-rating">
                                            ★★★★★
                                        </div>
                                        <div class="product-icons">
                                            <i class="fa fa-heart"></i>
                                            <i class="fa fa-random"></i>
                                            <i class="fa fa-eye"></i>
                                        </div>
                                    </div>
                                    <div class="add-to-cart-area">
                                        <button class="add-cart-btn">
                                            <i class="fa fa-shopping-cart"></i>
                                            ADD TO CART
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endforeach
            </div>
        </div>
    </section>
    <!-- category wise products end here -->

    <!-- sub-category wise products start here -->
    <section class="product_section">
        <div class="container-fluid">

            <div class="heading_container heading_center">
                <h2>
                    Subcategory <span>Products</span>
                </h2>
            </div>

            <div class="dropdown bg-success rounded mb-3">
                <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    Select Subcategory
                </button>
                <ul class="dropdown-menu bg-transparent mt-3">

                    @foreach ($categories as $category)
                        @foreach ($category->subcategories as $subcategory)
                            <li>
                                <a href="{{ route('frontend.subcategory_wise_product_show', ['id' => $subcategory->id, 'name' => $subcategory->subcategory_name]) }}"
                                    class="navbar_btn text-decoration-none text-dark dropdown-item
                                {{ request()->segment(2) == $subcategory->id ? 'active' : '' }}">
                                    {{ ucwords(strtolower($subcategory->subcategory_name ?? 'Subcategory Not Available')) }}
                                </a>
                            </li>
                        @endforeach
                    @endforeach

                </ul>
            </div>

            <div class="row">
                @foreach ($categories as $category)
                    @foreach ($category->subcategories as $subcategory)
                        @foreach ($subcategory->products as $product)
                            <div class="col-md-3 mb-4">
                                <div class="product-card">
                                    <div class="product-img">

                                        @if ($product->images && $product->images->first())
                                            <img src="{{ asset($product->images->first()->public_path) }}"
                                                alt="Product Image">
                                        @endif

                                    </div>

                                    <div class="product-body text-center">

                                        <p class="product-category">
                                            {{ $subcategory->subcategory_name ?? 'Subcategory empty' }}
                                        </p>

                                        <h5 class="product-name">
                                            {{ $product->name }}
                                        </h5>

                                        <div class="product-price">

                                            <span class="new-price">
                                                ৳{{ $product->price->regular_price ?? '0' }}
                                            </span>

                                            <span class="old-price">
                                                ৳{{ $product->price->selling_price ?? '0' }}
                                            </span>

                                        </div>

                                        <div class="product-icons">
                                            <i class="fa fa-heart"></i>
                                            <i class="fa fa-random"></i>
                                            <i class="fa fa-eye"></i>
                                        </div>

                                    </div>

                                    <div class="add-to-cart-area">
                                        <button class="add-cart-btn">
                                            <i class="fa fa-shopping-cart"></i>
                                            ADD TO CART
                                        </button>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    @endforeach
                @endforeach
            </div>
        </div>
    </section>
    <!-- sub-category wise products end here -->

    <!-- our product section start here -->
    <section class="product_section">
        <div class="container-fluid">
            <div class="heading_container heading_center">
                <h2>
                    Brand <span>Products</span>
                </h2>
            </div>

            <div class="dropdown bg-success rounded mb-3">
                <button class="m-0 btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Select Brand
                </button>

                <ul class="dropdown-menu bg-transparent mt-3">
                    @foreach ($brand_names as $brand)
                        <li>
                            <a href="{{ route('frontend.brand_wise_product_show', $brand) }}"
                                class="navbar_btn text-decoration-none text-dark dropdown-item
                                {{ request()->segment(2) == $brand ? 'active' : '' }}">

                                {{ ucwords(strtolower($brand)) ?? 'Brand Not Available' }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="row">
                @foreach ($brand_wise_products->flatten() as $product)
                    <div class="col-md-3 mb-4">
                        <div class="product-card">
                            <div class="product-img">
                                @if ($product->images->first())
                                    <img src="{{ asset($product->images->first()->public_path) }}" alt="Product Image">
                                @endif
                            </div>
                            <div class="product-body text-center">
                                <p class="product-category">
                                    {{ ucwords(strtolower($product->brand ?? 'not found')) }}
                                </p>
                                <h5 class="product-name">
                                    {{ $product->name }}
                                </h5>
                                <div class="product-price">
                                    @if ($product->price)
                                        <span class="new-price">
                                            ৳{{ $product->price->regular_price ?? '0' }}
                                        </span>
                                    @endif
                                    <span class="old-price">
                                        ৳{{ $product->price->selling_price ?? '0' }}
                                    </span>
                                </div>
                                <div class="product-rating">
                                    ★★★★★
                                </div>
                                <div class="product-icons">
                                    <i class="fa fa-heart"></i>
                                    <i class="fa fa-random"></i>
                                    <i class="fa fa-eye"></i>
                                </div>
                            </div>
                            <div class="add-to-cart-area">
                                <button class="add-cart-btn">
                                    <i class="fa fa-shopping-cart"></i>
                                    ADD TO CART
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- our product section end here -->

    <!-- view all product section start here -->
    <section class="product_section">
        <div class="container-fluid">
            <div class="heading_container heading_center">
                <h2>View All Products</h2>
            </div>

        </div>
    </section>
    <!-- view all product section end here -->

    <!-- subscribe section start here -->
    <section class="subscribe_section">
        <div class="container-fluid">
            <div class="box">
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <div class="subscribe_form ">
                            <div class="heading_container heading_center">
                                <h3>Subscribe To Get Discount Offers</h3>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor</p>
                            <form action="">
                                <input type="email" placeholder="Enter your email">
                                <button>
                                    subscribe
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- subscribe section end here -->

    <!-- customers testimonial section start here -->
    <section class="client_section layout_padding">
        <div class="container-fluid">
            <div class="heading_container heading_center">
                <h2>Customer's Testimonial</h2>
            </div>

            <div id="carouselExample3Controls" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">

                    <!-- Slide 1 -->
                    <div class="carousel-item active">
                        <div class="box col-lg-10 mx-auto">
                            <div class="img_container">
                                <div class="img-box">
                                    <div class="img_box-inner">
                                        <img src="{{ asset('assets/images/homepage/img/park-1.jpg') }}" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="detail-box">
                                <h5>Mariam</h5>
                                <h6>Customer</h6>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Atque animi sint unde quis
                                    reprehenderit, et, perspiciatis, debitis totam est. Deserunt eius officiis ipsum
                                    ducimus ad labore modi voluptatibus accusantium sapiente nam! Quaerat.

                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="carousel-item">
                        <div class="box col-lg-10 mx-auto">
                            <div class="img_container">
                                <div class="img-box">
                                    <div class="img_box-inner">
                                        <img src="{{ asset('assets/images/homepage/img/park-1.jpg') }}" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="detail-box">
                                <h5>Mariam</h5>
                                <h6>Customer</h6>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Atque animi sint unde quis
                                    reprehenderit, et, perspiciatis, debitis totam est. Deserunt eius officiis ipsum
                                    ducimus ad labore modi voluptatibus accusantium sapiente nam! Quaerat.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 3 -->
                    <div class="carousel-item">
                        <div class="box col-lg-10 mx-auto">
                            <div class="img_container">
                                <div class="img-box">
                                    <div class="img_box-inner">
                                        <img src="{{ asset('assets/images/homepage/img/park-1.jpg') }}" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="detail-box">
                                <h5>Mariam</h5>
                                <h6>Customer</h6>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Atque animi sint unde quis
                                    reprehenderit, et, perspiciatis, debitis totam est. Deserunt eius officiis ipsum
                                    ducimus ad labore modi voluptatibus accusantium sapiente nam! Quaerat.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Carousel Controls -->
                <div class="carousel_btn_box">
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample3Controls"
                        data-bs-slide="prev">
                        <i class="fa fa-long-arrow-left" aria-hidden="true"></i>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample3Controls"
                        data-bs-slide="next">
                        <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </section>
    <!-- customers testimonial section end here -->

    @include('inc.footers.global.global_footer')
@endsection
