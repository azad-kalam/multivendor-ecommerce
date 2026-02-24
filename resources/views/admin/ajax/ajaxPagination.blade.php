<script>
    $(document).ready(function() {
        // custom toastr option + error option start here
        @include('partials.toastr_options.toastr_option')
        @include('partials.error_options.errorHandler')
        // custom toastr option + error option end here

        // category ajax pagination start here
        $(document).on('click', '#categoryPagination a', function(e) {
            e.preventDefault();
            let categoryPageNumber;

            var href = $(this).attr('href');

            if (href && href.includes('page=')) {
                //only get page number and ignore other parameters
                categoryPageNumber = href.split('page=')[1].split('&')[0];
            } else {
                categoryPageNumber = 1;
            }

            loadCategories(categoryPageNumber);
        });

        function loadCategories(categoryPageNumber) {
            $.ajax({
                type: "GET",
                url: "category/pagination?page=" + categoryPageNumber,
                success: function(response) {
                    if (response.categoryPaginationStatus === "success") {
                        $('.category_table_container').html(response.categoriesPaginationProperty);
                        window.history.pushState(null, null, '?page=' +
                            categoryPageNumber); //display current URL with page number
                    } else {
                        toastr.error('Pagination Failed');
                    }
                },
                error: function(err) {
                    customErrorHandler(err);
                }
            });
        }
        // category ajax pagination end here

        // subcategory ajax pagination start here
        $(document).on('click', '#subcategory-pagination a', function(e) {
            e.preventDefault();
            let subcategoryPageNumber;

            var href = $(this).attr('href');

            if (href && href.includes('page=')) {
                //only get page number and ignore other parameters
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
