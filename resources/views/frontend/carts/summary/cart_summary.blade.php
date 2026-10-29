 <div class="card-header p-1">
     <form action="{{ route('frontend.carts.apply-coupon') }}" method="POST">
         @csrf

         <div class="coupon-box mb-1">
             <input type="text" name="coupon_code" id="coupon_code" maxlength="30" value="{{ old('coupon_code') }}"
                 class="form-control p-2 @error('coupon_code') is-invalid @enderror" placeholder="Enter coupon code"
                 required>

             <button type="submit" id="applyCoupon">
                 Apply Coupon
             </button>
         </div>

         @error('coupon_code')
             <div class="coupon-error text-danger">
                 {{ $message }}
             </div>
         @enderror
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
