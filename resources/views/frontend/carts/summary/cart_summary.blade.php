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
