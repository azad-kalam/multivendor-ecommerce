$(function () {
    const url = route("frontend.carts.shopping-cart");

    $.ajax({
        type: "GET",
        url: url,
        dataType: "json",

        beforeSend: function () {
            $("#cartItemsContainer").html(`
                <tr class="cart-loading-row">
                    <td colspan="9">
                        <div class="cart-loading-content">
                            <span class="spinner-border text-primary"
                                  role="status"
                                  aria-hidden="true"></span>
                            <span class="cart-loading-text">
                                Loading cart...
                            </span>
                        </div>
                    </td>
                </tr>
            `);

            $("#cart-details").html(`
               <div class="cart-loading-content">
                    <span class="spinner-border text-primary" role="status"aria-hidden="true"></span>
                    <span class="cart-loading-text"> Loading cart... </span>
                </div>
            `);
        },

        success: function (response) {
            $("#cartItemsContainer").html(response.cartTable);
            $("#cart-details").html(response.cartSummary);
        },

        error: function (error) {
            customErrorHandler(error);

            $("#cartItemsContainer").html(`
                <tr class="cart-error-row">
                    <td colspan="9">
                        <div class="cart-error-content">
                            <div class="alert alert-danger m-0">
                                Failed to load shopping cart.
                            </div>
                        </div>
                    </td>
                </tr>
            `);

            $("#cart-details").html(`
                <div class="alert alert-danger m-2">
                    Failed to load cart summary.
                </div>
            `);
        },
    });
});
