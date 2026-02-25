$(document).ready(function () {
    $("#product-thumbnails").slick({
        vertical: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        asNavFor: "#product-main-img",
        infinite: true,
        focusOnSelect: true,
        arrows: true,
        prevArrow: `<button type="button" class="slick-prev"><i class="fa fa-arrow-up"></i></button>`,
        nextArrow: `<button type="button" class="slick-next"><i class="fa fa-arrow-down"></i></button>`,
    });

    $("#product-main-img").slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        dots: false,
        fade: true,
        speed: 300,
        asNavFor: "#product-thumbnails",
        prevArrow: `<button type="button" class="slick-prev"><i class="fa fa-arrow-up"></i></button>`,
        nextArrow: `<button type="button" class="slick-next"><i class="fa fa-arrow-down"></i></button>`,
    });

    function applyZoom() {
        $(".main-img").each(function () {
            var $img = $(this);
            $img.css("transform", "none");
            if ($img.parent(".zoom-wrapper").length) {
                var old = $img.parent();
                old.replaceWith($img);
            }

            $img.wrap(
                '<span class="zoom-wrapper" style="display:inline-block;"></span>'
            );

            $img.parent().zoom({
                magnify: 1.5,
            });
        });
    }

    applyZoom();

    $("#product-main-img").on("afterChange", function () {
        applyZoom();
    });


});