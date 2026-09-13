$(function () {
    $(document).on("click", ".remove-btn", function (e) {
        e.preventDefault();

        const $button = $(this);
        const url = $button.data("url");
        const cartId = $button.data("cart-id");

        if (!url) {
            toastr.error("Delete URL not found.");
            return;
        }

        const $row = $button.closest(".cart-row");
        $button.prop("disabled", true);

        $.ajax({
            url: url,
            type: "DELETE",

            beforeSend: function () {
                $button
                    .prop("disabled", true)
                    .html(
                        '<span class="spinner-border spinner-border-sm"></span>',
                    );
            },

            success: function (response) {
                $row.fadeOut(300, function () {
                    $(this).remove();
                    updateCartSerialNumbers();
                    checkEmptyCart();
                });

                toastr.success(response.message);
            },

            error: function (error) {
                customErrorHandler(error);

                $button.prop("disabled", false);
                $button.html('<i class="bi bi-trash"></i>');
            },

            complete: function () {
                $button.prop("disabled", false);
            },
        });
    });

    // Update serial number start here
    function updateCartSerialNumbers() {
        $(".cart-row").each(function (index) {
            $(this)
                .find(".serial-number")
                .text(index + 1);
        });
    }
    //update serial number end here

    // Check empty cart start here
    function checkEmptyCart() {
        const $cartRows = $(".cart-row");

        if ($cartRows.length === 0) {
            const emptyRow = `
                <tr class="empty-cart-row">
                    <td colspan="9" class="empty-cart">
                        <p class="text-danger">
                            Your cart is empty.
                        </p>
                    </td>
                </tr>
            `;

            $("#cartItemsContainer").html(emptyRow);
        }
    }
    // check empty cart end here
});
