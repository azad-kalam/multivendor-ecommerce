$(function () {
    $(document).on("click", ".remove-btn", function (e) {
        e.preventDefault();

        const $button = $(this);
        const url = $button.data("url");

        if (!url) {
            toastr.error("Delete URL not found.");
            return;
        }

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
                $("#cartItemsBody").html(response.cartTable);
                $("#cartSummaryBody").html(response.cartSummary);

                toastr.success(
                    response.message || "Cart item deleted successfully.",
                );
            },

            error: function (error) {
                customErrorHandler(error);

                $button
                    .prop("disabled", false)
                    .html('<i class="bi bi-trash"></i>');
            },

            complete: function () {
                $button.prop("disabled", false);
            },
        });
    });
});
