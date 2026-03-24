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
            productSlug.value = slug + '-' + randomStr;
        });
        // end slug generate

        // start discount_type here
        const radios = document.querySelectorAll('input[name="discount_type"]');
        const discountInput = document.getElementById('discount_value');

        function toggleDiscountField() {
            const selected = document.querySelector('input[name="discount_type"]:checked');
            if (selected && selected.value === 'none') {
                discountInput.disabled = true; // Disable
                discountInput.required = false; // Remove required
                discountInput.value = ""; // Clear value
            } else {
                discountInput.disabled = false; // Enable
                discountInput.required = true; // Make required
            }
        }

        // Page load এ কাজ করবে
        toggleDiscountField();

        // Radio change হলে কাজ করবে
        radios.forEach(function(radio) {
            radio.addEventListener("change", toggleDiscountField);
        });
        // end discount_type here
    });
</script>
