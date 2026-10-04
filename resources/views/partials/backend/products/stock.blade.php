<script>
    document.addEventListener('DOMContentLoaded', function() {

        const stockQuantity = document.querySelector('.stock_quantity');
        const stockStatus = document.querySelector('.stock_status');

        if (!stockQuantity || !stockStatus) return;

        function updateStockStatus() {
            let quantity = parseInt(stockQuantity.value) || 0;

            stockStatus.value =
                quantity > 0 ?
                'in_stock' :
                'out_of_stock';
        }


        updateStockStatus();

        stockQuantity.addEventListener(
            'input',
            updateStockStatus
        );
    });
</script>
