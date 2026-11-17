 <div class="card-header p-1">
     <form action="{{ route('frontend.carts.apply-coupon') }}" method="POST" id="coupon-form">
         @csrf

         <div class="coupon-box mb-1">
             <input type="text" name="coupon_code" id="coupon_code" maxlength="30" value="{{ old('coupon_code') }}"
                 class="form-control p-2 @error('coupon_code') is-invalid @enderror" placeholder="Enter coupon code"
                 required>

             <button type="submit" id="applyCoupon">
                 Apply Coupon
             </button>
         </div>

         @php
             use Illuminate\Support\Str;
             $couponCode = session('coupon_code');
         @endphp

         <div id="appliedCouponContainer">
             @if (!empty($couponCode))
                 <div class="coupon-applied d-flex justify-content-between align-items-center p-1 border rounded">
                     <div>
                         <i class="fa-solid fa-ticket text-success"></i>
                         <span>Applied:</span>
                         <small class="text-success fw-bold">
                             {{ Str::limit($couponCode, 13, '...') }}
                         </small>
                     </div>

                     <button type="button" id="remove-coupon" class="btn btn-sm btn-outline-danger">
                         <i class="fa-solid fa-trash"></i>
                         Remove
                     </button>
                 </div>
             @endif
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

     </div>
 </div>

 @push('scripts')
     <script>
         $(document).on('submit', '#coupon-form', function(e) {
             e.preventDefault();
             let button = $('#applyCoupon');
             let code = $('#coupon_code').val().trim();
             if (!code) {
                 toastr.error('Please enter coupon code.');
                 return;
             }
             button.prop('disabled', true);

             $.ajax({
                 url: $(this).attr('action'),
                 type: 'POST',
                 data: {
                     coupon_code: code,
                 },
                 success: function(response) {
                     if (response.status) {
                         $('#cartItemsBody').html(response.cart_table);
                         $('#cartSummaryBody').html(response.cart_summary);
                         $('#appliedCouponContainer').html(response.applied_coupon);
                         toastr.success(response.message);
                     }
                 },
                 error: function(xhr) {
                     let message = xhr.responseJSON?.message || 'Unable to apply coupon.';
                     toastr.error(message);
                 },
                 complete: function() {
                     button.prop('disabled', false);
                 }
             });
         });

         $(document).on('click', '#remove-coupon', function() {
             let button = $(this);
             button.prop('disabled', true);

             $.ajax({
                 url: "{{ route('frontend.carts.remove-coupon') }}",
                 type: 'POST',
                 success: function(response) {
                     if (response.status) {
                         $('#cartItemsBody').html(response.cart_table);
                         $('#cartSummaryBody').html(response.cart_summary);
                         $('#appliedCouponContainer').html('');
                         $('#coupon_code').val('');
                         toastr.success(response.message);
                     }
                 },
                 error: function(xhr) {
                     toastr.error(
                         xhr.responseJSON?.message || 'Unable to remove coupon.'
                     );
                 }
             });
         });
     </script>
 @endpush
