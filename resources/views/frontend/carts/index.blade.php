@extends('layouts.master_layout', ['title' => 'Shopping Cart'])
@include('inc.headers.global.global_header')

@section('content')
    <section class="page-header container-fluid" style="margin-top: 100px;">
        <h1>SHOPPING CART</h1>
        <div class="breadcrumb">
            <a href="{{ url()->previous() }}" class="btn btn-dark text-white back ms-2 px-1 py-0" aria-label="Go back">
                <i class="fa-solid fa-arrow-left me-1"></i>
                Back
            </a>
            <a class="active" href="{{ url('/') }}">Home</a>
            <span>−</span>
            <span>Shopping Cart</span>
        </div>
    </section>

    <main class="cart-container container-fluid">
        <div class="row g-4">
            <section class="cart-products col-12 col-md-9">
                <div class="cart-table border border-1 border-danger rounded-2">
                    <table class="cart-table-inner w-100">
                        <thead>
                            <tr class="cart-row cart-header">
                                <th class="cart-no">No </th>
                                <th class="cart-product text-center">Product </th>
                                <th class="cart-name"> Name </th>
                                <th class="cart-variant">Variant</th>
                                <th class="cart-quantity">Quantity</th>
                                <th class="cart-price">Price</th>
                                <th class="cart-discount">Discount </th>
                                <th class="cart-total"> Total</th>
                                <th class="cart-remove"> Delete</th>
                            </tr>
                        </thead>

                        <tbody id="cartItemsContainer">
                            {{-- AJAX dynamic cart load here --}}
                        </tbody>
                    </table>
                </div>
            </section>

            <aside class="col-12 col-md-3">
                <div class="coupon-details border border-1 border-danger rounded-2">
                    <form action="" method="post">
                        <div class="coupon-box">
                            <input type="text" class="form-control" id="couponCode" placeholder="Enter coupon code">
                            <button type="button" id="applyCoupon">
                                Apply Coupon
                            </button>
                        </div>
                    </form>

                    <div id="cart-details">
                        {{-- AJAX cart summary load here --}}
                    </div>
                </div>
            </aside>
        </div>
    </main>
@endsection
@extends('layouts.master_layout', ['title' => 'Shopping Cart'])
@include('inc.headers.global.global_header')

@section('content')
    <section class="page-header container-fluid">
        <h1> SHOPPING CART</h1>

        <div class="breadcrumb">
            <a href="{{ url()->previous() }}" class="btn btn-dark text-white back ms-2 px-1 py-0" aria-label="Go back">
                <i class="fa-solid fa-arrow-left me-1"></i> Back
            </a>
            <a class="active" href="{{ url('/') }}"> Home </a>

            <span>−</span>
            <span>Shopping Cart</span>
        </div>
    </section>

    <main class="cart-container container-fluid">
        <div class="row g-4">
            <section class="cart-products col-12 col-md-9">
                <div class="cart-table border border-1 border-danger rounded-2">
                    @include('frontend.carts.table.cart_table')
                </div>
            </section>

            <aside class="col-12 col-md-3">
                <div class="card coupon-details border border-1 border-danger rounded-2">
                    <div class="card-header p-1">
                        <form action="" method="post">
                            <div class="coupon-box">
                                <input type="text" class="form-control" id="couponCode" placeholder="Enter code">
                                <button type="button" id="applyCoupon">Apply Coupon</button>
                            </div>
                        </form>
                    </div>

                    <div class="card-body">
                        <div class="card-title summary-title m-1">
                            <h2> Cart Summary </h2>
                        </div>

                        <div id="cartSummaryBody">
                            {{-- AJAX Cart Summary Will Load Here --}}
                        </div>
                    </div>

                    <div class="card-footer p-1">
                        <button type="button" class="checkout-btn btn btn-outline-success w-100 rounded-2 p-3">
                            Proceed To Checkout
                        </button>
                    </div>
                </div>
            </aside>
        </div>
    </main>
@endsection
