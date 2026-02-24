<script>
    $('#productsearch').on('keyup', function(e) {
        e.preventDefault();
        let search_query = $(this).val().trim();
        if (search_query === "") {
            toastr.info('Search Query Is Empty!');
        }

        const url = "{{ route('vendor.products.search') }}";

        $.ajax({
            type: "GET",
            url: url,
            data: {
                search_data: search_query
            },
            success: function(response) {
                if (response.productSearchStatus === 'success') {
                    $('.product_table_container').html(response.productSearchProperty);
                }
                 else {
                $('.product_table_container').html('<tr><td colspan="5">No products found</td></tr>');
            }
            },
            error: function(err) {
                console.error(err);
            }
        });
    });
</script>
