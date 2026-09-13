$(function () {
    const url = route("frontend.carts.shopping-cart");

    $.ajax({
        type: "GET",
        url: url,
        dataType: "html",

        beforeSend: function () {
            $("#cartItemsContainer").html(`
                <tr class="cart-loading-row">
                    <td colspan="9">
                        <div class="cart-loading-content">
                            <span class="spinner-border text-primary" role="status"aria-hidden="true"></span>
                            <span class="cart-loading-text"> Loading cart... </span>
                        </div>
                    </td>
                </tr>
            `);
        },

        success: function (response) {
            $("#cartItemsContainer").html(response);
        },

        error: function (error) {
            customErrorHandler(error);

            $("#cartItemsContainer").html(`
                <tr class="cart-error-row">
                    <td colspan="9">
                        <div class="cart-error-content">
                            <div class="alert alert-danger m-0">
                                Unable to load shopping cart.
                            </div>
                        </div>
                    </td>
                </tr>
            `);
        },
    });
});
