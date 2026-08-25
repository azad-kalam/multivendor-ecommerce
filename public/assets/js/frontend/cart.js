// ============================================================
// cart_index.js
// ============================================================

// ============================================================
// 1. VARIANT.JS
// ============================================================

$(document).ready(function () {
    // ========================================================
    // VARIANT PAGE CHECK
    // ========================================================

    if (
        !$("#productId").length ||
        !$("#productVariantId").length ||
        !$("#sizeSelect").length ||
        !$("#colorSelect").length ||
        !$("#productQuantity").length
    ) {
        return;
    }

    // variant start here

    const variants = window.variantData || [];

    const productId = $("#productId");
    const variantId = $("#productVariantId");
    const sizeSelect = $("#sizeSelect");
    const colorSelect = $("#colorSelect");
    const quantityInput = $("#productQuantity");
    const availableQty = $("#availableQty");
    const productPrice = $(".product-price");
    const productBadge = $(".product-badge");
    const productAvailable = $(".product-available");

    // ========================================================
    // GET SELECTED VARIANT
    // ========================================================

    function getSelectedVariant() {
        const sizeId = Number(sizeSelect.val());
        const colorId = Number(colorSelect.val());

        return variants.find(function (variant) {
            return (
                Number(variant.size_id) === sizeId &&
                Number(variant.color_id) === colorId
            );
        });
    }

    // ========================================================
    // UPDATE PRODUCT
    // ========================================================

    function updateProduct(variant) {
        variantId.val(variant.id);
        productId.val(variant.product_id);

        const regularPrice = Number(variant.regular_price).toFixed(2);

        const sellingPrice = Number(variant.selling_price).toFixed(2);

        // ====================================================
        // PRICE
        // ====================================================

        if (variant.discount_type === "none") {
            productPrice.html(`
                <span class="text-dark fw-bold">
                    <i class="fa-solid fa-bangladeshi-taka-sign"></i>
                    ${regularPrice}
                </span>
            `);
        } else if (
            variant.discount_type === "fixed" ||
            variant.discount_type === "percent"
        ) {
            productPrice.html(`
                <span class="text-dark fw-bold">
                    <i class="fa-solid fa-bangladeshi-taka-sign"></i>
                    ${sellingPrice}
                </span>

                <del class="text-danger ms-2">
                    <i class="fa-solid fa-bangladeshi-taka-sign"></i>
                    ${regularPrice}
                </del>
            `);
        } else {
            productPrice.html(`
                <span class="text-danger">
                    Price not available
                </span>
            `);
        }

        // ====================================================
        // BADGE
        // ====================================================

        if (variant.discount_type === "none") {
            productBadge.html(`
                <span class="badge bg-danger">
                    NEW
                </span>
            `);
        } else if (variant.discount_type === "fixed") {
            productBadge.html(`
                <span class="badge bg-danger">
                    OFFER
                </span>
            `);
        } else if (variant.discount_type === "percent") {
            productBadge.html(`
                <span class="badge bg-danger">
                    ${variant.discount_value}% OFF
                </span>
            `);
        } else {
            productBadge.html(`
                <span class="text-danger">
                    No Offer
                </span>
            `);
        }

        // ====================================================
        // STOCK
        // ====================================================

        const stock = Number(variant.stock_quantity) || 0;

        const inStock = variant.stock_status === "in_stock" && stock > 0;

        productAvailable
            .removeClass("text-success text-danger")
            .addClass(inStock ? "text-success" : "text-danger")
            .text(inStock ? "In Stock" : "Out Of Stock");

        availableQty.text(stock);

        quantityInput.attr("max", stock);

        quantityInput.val(inStock ? 1 : 0);

        // ====================================================
        // VARIANT IMAGE
        // ====================================================

        if (variant.images && variant.images.length > 0) {
            const mainSlider = $("#product-main-img");

            if (mainSlider.hasClass("slick-initialized")) {
                const firstImage = variant.images[0];

                const mainImages = mainSlider.find(".main-img");

                let imageIndex = -1;

                mainImages.each(function (index) {
                    if ($(this).attr("src") === firstImage) {
                        imageIndex = index;

                        return false;
                    }
                });

                if (imageIndex >= 0) {
                    mainSlider.slick("slickGoTo", imageIndex);
                } else {
                    const firstMainImage = mainImages.first();

                    if (firstMainImage.length) {
                        firstMainImage.attr("src", firstImage);

                        mainSlider.slick("slickGoTo", 0, true);

                        mainSlider.slick("setPosition");
                    }
                }
            }
        }
    }

    // ========================================================
    // RESET PRODUCT
    // ========================================================

    function resetProduct() {
        variantId.val("");

        productPrice.html(`
            <span class="text-danger">
                Price not available
            </span>
        `);

        productBadge.empty();

        productAvailable
            .removeClass("text-success")
            .addClass("text-danger")
            .text("Out Of Stock");

        availableQty.text(0);

        quantityInput.attr("max", 0).val(0);
    }

    // ========================================================
    // UPDATE SELECTED VARIANT
    // ========================================================

    function updateSelectedVariant() {
        const variant = getSelectedVariant();

        if (variant) {
            updateProduct(variant);
        } else {
            resetProduct();

            toastr.warning("Size color combination no match");
        }
    }

    // ========================================================
    // INCREASE QUANTITY
    // ========================================================

    function increaseQuantity() {
        const quantity = Number(quantityInput.val()) || 0;

        const max = Number(quantityInput.attr("max")) || 0;

        if (quantity < max) {
            quantityInput.val(quantity + 1);
        }
    }

    // ========================================================
    // DECREASE QUANTITY
    // ========================================================

    function decreaseQuantity() {
        const quantity = Number(quantityInput.val()) || 1;

        const min = Number(quantityInput.attr("min")) || 1;

        if (quantity > min) {
            quantityInput.val(quantity - 1);
        }
    }

    // ========================================================
    // HANDLE QUANTITY INPUT
    // ========================================================

    function handleQuantityInput() {
        let quantity = Number(quantityInput.val()) || 1;

        const min = Number(quantityInput.attr("min")) || 1;

        const max = Number(quantityInput.attr("max")) || 0;

        if (quantity < min) {
            quantity = min;
        }

        if (max > 0 && quantity > max) {
            quantity = max;

            toastr.warning("Available stock is only " + max + ".");
        }

        quantityInput.val(quantity);
    }

    // ========================================================
    // VARIANT EVENTS
    // ========================================================

    sizeSelect.on("change", updateSelectedVariant);

    colorSelect.on("change", updateSelectedVariant);

    // ========================================================
    // QUANTITY UP
    // ========================================================

    $(".quantity_up").on("click", function (e) {
        e.preventDefault();

        increaseQuantity();
    });

    // ========================================================
    // QUANTITY DOWN
    // ========================================================

    $(".quantity_down").on("click", function (e) {
        e.preventDefault();

        decreaseQuantity();
    });

    quantityInput.on("input", handleQuantityInput);

    // ========================================================
    // INITIAL VARIANT
    // ========================================================

    const initialVariant = getSelectedVariant();

    if (initialVariant) {
        updateProduct(initialVariant);
    } else {
        resetProduct();
    }

    // variant end here
});

// ============================================================
// 2. CART.JS
// ============================================================

// @include('partials.toastr_options.toastr_option')
// @include('partials.error_options.errorHandler')

$(document).ready(function () {
    // ========================================================
    // CART PAGE / FORM CHECK
    // ========================================================

    if (!$("#add_to_cart").length) {
        return;
    }

    // AJAX add_to_cart start here

    $("#add_to_cart").on("submit", function (e) {
        e.preventDefault();

        const form = $(this);

        const productId = $("#productId").val();

        const variantId = $("#productVariantId").val();

        const quantity = Number($("#productQuantity").val());

        // ==================================================
        // PRODUCT ID
        // ==================================================

        if (!productId) {
            toastr.error("Product ID is required.");

            return;
        }

        // ==================================================
        // VARIANT ID
        // ==================================================

        if (!variantId) {
            toastr.error("Product variant is required.");

            return;
        }

        // ==================================================
        // QUANTITY
        // ==================================================

        if (!quantity || quantity < 1) {
            toastr.error("Quantity must be at least 1.");

            return;
        }

        // ==================================================
        // AJAX
        // ==================================================

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },

            url: form.attr("action"),

            method: "POST",

            dataType: "json",

            data: form.serialize(),

            // ==============================================
            // SUCCESS
            // ==============================================

            success: function (response) {
                console.log(response);

                if (response.cart_status === "success") {
                    toastr.success(response.cart_message);

                    if (response.cart_count !== undefined) {
                        const cartCountData = Number(response.cart_count);

                        const cartBadge = $(".cart_badge");

                        cartBadge.text(cartCountData);

                        if (cartCountData > 0) {
                            cartBadge.show();
                        } else {
                            cartBadge.hide();
                        }
                    }

                    return;
                }

                if (response.cart_status === "error") {
                    toastr.error(response.cart_message);

                    return;
                }
            },

            // ==============================================
            // ERROR
            // ==============================================

            error: function (err) {
                if (typeof customErrorHandler === "function") {
                    customErrorHandler(err);
                } else {
                    toastr.error("Something went wrong. Please try again.");
                }
            },
        });
    });

    // AJAX add_to_cart end here
});

// ========================================================
// SHOPPING CART JS
// ========================================================

document.addEventListener("DOMContentLoaded", function () {
    // ========================================================
    // CHECK CART
    // ========================================================

    if (!document.querySelector(".product-row")) {
        return;
    }

    // ========================================================
    // ELEMENTS
    // ========================================================

    const subtotalElement = document.getElementById("subtotal");

    const discountElement = document.getElementById("discount");

    const grandTotalElement = document.getElementById("grandTotal");

    // ========================================================
    // CURRENCY
    // ========================================================

    function formatCurrency(amount) {
        return "৳" + Math.round(amount);
    }

    // ========================================================
    // GET PRODUCT DISCOUNT PER QUANTITY
    // ========================================================

    function getDiscountPerQuantity(row) {
        const regularPrice = Number(row.dataset.price) || 0;

        const discountType = row.dataset.discountType || "none";

        const discountValue = Number(row.dataset.discountValue) || 0;

        // ====================================================
        // FIXED
        // ====================================================

        if (discountType === "fixed" && discountValue > 0) {
            return discountValue;
        }

        // ====================================================
        // PERCENT
        // ====================================================

        if (discountType === "percent" && discountValue > 0) {
            return (regularPrice * discountValue) / 100;
        }

        // ====================================================
        // NO DISCOUNT
        // ====================================================

        return 0;
    }

    // ========================================================
    // CALCULATE CART
    // ========================================================

    function calculateCart() {
        let subtotal = 0;

        let totalDiscount = 0;

        // ====================================================
        // LOOP PRODUCTS
        // ====================================================

        document.querySelectorAll(".product-row").forEach(function (row) {
            // ============================================
            // REGULAR PRICE
            // ============================================

            const regularPrice = Number(row.dataset.price) || 0;

            // ============================================
            // SELLING PRICE
            // ============================================

            const sellingPrice = Number(row.dataset.sellingPrice) || 0;

            // ============================================
            // DISCOUNT TYPE
            // ============================================

            const discountType = row.dataset.discountType || "none";

            // ============================================
            // DISCOUNT VALUE
            // ============================================

            const discountValue = Number(row.dataset.discountValue) || 0;

            // ============================================
            // QUANTITY
            // ============================================

            const quantityElement = row.querySelector(".quantity");

            if (!quantityElement) {
                return;
            }

            const quantity = Number(quantityElement.textContent) || 1;

            // ============================================
            // SUBTOTAL
            //
            // regular_price × quantity
            // ============================================

            const productSubtotal = regularPrice * quantity;

            // ============================================
            // DISCOUNT
            // ============================================

            let productDiscount = 0;

            // ============================================
            // FIXED DISCOUNT
            // ============================================

            if (discountType === "fixed" && discountValue > 0) {
                productDiscount = discountValue * quantity;
            }

            // ============================================
            // PERCENT DISCOUNT
            // ============================================
            else if (discountType === "percent" && discountValue > 0) {
                const discountPerQuantity =
                    (regularPrice * discountValue) / 100;

                productDiscount = discountPerQuantity * quantity;
            }

            // ============================================
            // ADD SUBTOTAL
            // ============================================

            subtotal += productSubtotal;

            // ============================================
            // ADD DISCOUNT
            // ============================================

            totalDiscount += productDiscount;

            // ============================================
            // PRODUCT TOTAL
            //
            // selling_price × quantity
            //
            // কারণ selling_price already discounted.
            // ============================================

            const productTotal = sellingPrice * quantity;

            // ============================================
            // UPDATE PRODUCT TOTAL
            // ============================================

            const productTotalElement = row.querySelector(".product-total");

            if (productTotalElement) {
                productTotalElement.textContent = formatCurrency(productTotal);
            }
        });

        // ====================================================
        // GRAND TOTAL
        // ====================================================

        const grandTotal = subtotal - totalDiscount;

        // ====================================================
        // UPDATE SUBTOTAL
        // ====================================================

        if (subtotalElement) {
            subtotalElement.textContent = formatCurrency(subtotal);
        }

        // ====================================================
        // UPDATE DISCOUNT
        // ====================================================

        if (discountElement) {
            discountElement.textContent = formatCurrency(totalDiscount);
        }

        // ====================================================
        // UPDATE GRAND TOTAL
        // ====================================================

        if (grandTotalElement) {
            grandTotalElement.textContent = formatCurrency(
                Math.max(grandTotal, 0),
            );
        }
    }

    // ========================================================
    // QUANTITY UP / DOWN
    // ========================================================

    document.addEventListener("click", function (event) {
        const quantityButton = event.target.closest(
            ".quantity_up, .quantity_down",
        );

        if (!quantityButton) {
            return;
        }

        // ================================================
        // FIND PRODUCT ROW
        // ================================================

        const row = quantityButton.closest(".product-row");

        if (!row) {
            return;
        }

        // ================================================
        // QUANTITY ELEMENT
        // ================================================

        const quantityElement = row.querySelector(".quantity");

        if (!quantityElement) {
            return;
        }

        // ================================================
        // CURRENT QUANTITY
        // ================================================

        let quantity = Number(quantityElement.textContent) || 1;

        // ================================================
        // DISCOUNT PER QUANTITY
        // ================================================

        const discountPerQuantity = getDiscountPerQuantity(row);

        // ================================================
        // QUANTITY UP
        // ================================================

        if (quantityButton.classList.contains("quantity_up")) {
            // Quantity + 1

            quantity += 1;

            quantityElement.textContent = quantity;

            // Automatically:
            //
            // product_quantity + 1
            // discount + discountPerQuantity
            // subtotal update
            // grand total update

            calculateCart();

            return;
        }

        // ================================================
        // QUANTITY DOWN
        // ================================================

        if (quantityButton.classList.contains("quantity_down")) {
            // Minimum quantity = 1

            if (quantity <= 1) {
                return;
            }

            // Quantity - 1

            quantity -= 1;

            quantityElement.textContent = quantity;

            // Automatically:
            //
            // product_quantity - 1
            // discount - discountPerQuantity
            // subtotal update
            // grand total update

            calculateCart();
        }
    });

    // ========================================================
    // REMOVE PRODUCT
    // ========================================================

    document.addEventListener("click", function (event) {
        const removeButton = event.target.closest(".remove-btn");

        if (!removeButton) {
            return;
        }

        const row = removeButton.closest(".product-row");

        if (!row) {
            return;
        }

        // Remove product

        row.remove();

        // Recalculate

        calculateCart();
    });

    /* =====================================================
           APPLY COUPON
        ===================================================== */

    const couponButton = document.getElementById("applyCoupon");

    if (couponButton) {
        couponButton.addEventListener("click", function () {
            const couponInput = document.getElementById("couponCode");

            const coupon = couponInput.value.trim().toUpperCase();

            if (coupon === "SAVE10") {
                alert("Coupon applied successfully!");
            } else if (coupon === "") {
                alert("Please enter coupon code.");
            } else {
                alert("Invalid coupon code.");
            }
        });
    }

    /* =====================================================
           INITIAL CALCULATION
        ===================================================== */

    calculateCart();
});
