$(document).ready(function () {
    const $form = $("#add_to_cart");
    let variants = JSON.parse($form.attr("data-variants") || "[]");

    const productId = $("#productId");
    const variantId = $("#productVariantId");
    const sizeSelect = $("#sizeSelect");
    const colorSelect = $("#colorSelect");
    const quantityInput = $("#productQuantity");
    const availableQty = $("#availableQty");
    const productPrice = $(".product-price");
    const productBadge = $(".product-badge");
    const productAvailable = $(".product-available");

    if (
        !$("#productId").length ||
        !$("#productVariantId").length ||
        !$("#sizeSelect").length ||
        !$("#colorSelect").length ||
        !$("#productQuantity").length
    ) {
        return;
    }

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

    function updateProduct(variant) {
        variantId.val(variant.id);
        productId.val(variant.product_id);
        const regularPrice = Number(variant.regular_price).toFixed(2);
        const sellingPrice = Number(variant.selling_price).toFixed(2);
        if (variant.discount_type === "none") {
            productPrice.html(`
                <span class="text-dark fw-bold">
                    <i class="fa-solid fa-bangladeshi-taka-sign"></i>
                    ${regularPrice}
                </span>
            `);
            productBadge.html(`
                <span class="badge bg-danger"> NEW</span>
            `);
        } else if (variant.discount_type === "fixed") {
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
            productBadge.html(`
                <span class="badge bg-danger">OFFER</span>
            `);
        } else if (variant.discount_type === "percent") {
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
            productBadge.html(`
                <span class="badge bg-danger">${variant.discount_value}% OFF </span>
            `);
        } else {
            productPrice.html(`
                <span class="text-danger"> Price not available</span>
            `);
        }

        const stock = Number(variant.stock_quantity) || 0;
        const inStock =
            variant.stock_status === "in_stock" &&
            (Number(variant.manage_stock) !== 1 || stock > 0);
        productAvailable
            .removeClass("text-success text-danger")
            .addClass(inStock ? "text-success" : "text-danger")
            .text(inStock ? "In Stock" : "Out Of Stock");
        availableQty.text(stock);
        quantityInput.attr("max", stock);
        quantityInput.val(inStock ? 1 : 0);
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

    function resetProduct() {
        variantId.val("");
        productPrice.html(
            `<span class="text-danger">Price not available</span>`,
        );
        productBadge.html(`<span class="text-danger">No Offer </span> `);
        productAvailable
            .removeClass("text-success")
            .addClass("text-danger")
            .text("Out Of Stock");
        availableQty.text(0);
        quantityInput.attr("max", 0).val(0);
    }

    function updateSelectedVariant() {
        const variant = getSelectedVariant();
        if (variant) {
            updateProduct(variant);
        } else {
            resetProduct();
            toastr.warning("Size color combination no match");
        }
    }

    sizeSelect.on("change", updateSelectedVariant);
    colorSelect.on("change", updateSelectedVariant);

    $(".input-number .quantity_up").on("click", function (e) {
        e.preventDefault();
        const quantityInput = $(this).siblings(
            'input[name="product_quantity"]',
        );

        const quantity = Number(quantityInput.val());
        const max = Number(quantityInput.attr("max"));

        if (quantity < max) {
            quantityInput.val(quantity + 1);
        } else {
            toastr.warning(`Maximum quantity is available ${max}.`);
        }
    });

    $(".input-number .quantity_down").on("click", function (e) {
        e.preventDefault();
        const quantityInput = $(this).siblings(
            'input[name="product_quantity"]',
        );

        const quantity = Number(quantityInput.val());
        const min = Number(quantityInput.attr("min"));

        if (quantity > min) {
            quantityInput.val(quantity - 1);
        } else {
            toastr.warning(`Minimum quantity must be ${min}.`);
        }
    });

    const initialVariant = getSelectedVariant();
    if (initialVariant) {
        updateProduct(initialVariant);
    } else {
        resetProduct();
    }
});
