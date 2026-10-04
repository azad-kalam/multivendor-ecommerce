<script>
    // start slug generate
    document.addEventListener("DOMContentLoaded", function() {
        const productName = document.getElementById('product_name');
        const productSlug = document.getElementById('product_slug');

        productName.addEventListener('keyup', function() {
            let name = productName.value.trim();
            if (name == '') {
                productSlug.value = '';
                return;
            }

            let slug = name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
            let randomStr = Math.random().toString(36).substring(2, 13); // 11 char random
            // productSlug.value = slug + '-' + randomStr;
            productSlug.value = slug;
        });
        // end slug generate

        // discount type start here
        function toggleDiscountField() {
            document.querySelectorAll(".variation-block").forEach(function(block) {

                const discountType = block.querySelector('select[name="discount_type[]"]');
                const discountInput = block.querySelector('input[name="discount_value[]"]');

                if (!discountType || !discountInput) return;

                if (discountType.value === "none") {
                    // Do not use disabled
                    discountInput.readOnly = true;
                    discountInput.required = false;
                    discountInput.value = "";

                } else {
                    discountInput.readOnly = false;
                    discountInput.required = true;
                }
            });
        }

        // initial load
        toggleDiscountField();
        document.addEventListener("change", function(e) {

            if (e.target.matches('select[name="discount_type[]"]')) {
                toggleDiscountField();
            }
        });

        // discount type end here
    });
</script>
