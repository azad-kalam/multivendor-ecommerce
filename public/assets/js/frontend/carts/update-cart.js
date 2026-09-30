$(function () {
    // Quantity Up
    $(document).on("click", ".quantity-box .quantity_up", function (e) {
        e.preventDefault();

        const button = $(this);

        if (button.prop("disabled")) {
            return;
        }

        const url = button.data("url");

        const quantityBox = button.closest(".quantity-box");
        const quantityFind = quantityBox.find(".quantity");

        let quantity = parseInt(quantityFind.text(), 10) || 1;

        quantity++;

        updateCart(url, quantity);
    });

    // Quantity Down
    $(document).on("click", ".quantity-box .quantity_down", function (e) {
        e.preventDefault();

        const button = $(this);

        if (button.prop("disabled")) {
            return;
        }

        const url = button.data("url");

        const quantityBox = button.closest(".quantity-box");
        const quantityFind = quantityBox.find(".quantity");

        let quantity = parseInt(quantityFind.text(), 10) || 1;

        // Minimum quantity = 1
        if (quantity <= 1) {
            toastr.warning("Minimum quantity must be 1.");
            return;
        }

        quantity--;

        updateCart(url, quantity);
    });

    function updateCart(url, quantity) {
        $(".quantity_up, .quantity_down").prop("disabled", true);

        $.ajax({
            type: "PATCH",
            url: url,

            data: {
                product_quantity: quantity,
            },

            success: function (response) {
                if (!response.status) {
                    toastr.warning(response.message);
                    return;
                }

                $("#cartItemsBody").html(response.cart_table);

                $("#cartSummaryBody").html(response.cart_summary);

                if (response.cart_item_quantity > 0) {
                    $(".cart-item-quantity")
                        .text(response.cart_item_quantity)
                        .show();
                } else {
                    $(".cart-item-quantity").hide();
                }

                toastr.success(response.message);
            },

            error: function (xhr) {
                customErrorHandler(xhr);
            },

            complete: function () {
                $(".quantity_up, .quantity_down").prop("disabled", false);
            },
        });
    }
});
