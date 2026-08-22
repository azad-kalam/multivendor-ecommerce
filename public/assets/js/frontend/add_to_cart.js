// @include('partials.toastr_options.toastr_option')
// @include('partials.error_options.errorHandler')

$(document).ready(function () {
    // AJAX add_to_cart start here
    const variants = window.variantData || [];

    $("#add_to_cart").on("submit", function (e) {
        e.preventDefault();

        const form = $(this);
        const productId = $("#productId").val();
        const variantId = $("#productVariantId").val();
        const quantity = Number($("#productQuantity").val());

        if (!productId) {
            toastr.error("Product ID is required.");
            return;
        }

        if (!variantId) {
            toastr.error("Product variant is required.");
            return;
        }

        if (!quantity || quantity < 1) {
            toastr.error("Quantity must be at least 1.");
            return;
        }

        const url = form.attr("action");

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },

            url: url,
            method: "POST",
            dataType: "json",
            data: form.serialize(),
            success: function (response) {
                console.log(response);

                if (response.cart_status === "success") {
                    toastr.success(response.cart_message);

                    if (response.cart_count !== undefined) {
                        $(".cart-count").text(response.cart_count);
                    }
                    return;
                }
                if (response.cart_status === "error") {
                    toastr.error(response.cart_message);
                    return;
                }
            },

            error: function (err) {
                if (typeof customErrorHandler === "function") {
                    customErrorHandler(err);
                } else {
                    toastr.error("Something went wrong. Please try again.");
                }
            },
        });
    });
    // AJAX add_to_cart end here
});
