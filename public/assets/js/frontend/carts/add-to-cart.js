$(document).ready(function () {
    // add-to-cart start here
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
    // add-to-cart end here
});
