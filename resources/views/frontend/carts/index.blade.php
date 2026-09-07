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
                    <table class="cart-table-inner">
                        <thead>
                            <tr class="cart-row cart-header">
                                <th class="cart-no">No</th>
                                <th class="cart-product text-center">Product </th>
                                <th class="cart-name">Name</th>
                                <th class="cart-variant">Variant</th>
                                <th class="cart-quantity"> Quantity</th>
                                <th class="cart-price">Price</th>
                                <th class="cart-price-less">Discount</th>
                                <th class="cart-total">Total</th>
                                <th class="cart-remove">Delete</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($cart_items as $index => $cart_item)
                                <tr class="cart-row product-row">

                                    <td class="cart-no serial-number">
                                        {{ $index + 1 }}
                                    </td>

                                    <td class="cart-product">
                                        <div class="product-info">
                                            <div class="d-flex align-items-center justify-content-center
                                            btn btn-outline-success p-1
                                            border border-1 border-info rounded"
                                                style="width: 50px; height: 50px;">

                                                @if (!empty($cart_item['image']))
                                                    <img src="{{ $cart_item['image'] }}"
                                                        alt="{{ $cart_item['product_name'] ?? 'Product' }}"
                                                        class="h-100 w-100 rounded">
                                                @else
                                                    <span class="text-danger">
                                                        No Image
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <td class="cart-name">
                                        <span class="product-name">
                                            {{ $cart_item['product_name'] ?? 'Product Name' }}
                                        </span>
                                    </td>

                                    <td class="variant-name">
                                        <ul>
                                            <li>{{ ucwords(strtolower($cart_item['color_name'] ?? 'Color')) }}</li>
                                            <li>{{ $cart_item['size_name'] ?? 'Size' }}</li>
                                        </ul>
                                    </td>

                                    <td class="cart-quantity">
                                        <div class="quantity-box">
                                            <button type="button" class="qty-minus quantity_down"
                                                aria-label="Decrease quantity">
                                                <i class="bi bi-dash"></i>
                                            </button>

                                            <span class="quantity">
                                                {{ $cart_item['product_quantity'] ?? 0 }}
                                            </span>

                                            <button type="button" class="qty-plus quantity_up"
                                                aria-label="Increase quantity">
                                                <i class="bi bi-plus"></i>
                                            </button>
                                        </div>
                                    </td>

                                    <td class="cart-price">
                                        <span class="product-price">
                                            <i class="fa-solid fa-bangladeshi-taka-sign"></i>
                                            {{ number_format($cart_item['price'] ?? 0, 2) }}
                                        </span>
                                    </td>

                                    <td class="cart-price-less">
                                        <span class="product-price-less">
                                            <i class="fa-solid fa-bangladeshi-taka-sign"></i>
                                            {{ number_format(($cart_item['discount'] ?? 0) * ($cart_item['product_quantity'] ?? 1), 2) }}
                                        </span>
                                    </td>

                                    <td class="cart-total">
                                        <span class="product-total">
                                            <i class="fa-solid fa-bangladeshi-taka-sign"></i>
                                            {{ number_format($cart_item['cart_quantity_price'] ?? 0, 2) }}
                                        </span>
                                    </td>

                                    <td class="cart-remove text-center">
                                        <button type="button" class="btn btn-outline-danger remove-btn"
                                            data-cart-id="{{ $cart_item['id'] ?? 0 }}" aria-label="Remove product">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr class="empty-cart-row">
                                    <td colspan="8" class="empty-cart">
                                        <p class="text-danger">
                                            Your cart is empty.
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
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

                    <div>
                        <div class="summary-title">
                            <h2>Cart Summary</h2>
                        </div>

                        <div class="summary-content">
                            <div class="summary-row">
                                <span>Sub - Total</span>
                                <strong id="subtotal">
                                    <i class="fa-solid fa-bangladeshi-taka-sign"></i> {{ $subtotal ?? 0 }}
                                </strong>
                            </div>

                            <div class="summary-row">
                                <span>Product Discount</span>
                                <strong id="discount">
                                    <i class="fa-solid fa-bangladeshi-taka-sign"></i> {{ $discount ?? 0 }}
                                </strong>
                            </div>

                            <div class="summary-row">
                                <span>Coupon Discount</span>
                                <strong id="couponDiscount">
                                    <i class="fa-solid fa-bangladeshi-taka-sign"></i> {{ $coupon_discount ?? 0 }}
                                </strong>
                            </div>
                        </div>

                        <div class="summary-total">
                            <span>Grand Total</span>
                            <i class="fa-solid fa-equals"></i>
                            <strong id="grandTotal">
                                <i class="fa-solid fa-bangladeshi-taka-sign"></i> {{ $grand_total ?? 0 }}
                            </strong>
                        </div>

                        <button type="button" class="checkout-btn btn btn-outline-success w-100 p-3">
                            Proceed To Checkout
                        </button>
                    </div>
                </div>
            </aside>
        </div>
    </main>
@endsection
