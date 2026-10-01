<div class="summary-row">
    <span>Sub - Total</span>
    <span>
        <i class="fa-solid fa-bangladeshi-taka-sign"></i>
        <span id="cart-subtotal">
            {{ number_format($subtotal ?? 0, 2) }}
        </span>
    </span>
</div>

<div class="summary-row">
    <span>Product Discount</span>
    <span>
        <i class="fa-solid fa-bangladeshi-taka-sign"></i>
        <span id="cart-product-discount">
            {{ number_format($product_discount ?? 0, 2) }}
        </span>
    </span>
</div>

<div class="summary-row">
    <span>Coupon Discount</span>
    <span>
        <i class="fa-solid fa-bangladeshi-taka-sign"></i>
        <span id="cart-coupon-discount">
            {{ number_format($coupon_discount ?? 0, 2) }}
        </span>
    </span>
</div>

<div class="summary-total">
    <strong>Grand Total</strong>
    <strong>
        <i class="fa-solid fa-bangladeshi-taka-sign"></i>
        <span id="cart-grand-total">
            {{ number_format($grand_total ?? 0, 2) }}
        </span>
    </strong>
</div>
