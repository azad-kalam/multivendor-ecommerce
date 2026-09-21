// $(document).ready(function () {
//     $(document).on("click", ".update_quantity_up", function () {
//         let button = $(this);

//         let cartId = button.data("cart-id");
//         let row = button.closest(".cart-row");
//         let quantityElement = row.find(".quantity");
//         let currentQuantity = parseInt(quantityElement.text()) || 0;
//         let newQuantity = currentQuantity + 1;
//         updateCartQuantity(cartId, newQuantity, row);
//     });

//     $(document).on("click", ".update_quantity_down", function () {
//         let button = $(this);
//         let cartId = button.data("cart-id");
//         let row = button.closest(".cart-row");
//         let quantityElement = row.find(".quantity");
//         let currentQuantity = parseInt(quantityElement.text()) || 0;
//         let newQuantity = currentQuantity - 1;
//         if (newQuantity < 1) {
//             toastr.warning("Quantity must be at least 1.");
//             return;
//         }

//         updateCartQuantity(cartId, newQuantity, row);
//     });

//     function updateCartQuantity(cartId, productQuantity, row) {
//         let buttons = row.find(".update_quantity_up, .update_quantity_down");
//         let quantityElement = row.find(".quantity");
//         buttons.prop("disabled", true);
//         const url = route("frontend.carts.update");

//         $.ajax({
//             url: url,
//             type: "PATCH",
//             data: {
//                 cart_id: cartId,
//                 product_quantity: productQuantity,
//             },

//             success: function (response) {
//                 if (response.status !== true) {
//                     toastr.warning(
//                         response.message || "Unable to update cart.",
//                     );

//                     return;
//                 }

//                 let cart = response.cart;
//                 quantityElement.text(cart.quantity);
//                 row.find(".product-price-less .amount").text(
//                     formatMoney(cart.item_discount),
//                 );

//                 row.find(".product-total .amount").text(
//                     formatMoney(cart.item_subtotal),
//                 );

//                 let summary = response.summary;

//                 $("#cart-subtotal").text(formatMoney(summary.subtotal));

//                 $("#cart-product-discount").text(
//                     formatMoney(summary.product_discount),
//                 );

//                 $("#cart-coupon-discount").text(
//                     formatMoney(summary.coupon_discount),
//                 );

//                 $("#cart-grand-total").text(formatMoney(summary.grand_total));

//                 toastr.success(response.message);
//             },

//             error: function (xhr) {
//                 let message = "Something went wrong.";
//                 if (xhr.responseJSON && xhr.responseJSON.message) {
//                     message = xhr.responseJSON.message;
//                 }

//                 toastr.error(message);
//             },

//             complete: function () {
//                 buttons.prop("disabled", false);
//             },
//         });
//     }

//     function formatMoney(value) {
//         value = parseFloat(value) || 0;
//         return value.toLocaleString("en-BD", {
//             minimumFractionDigits: 2,
//             maximumFractionDigits: 2,
//         });
//     }
// });

$(document).ready(function () {
    $(document).on("click", ".update_quantity_up", function () {
        let button = $(this);

        let cartId = button.data("cart-id");

        let row = button.closest(".cart-row");

        let quantityElement = row.find(".quantity");

        let currentQuantity = parseInt(quantityElement.text()) || 0;

        let newQuantity = currentQuantity + 1;

        updateCartQuantity(cartId, newQuantity, row);
    });

    $(document).on("click", ".update_quantity_down", function () {
        let button = $(this);

        let cartId = button.data("cart-id");

        let row = button.closest(".cart-row");

        let quantityElement = row.find(".quantity");

        let currentQuantity = parseInt(quantityElement.text()) || 0;

        let newQuantity = currentQuantity - 1;

        if (newQuantity < 1) {
            toastr.warning("Quantity must be at least 1.");

            return;
        }

        updateCartQuantity(cartId, newQuantity, row);
    });

    function updateCartQuantity(cartId, productQuantity, row) {
        let buttons = row.find(".update_quantity_up, .update_quantity_down");

        let quantityElement = row.find(".quantity");

        buttons.prop("disabled", true);

        const url = route("frontend.carts.update");

        $.ajax({
            url: url,

            type: "PATCH",

            data: {
                cart_id: cartId,

                product_quantity: productQuantity,
            },

            success: function (response) {
                if (response.status !== true) {
                    toastr.warning(
                        response.message || "Unable to update cart.",
                    );

                    return;
                }

                let cart = response.cart;

                quantityElement.text(cart.quantity);

                row.find(".product-price .amount").text(
                    formatMoney(cart.item_price),
                );

                row.find(".product-price-less .amount").text(
                    formatMoney(cart.item_discount),
                );

                row.find(".product-total .amount").text(
                    formatMoney(cart.item_total),
                );

                let summary = response.summary;

                $("#cart-subtotal").text(formatMoney(summary.subtotal));

                $("#cart-product-discount").text(
                    formatMoney(summary.product_discount),
                );

                $("#cart-coupon-discount").text(
                    formatMoney(summary.coupon_discount),
                );

                $("#cart-grand-total").text(formatMoney(summary.grand_total));

                toastr.success(response.message);
            },

            error: function (xhr) {
                let message = "Something went wrong.";

                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }

                toastr.error(message);
            },

            complete: function () {
                buttons.prop("disabled", false);
            },
        });
    }

    function formatMoney(value) {
        value = parseFloat(value) || 0;

        return value.toLocaleString("en-BD", {
            minimumFractionDigits: 2,

            maximumFractionDigits: 2,
        });
    }
});
