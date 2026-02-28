@extends('layouts.master_layout', ['title' => 'Product Details'])
@section('content')
    @include('inc.headers.global.global_header')
    @include('inc.homepage.sidebar.homepage_offcanvas')

    <section class="section mt-5">
        <div class="container-fluid pt-3">
            {{-- product thumbnail start here --}}
            <div class="row">
                <!--Left thumbnail Slider start here -->
                <div class="col-md-2">
                    <div id="product-thumbnails" class="thumb-slider vertical-slider">
                        @foreach ($product->images as $image)
                            <div class="slide-item">
                                <img src="{{ asset($image->public_path) }}" class="img-fluid thumb-img"
                                    alt="{{ $image->alt_text ?? 'Thumb image' }}">
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- Left thumbnail Slider end here -->

                <!-- Right main Image Slider start here -->
                <div class="col-md-5">
                    <div id="product-main-img" class="main-slider">
                        @foreach ($product->images as $image)
                            <div class="product-preview">
                                <img src="{{ asset($image->public_path) }}" class="main-img object-fit-contain img-fluid"
                                    alt="{{ $image->alt_text ?? 'Product image' }}">
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- Right main Image Slider end here -->

                <!-- Product details start here -->
                <div class="col-md-5">
                    <div class="product-details">
                        <div class="d-flex">
                            <h2 class="product-name">Product Name:</h2>
                            <h2 class="product-name text-success ms-2">{{ $product->name }}</h2>
                        </div>
                        <!-- product rating & review starts here -->
                        <div class="mb-2">
                            <div class="product-rating text-warning">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star-o"></i>
                            </div>
                            <a class="review-link" href="#">10 Review(s) | Add your review</a>
                        </div>
                        <!-- product rating & review ends here -->

                        <!-- Product price start here -->
                        <div class="mb-2">
                            <h3 class="product-price">
                                @if ($product->price && $product->price->regular_price)
                                    <span class="text-dark">
                                        <i class="fa-solid fa-bangladeshi-taka-sign"></i>
                                        {{ $product->price->regular_price }}
                                    </span>
                                @else
                                    <small class="text-danger h6">Regular price empty</small>
                                @endif

                                @if ($product->price && $product->price->selling_price)
                                    <del class="product-old-price ms-1 text-danger">
                                        <i class="fa-solid fa-bangladeshi-taka-sign"></i>
                                        {{ $product->price->selling_price }}
                                    </del>
                                @else
                                    <small class="text-danger h6">Selling price empty</small>
                                @endif
                            </h3>
                            <span class="product-available">In Stock</span>
                        </div>
                        <!-- Product price end here -->

                        <!-- Product Short Description start here -->
                        <div class="mb-3">
                            <label class="fw-bold d-block mb-1">Short Description:</label>

                            @if (!empty($product->short_description))
                                <textarea class="form-control border border-dark bg-transparent" rows="2" readonly
                                    style="resize: none; overflow-y: scroll;">{{ $product->short_description }}</textarea>
                            @else
                                <div class="text-danger">Product short description not found</div>
                            @endif
                        </div>
                        <!-- Product Short Description end here -->

                        <!-- Product Size & Color start here -->
                        <div class="product-options mb-3">
                            <label class="me-3">
                                Size
                                <select class="form-select form-select-sm w-auto d-inline-block">
                                    <option value="{{ $product->size }}">{{ $product->size }}</option>
                                </select>
                            </label>
                            <label>
                                Color
                                <select class="form-select form-select-sm w-auto d-inline-block">
                                    <option value="{{ $product->color }}">{{ $product->color }}</option>
                                </select>
                            </label>
                        </div>
                        <!-- Product Size & Color end here -->

                        <!-- Product Quantity & Add to cart start here -->
                        <div class="add-to-cart">
                            <div class="qty-label">
                                Quantity
                                <div class="input-number">
                                    <input type="number" min="1" max="{{ $product->stock_quantity }}"
                                        value="{{ $product->stock_quantity }}">
                                    <span class="qty-up">+</span>
                                    <span class="qty-down">-</span>
                                </div>
                            </div>

                            <button class="add-to-cart-btn">
                                <i class="fa fa-shopping-cart"></i> add to cart
                            </button>
                        </div>
                        <!-- Product Quantity & Add to cart end here -->

                        <!-- Product wishlist & compare start here -->
                        <ul class="product-btns list-unstyled d-flex flex-wrap gap-3 mb-3">
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
                        <!-- Product wishlist & compare end here -->

                        <!-- Product category & sub-category start here -->
                        <ul class="product-links list-unstyled">
                            <li>Category:</li>
                            <li><a href="#">{{ $product->subcategory->category->name }}</a></li>

                            <li>Sub-category:</li>
                            <li><a href="#">{{ $product->subcategory->subcategory_name }}</a></li>
                        </ul>
                        <!-- Product category & sub-category end here -->

                        <!-- Product share start here -->
                        <ul class="product-links list-unstyled">
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
                        <!-- Product share end here -->
                    </div>
                </div>
                <!-- Product details end here -->
            </div>
            <!-- Product thumbnail end here -->

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

            {{-- releted product start here --}}
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-center">Related Products</h3>
                </div>

                {{-- @foreach ($relatedProducts as $reletedProduct)
                    <div class="col-md-3">
                        <div class="product">
                            <div class="product-img text-center">
                                @php
                                    $image = $reletedProduct->images->first();
                                @endphp

                                @if ($image)
                                    <img src="{{ asset($image->public_path) }}"
                                        alt="{{ $image->alt_text ?? $reletedProduct->name }}" class="w-100 h-100">
                                @else
                                    <p class="text-danger p-3">Image no available</p>
                                @endif

                                <div class="product-label">
                                    <span class="sale">-30%</span>
                                </div>
                            </div>

                            <div class="product-body">
                                <p class="product-category">
                                    {{ $reletedProduct->subcategory->subcategory_name ?? 'subcategory unavailable' }}</p>
                                <h3 class="product-name"><a href="#">{{ $reletedProduct->name }}</a></h3>
                                <h4 class="product-price">
                                    <i class="fa-solid fa-bangladeshi-taka-sign"></i>
                                    {{ $reletedProduct->price->regular_price ?? 'regular price undefined' }}

                                    <del class="product-old-price">
                                        <i class="fa-solid fa-bangladeshi-taka-sign"></i>
                                        {{ $reletedProduct->price->selling_price ?? 'selling price undefined' }}
                                    </del>
                                </h4>
                                <div class="product-rating">
                                </div>
                                <div class="product-btns">
                                    <button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span
                                            class="tooltipp">add
                                            to wishlist</span></button>
                                    <button class="add-to-compare"><i class="fa fa-exchange"></i><span
                                            class="tooltipp">add
                                            to compare</span></button>
                                    <button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">quick
                                            view</span></button>
                                </div>
                            </div>
                            <div class="add-to-cart">
                                <button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> add to
                                    cart</button>
                            </div>
                        </div>
                    </div>
                @endforeach --}}




                @foreach ($relatedProducts as $relatedProduct)
                    @php
                        $price = $relatedProduct->price;

                        if ($price !== null) {
                            $old_price = $price->regular_price;
                            $selling_price = $price->selling_price;
                            $discount_value = $price->discount_value;
                            $discount_type = $price->discount_type !== null ? $price->discount_type : 'none';
                        } else {
                            $old_price = 0;
                            $selling_price = 0;
                            $discount_value = 0;
                            $discount_type = 'none';
                        }

                        $percent_price = $old_price - ($old_price * $discount_value) / 100;
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

                                @if ($discount_type === 'percent' && $discount_value > 0)
                                    <div class="product-label">
                                        <span class="sale">{{ $discount_value }}%</span>
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
                                    <a href="#">{{ $relatedProduct->name }}</a>
                                </h3>

                                <h4 class="product-price">
                                    @if ($discount_type === 'none' && $discount_value == null)
                                        ৳ {{ $old_price }}
                                    @elseif ($discount_type === 'flat' && $discount_value > 0)
                                        <del class="text-muted me-2">৳{{ $old_price }}</del>
                                        <span>৳{{ $old_price - $discount_value }}</span>
                                    @elseif ($discount_type === 'percent' && $discount_value > 0)
                                        <del class="text-danger me-2">৳ {{ $old_price }}</del>
                                        <span>৳ {{ $percent_price }}</span>
                                    @endif
                                </h4>


                                {{-- Buttons --}}
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

                            {{-- Add to Cart --}}
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
        </div>
    </section>
    @include('inc.footers.global.global_footer')

    @include('auth.login')
    @include('auth.register')
@endsection
