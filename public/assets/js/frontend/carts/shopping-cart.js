$(document).ready(function () {
    const url = "/Ecommerce/public/cart/shopping-cart";

    $.ajax({
        type: "GET",
        url: url,
        dataType: "html",

        beforeSend: function () {
            $("#shoppingCartContainer").html(`
                <div class="text-center p-4">
                    <span class="spinner-border text-primary"></span>
                    <p class="mt-2">Loading cart...</p>
                </div>
            `);
        },

        success: function (response) {
            $("#shoppingCartContainer").html(response);
        },

        error: function (xhr, status, error) {
            console.error("Shopping Cart Error:", error);
            console.error("Status:", xhr.status);
            console.error("HTTP Status:", xhr.status);
            console.error("Response:", xhr.responseText);

            $("#shoppingCartContainer").html(`
                <div class="text-center alert alert-danger m-2">
                    Unable to load shopping cart.
                </div>
            `);
        },
    });
});
