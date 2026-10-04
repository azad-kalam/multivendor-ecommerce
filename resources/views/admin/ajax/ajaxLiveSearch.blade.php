<script>
    $(document).ready(function() {
        // custom toastr option + error option start here
        // @include('partials.toastr_options.toastr_option')
        // @include('partials.error_options.errorHandler')
        // custom toastr option + error option end here

        // Register live search start here
        const registerSearchUrl = "{{ route('admin.all_register_info.search') }}";
        $('#registersearch').on('keyup', function(e) {
            e.preventDefault();
            var registersearch_val = $(this).val().trim();
            if (registersearch_val === "") {
                toastr.info("Search Query Is Empty !");
            }

            $.ajax({
                url: registerSearchUrl,
                type: "GET",
                data: {
                    // filled name : variable name
                    registersearch: registersearch_val
                },
                success: function(response) {
                    if (response.registerSearchStatus === "success") {
                        $(".register_table_container").html(response
                            .registerSearchProperty);
                    } else {
                        toastr.warning("Failed to fetch data.");
                    }
                },
                error: function(err) {
                    customErrorHandler(err);
                }
            });
        });
        // Register live search end here


        // admin live search start here
        // $('#admin_search').on('keyup', function(e) {
        //     e.preventDefault();
        //     var adminsearch_val = $(this).val().trim();

        //     if (adminsearch_val === "") {
        //         toastr.info('Search Query Is Empty !');
        //     }

        //     let url = "{{ route('admin.details.search') }}";

        //     $.ajax({
        //         type: "GET",
        //         url: url,
        //         data: {
        //             admin_search: adminsearch_val
        //         },
        //         success: function(response) {
        //             if (response.adminSearchStatus === 'success') {
        //                 $('.admin_table_container').html(response.adminSearchProperty);
        //             } else {
        //                 toastr.warning("Failed to fetch data.");
        //             }
        //         },
        //         error: function(err) {
        //             customErrorHandler(err);
        //         }
        //     });
        // });






        $('#admin_search').on('keyup', function() {
            let value = $(this).val().trim();
            if (value === "") {
                toastr.info('Search Query Is Empty !');
            }

            $.ajax({
                url: "{{ route('admin.details.search') }}",
                type: "GET",
                data: {
                    admin_search: value
                },
                success: function(response) {
                    if (response.adminSearchStatus === 'success') {
                        $('.admin_table_container').html(response.adminSearchProperty);
                    } else {
                        toastr.warning("Failed to fetch data.");
                    }
                },
                error: function(err) {
                    customErrorHandler(err);
                }
            });
        });
        // admin live search end here

        // vendor live search start here
        $(document).on('keyup', '#vendor_search', debounce(function() {
            let searchText = $('#vendor_search').val().trim();

            if (searchText === "") {
                toastr.info('Search Query Is Empty!');
            }

            $.ajax({
                url: "{{ route('admin.all_vendor.search') }}",
                method: "GET",
                data: {
                    vendor_search: searchText
                },
                success: function(res) {
                    if (res.vendorSearchStatus === 'success') {
                        $('.vendor_table_container').html(res.vendorSearchProperty);
                    } else {
                        toastr.warning("Failed to fetch data.");
                    }
                },
                error: function(err) {
                    customErrorHandler(err);
                }
            });
        }, 200)); // wait 2s before sending request

        function debounce(func, delay) {
            let timer;
            return function() {
                clearTimeout(timer); // cancel previous timer
                timer = setTimeout(func, delay); // run function after delay
            };
        }
        // vendor live search end here

        // user live search start here
        $(document).on('keyup', '#user_search', function() {
            let usersearch_val = $(this).val().trim();

            if (usersearch_val === "") {
                toastr.info('Search Query Is Empty!');
                return;
            }

            $.ajax({
                url: "{{ route('admin.all_user.search') }}",
                type: "GET",
                data: {
                    user_search: usersearch_val
                },
                success: function(response) {
                    if (response.userSearchStatus === 'success') {
                        $('.user_table_container').html(response.userSearchProperty);
                    } else {
                        toastr.warning("Failed to fetch data.");
                    }
                },
                error: function(err) {
                    customErrorHandler(err);
                }
            });
        });
        // user live search end here

        // category live search start here
        $(document).on('keyup', '#categorySearchField', function() {
            performCategorySearch();
        });

        $(document).on('click', '#categorySearchBtn', function(e) {
            e.preventDefault();
            performCategorySearch();
        });

        const url = "{{ route('admin.categories.search') }}";

        function performCategorySearch() {
            const categorysearch = $('#categorySearchField').val().trim();

            if (categorysearch === "") {
                toastr.info('Search Query Is Empty!');
                $('#categorySearchField').val('');

                loadAllCategories();

            } else {
                searchCategories(categorysearch);
            }
        }

        function loadAllCategories() {
            $.ajax({
                url: url,
                type: "GET",
                success: function(response) {
                    if (response.categorySearchStatus === 'success') {
                        $('.category_table_container').html(response
                            .categorySearchProperty);
                    } else {
                        toastr.warning("Failed to load categories.");
                    }
                },
                error: function(err) {
                    customErrorHandler(err);
                }
            });
        }

        function searchCategories(categorysearch) {
            $.ajax({
                url: url,
                type: "GET",
                data: {
                    categorysearch: categorysearch
                },
                success: function(response) {
                    if (response.categorySearchStatus === 'success') {
                        $('.category_table_container').html(response
                            .categorySearchProperty);
                    } else {
                        toastr.warning("No categories found.");
                    }
                },
                error: function(err) {
                    customErrorHandler(err);
                }
            });
        }
        // category live search end here

        // subcategory live search start here
        const subCategorySearchUrl = "{{ route('admin.sub_categories.search') }}";

        $(document).on('keyup', '#subCategorySearchField', function() {
            performSubcategorySearch();
        });

        $(document).on('click', '#subCategorySearchBtn', function(e) {
            e.preventDefault();
            performSubcategorySearch();
        });

        function performSubcategorySearch() {
            const query = $('#subCategorySearchField').val().trim();

            if (query === "") {
                toastr.info('Search Query Is Empty !');
                $('#subCategorySearchField').val('');
                empty_subcategory_data();

            } else {
                get_subcategory_data(query);
            }
        }

        function empty_subcategory_data() {
            $.ajax({
                url: subCategorySearchUrl,
                type: "GET",
                success: function(response) {
                    if (response.subCategorySearchStatus === 'success') {
                        $('.subcategory_table_container').html(response
                            .subCategorySearchProperty);
                    } else {
                        toastr.warning("Failed to fetch data.");
                    }
                },
                error: function(err) {
                    customErrorHandler(err);
                }
            });
        }

        function get_subcategory_data(query) {
            $.ajax({
                url: subCategorySearchUrl,
                type: "GET",
                data: {
                    subCategorysearch: query
                },
                success: function(response) {
                    if (response.subCategorySearchStatus === 'success') {
                        $('.subcategory_table_container').html(response
                            .subCategorySearchProperty);
                    } else {
                        toastr.warning("Failed to fetch data.");
                    }
                },
                error: function(err) {
                    customErrorHandler(err);
                }
            });
        }
        // subcategory live search end here

        // product live search start here
        // $(document).on('keyup', '#productsearch', function() {
        //     const url = "{{ route('admin.products.search') }}";

        //     var search_query = $(this).val();
        //     if (search_query === "") {
        //         toastr.info('Search Query Is Empty!');
        //         $('#productsearch').val('');
        //     }
        //     $.ajax({
        //         type: "GET",
        //         url: url,
        //         data: {
        //             product_search: search_query
        //         },

        //         success: function(response) {
        //             if (response.productSearchStatus === 'success') {
        //                 $('.product_table_container').html(response
        //                     .productSearchProperty);
        //             }
        //         },
        //         error: function(err) {
        //             customErrorHandler(err);
        //         }
        //     });
        // });




        $(document).on('keyup', '#productsearch', function() {

            let search_query = $(this).val();
            let url = $(this).data('search-url');

            if (search_query === "") {
                toastr.info('Search Query Is Empty!');
            }

            $.ajax({
                type: "GET",
                url: url,
                data: {
                    product_search: search_query
                },
                success: function(response) {
                    if (response.productSearchStatus === 'success') {
                        $('.product_table_container').html(
                            response.productSearchProperty
                        );
                    }
                },
                error: function(err) {
                    customErrorHandler(err);
                }
            });
        });
        // product live search end here

        // banner live search start here
        $(document).on('keyup', '#banner_search', function() {
            let search_query = $(this).val();
            let url = $(this).data('search-url');

            if (search_query === "") {
                toastr.info('Search Query Is Empty!');
            }

            $.ajax({
                type: "GET",
                url: url,
                data: {
                    banner_search: search_query
                },
                success: function(response) {
                    if (response.bannerSearchStatus === 'success') {
                        $('.banner_table_container').html(
                            response.bannerSearchProperty
                        );
                    }
                },
                error: function(err) {
                    customErrorHandler(err);
                }
            });
        });
        // banner live search end here

        // brand live search start here
        $(document).on('keyup', '#brandsearch', function() {
            let search_query = $(this).val();
            let url = $(this).data('search-url');

            if (search_query === "") {
                toastr.info('Search Query Is Empty!');
            }

            $.ajax({
                type: "GET",
                url: url,
                data: {
                    brand_search: search_query
                },
                success: function(response) {
                    if (response.brandSearchStatus === 'success') {
                        $('.brand_table_container').html(
                            response.brandSearchProperty
                        );
                    }
                },
                error: function(err) {
                    customErrorHandler(err);
                }
            });
        });
        // brand live search end here

        // color live search start here
        $(document).on('keyup', '#colorSearch', function() {
            let search_query = $(this).val();
            let url = $(this).data('search-url');

            if (search_query === "") {
                toastr.info('Search Query Is Empty!');
            }

            $.ajax({
                type: "GET",
                url: url,
                data: {
                    color_search: search_query
                },
                success: function(response) {
                    if (response.colorSearchStatus === 'success') {
                        $('.color_table_container').html(
                            response.colorSearchProperty
                        );
                    }
                },
                error: function(err) {
                    customErrorHandler(err);
                }
            });
        });
        // color live search end here

        // model live search start here
        $(document).on('keyup', '#product_model_search', function() {
            let search_query = $(this).val();
            let url = $(this).data('search-url');

            if (search_query === "") {
                toastr.info('Search Query Is Empty!');
            }

            $.ajax({
                type: "GET",
                url: url,
                data: {
                    product_model_search_query: search_query
                },
                success: function(response) {
                    if (response.product_model_search_status === 'success') {
                        $('.productModel_table_container').html(
                            response.product_model_search_property
                        );
                    }
                },
                error: function(err) {
                    customErrorHandler(err);
                }
            });
        });
        // model live search end here

        // size live search start here
        $(document).on('keyup', '#sizeSearch', function() {
            let search_query = $(this).val();
            let url = $(this).data('search-url');

            if (search_query === "") {
                toastr.info('Search Query Is Empty!');
            }

            $.ajax({
                type: "GET",
                url: url,
                data: {
                    size_search: search_query
                },
                success: function(response) {
                    if (response.sizeSearchStatus === 'success') {
                        $('.size_table_container').html(
                            response.sizeSearchProperty
                        );
                    }
                },
                error: function(err) {
                    customErrorHandler(err);
                }
            });
        });
        // size live search end here


    });
</script>
