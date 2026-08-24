@extends('layouts.master_layout', ['title' => 'Shopping Cart'])

@section('content')
    <section class="page-header container-fluid">
        <h1>SHOPPING CART</h1>
        <div class="breadcrumb">
            <a href="{{ url()->previous() }}" class="btn btn-dark text-white back ms-2 px-1 py-0" aria-label="Go back">
                <i class="fa-solid fa-arrow-left me-1"></i>
                Back
            </a>
            <a href="{{ url('/') }}">Home</a>
            <span>−</span>
            <span> Shopping Cart</span>
        </div>
    </section>

    <main class="cart-container container-fluid">
        <div class="row g-4">
            <section class="cart-products col-12 col-md-8">
                <div class="cart-table border border-1 border-danger rounded-2">
                    <table class="cart-table-inner">
                        <thead>
                            <tr class="cart-row cart-header">
                                <th class="cart-no">No</th>
                                <th class="cart-product text-center">Product</th>
                                <th class="cart-name">Name</th>
                                <th class="cart-quantity"> Quantity</th>
                                <th class="cart-price">Price</th>
                                <th class="cart-price-less">Discount</th>
                                <th class="cart-total"> Total</th>
                                <th class="cart-remove">Delete</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($carts as $index => $cart)
                                @php
                                    $regularPrice = $cart->variant->regular_price ?? 0;
                                    $sellingPrice = $cart->variant->selling_price ?? 0;
                                    $quantity = $cart->product_quantity ?? 1;
                                    $priceLess = max(0, $regularPrice - $sellingPrice);
                                    $productTotal = $sellingPrice * $quantity;
                                @endphp

                                <tr class="cart-row product-row" data-price="{{ $regularPrice }}"
                                    data-selling-price="{{ $sellingPrice }}" data-price-less="{{ $priceLess }}"
                                    data-discount-type="{{ $cart->variant->discount_type ?? 'none' }}"
                                    data-discount-value="{{ $cart->variant->discount_value ?? 0 }}"
                                    data-cart-id="{{ $cart->id }}">

                                    <td class="cart-no serial-number">
                                        {{ $index + 1 }}
                                    </td>

                                    <td class="cart-product">
                                        <div class="product-info">
                                            <div class="d-flex align-items-center justify-content-center btn btn-outline-success p-1 border border-1 border-info rounded"
                                                style="width: 50px; height: 50px;">
                                                <img src="{{ asset($cart->variant->images->first()?->public_path) }}"
                                                    alt="{{ $cart->product->name ?? 'Product' }}"
                                                    class="h-100 w-100 rounded">
                                            </div>
                                        </div>
                                    </td>

                                    <td class="cart-name">
                                        <span class="product-name">
                                            {{ $cart->product->name ?? 'Product Name' }}
                                        </span>
                                    </td>

                                    <td class="cart-quantity">
                                        <div class="quantity-box">
                                            <button type="button" class="qty-minus quantity_down"
                                                aria-label="Decrease quantity">
                                                <i class="bi bi-dash"></i>
                                            </button>
                                            <span class="quantity">{{ $quantity }}</span>
                                            <button type="button" class="qty-plus quantity_up"
                                                aria-label="Increase quantity">
                                                <i class="bi bi-plus"></i>
                                            </button>
                                        </div>
                                    </td>

                                    <td class="cart-price">
                                        <span class="product-price">
                                            <i class="fa-solid fa-bangladeshi-taka-sign"></i>
                                            {{ number_format($sellingPrice, 0) }}
                                        </span>
                                    </td>



                                    <td class="cart-price-less">
                                        <span class="product-price-less">
                                            <i class="fa-solid fa-bangladeshi-taka-sign"></i>
                                            {{ number_format($priceLess, 0) }}
                                        </span>
                                    </td>

                                    <td class="cart-total">
                                        <span class="product-total">
                                            <i class="fa-solid fa-bangladeshi-taka-sign"></i>
                                            {{ number_format($productTotal, 0) }}
                                        </span>
                                    </td>

                                    <td class="cart-remove text-center">
                                        <button type="button" class="btn btn-outline-danger remove-btn"
                                            data-cart-id="{{ $cart->id }}" aria-label="Remove product">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr class="empty-cart-row">
                                    <td colspan="8" class="empty-cart">
                                        <p class="text-danger"> Your cart is empty.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            <aside class="col-12 col-md-4">
                <div class="coupon-details border border-1 border-danger rounded-2">
                    <div class="coupon-box">
                        <input type="text" class="form-control" id="couponCode" placeholder="Coupon Code">
                        <button type="button" id="applyCoupon">
                            Apply Coupon
                        </button>
                    </div>

                    <div class="cart-summary">
                        <div class="summary-title">
                            <h2>Cart Summary</h2>
                        </div>

                        <div class="summary-content">
                            <div class="summary-row">
                                <span>Sub - Total</span>
                                <strong id="subtotal">
                                    <i class="fa-solid fa-bangladeshi-taka-sign"></i> 0
                                </strong>
                            </div>

                            <div class="summary-row">
                                <span>Total Discount</span>
                                <strong id="discount">
                                    <i class="fa-solid fa-bangladeshi-taka-sign"></i> 0
                                </strong>
                            </div>
                        </div>

                        <div class="summary-total">
                            <span>Grand Total</span>
                            <i class="fa-solid fa-equals"></i>
                            <strong id="grandTotal">
                                <i class="fa-solid fa-bangladeshi-taka-sign"></i> 0
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
