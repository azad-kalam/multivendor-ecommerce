$(document).ready(function () {
    const cartSummaryUrl = route("frontend.carts.cart-summary");

    $.ajax({
        url: cartSummaryUrl,
        type: "GET",

        beforeSend: function () {
            $("#cart-details").html(`
               <div class="cart-loading-content">
                    <span class="spinner-border text-primary" role="status"aria-hidden="true"></span>
                    <span class="cart-loading-text"> Loading cart... </span>
                </div>
            `);
        },
        success: function (response) {
            $("#cart-details").html(response);
        },

        error: function (xhr, status, error) {
            alert("Cart Summary Error:", error);

            alert("Response:", xhr.responseText);

            $("#cart-details").html(`
                    <div class="alert alert-danger m-2">
                        Failed to load cart summary.
                    </div>
                `);
        },
    });
});
