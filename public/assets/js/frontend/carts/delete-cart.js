$(function () {
    $(document).on("click", ".remove-btn", function (e) {
        e.preventDefault();

        const $button = $(this);
        const url = $button.data("url");

        if (!url) {
            toastr.error("Delete URL not found.");
            return;
        }
        if ($button.prop("disabled")) {
            return;
        }
        $button.prop("disabled", true);

        $.ajax({
            url: url,
            type: "DELETE",

            beforeSend: function () {
                $button.html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>',
                );
            },

            success: function (response) {
                if (!response.status) {
                    toastr.warning(
                        response.message || "Unable to remove item.",
                    );
                    return;
                }
                if (response.cart_table !== undefined) {
                    $("#cartItemsBody").html(response.cart_table);
                }
                if (response.cart_summary !== undefined) {
                    $("#cartSummaryBody").html(response.cart_summary);
                }
                const quantity = Number(response.cart_item_quantity);
                if (quantity > 0) {
                    $(".cart-item-quantity").text(quantity).show();
                } else {
                    $(".cart-item-quantity").hide();
                }
                toastr.success(response.message);
            },

            error: function (xhr) {
                customErrorHandler(xhr);
            },
            complete: function () {
                $button
                    .prop("disabled", false)
                    .html('<i class="bi bi-trash"></i>');
            },
        });
    });
});
