<div class="summary-title">
    <h2>Cart Summary</h2>
</div>

<div class="summary-content">
    <div class="summary-row">
        <span>Sub - Total</span>
        <strong id="subtotal">
            <i class="fa-solid fa-bangladeshi-taka-sign"></i>{{ $subtotal }}
        </strong>
    </div>

    <div class="summary-row">
        <span>Product Discount</span>
        <strong id="discount">
            <i class="fa-solid fa-bangladeshi-taka-sign"></i>{{ $discount }}
        </strong>
    </div>

    <div class="summary-row">
        <span>Coupon Discount</span>
        <strong id="couponDiscount">
            <i class="fa-solid fa-bangladeshi-taka-sign"></i>
        </strong>
    </div>
</div>

<div class="summary-total">
    <span>Grand Total</span>
    <i class="fa-solid fa-equals"></i>
    <strong id="grandTotal">
        <i class="fa-solid fa-bangladeshi-taka-sign"></i>{{ $grand_total }}
    </strong>
</div>

<button type="button" class="checkout-btn btn btn-outline-success w-100 p-3">
    Proceed To Checkout
</button>
