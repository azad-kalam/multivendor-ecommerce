<script>
    $(document).ready(function() {
        // category ajax pagination start here
        $(document).on('click', '#categoryPagination a', function(e) {
            e.preventDefault();

            var href = $(this).attr('href');
            var link_seperate_byPage = href.split('page=');
            var value_after_page = link_seperate_byPage[1];

            $.ajax({
                type: "GET",
                url: "category/pagination?page=" + value_after_page,
                success: function(response) {
                    $('.category_table_container').html(response);
                    window.history.pushState(null, null, '?page=' + value_after_page);
                },
                error: function(err) {
                    customErrorHandler(err);
                }
            });
        });
        // category ajax pagination end here

        // subcategory ajax pagination start here
        $(document).on('click', '#subcategory-pagination a', function(e) {
            e.preventDefault();
            let subcategoryPageNumber;

            var href = $(this).attr('href');

            if (href && href.includes('page=')) {
                subcategoryPageNumber = href.split('page=')[1].split('&')[0];
            } else {
                subcategoryPageNumber = 1;
            }

            loadSubcategories(subcategoryPageNumber);
        });

        function loadSubcategories(subcategoryPageNumber) {
            $.ajax({
                type: "GET",
                url: "subcategory/pagination?page=" + subcategoryPageNumber,
                success: function(response) {
                    if (response.subCategoryPaginationStatus === 'success') {
                        $('.subcategory_table_container').html(response.html);
                        window.history.pushState(null, null, '?page=' +
                            subcategoryPageNumber); //display current URL with page number
                    } else {
                        toastr.error('Pagination Failed');
                    }
                },
                error: function(err) {
                    customErrorHandler(err);
                }
            });
        }
        // subcategory ajax pagination end here

    });
</script>
