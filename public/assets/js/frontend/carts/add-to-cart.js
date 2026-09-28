$(document).ready(function () {
    $(document).on("submit", "#add_to_cart", function (e) {
        e.preventDefault();

        const form = $(this);
        const button = $("#addToCartBtn");
        button.prop("disabled", true);

        $.ajax({
            type: "POST",
            url: form.attr("action"),
            data: form.serialize(),

            success: function (response) {
                if (response.status) {
                    const quantity = parseInt(response.cart_item_quantity) || 0;
                    const badge = $(".cart-item-quantity");
                    badge.text(quantity);
                    if (quantity > 0) {
                        badge.show();
                    } else {
                        badge.hide();
                    }
                    toastr.success(response.message);
                } else {
                    toastr.warning(response.message);
                }
            },

            error: function (xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;

                    $.each(errors, function (field, messages) {
                        messages.forEach(function (message) {
                            toastr.error(message);
                        });
                    });
                } else {
                    toastr.error("Something went wrong.");
                }
            },

            complete: function () {
                button.prop("disabled", false);
            },
        });
    });
});
