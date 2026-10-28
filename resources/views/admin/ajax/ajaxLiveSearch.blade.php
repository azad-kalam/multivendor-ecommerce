<script>
    $(document).ready(function() {
        const searchConfig = {
            '#registersearch': {
                url: @json(route('admin.all_register_info.search')),
                key: 'registersearch',
                status: 'registerSearchStatus',
                property: 'registerSearchProperty',
                container: '.register_table_container'
            },

            '#admin_search': {
                url: @json(route('admin.details.search')),
                key: 'admin_search',
                status: 'adminSearchStatus',
                property: 'adminSearchProperty',
                container: '.admin_table_container'
            },

            '#vendor_search': {
                url: @json(route('admin.all_vendor.search')),
                key: 'vendor_search',
                status: 'vendorSearchStatus',
                property: 'vendorSearchProperty',
                container: '.vendor_table_container'
            },

            '#user_search': {
                url: @json(route('admin.all_user.search')),
                key: 'user_search',
                status: 'userSearchStatus',
                property: 'userSearchProperty',
                container: '.user_table_container',
            },

            '#categorySearchField': {
                url: @json(route('admin.categories.search')),
                key: 'categorysearch',
                status: 'categorySearchStatus',
                property: 'categorySearchProperty',
                container: '.category_table_container'
            },

            '#subCategorySearchField': {
                url: @json(route('admin.sub_categories.search')),
                key: 'subCategorysearch',
                status: 'subCategorySearchStatus',
                property: 'subCategorySearchProperty',
                container: '.subcategory_table_container'
            },

            '#productsearch': {
                url: @json(route('admin.products.search')),
                key: 'product_search',
                status: 'productSearchStatus',
                property: 'productSearchProperty',
                container: '.product_table_container',
            },

            '#banner_search': {
                url: @json(route('admin.banners.search')),
                key: 'banner_search',
                status: 'bannerSearchStatus',
                property: 'bannerSearchProperty',
                container: '.banner_table_container',
            },

            '#brandsearch': {
                url: @json(route('admin.brands.search')),
                key: 'brand_search',
                status: 'brandSearchStatus',
                property: 'brandSearchProperty',
                container: '.brand_table_container',
            },

            '#colorSearch': {
                url: @json(route('admin.colors.search')),
                key: 'color_search',
                status: 'colorSearchStatus',
                property: 'colorSearchProperty',
                container: '.color_table_container',
            },

            '#couponSearch': {
                url: @json(route('admin.coupons.search')),
                key: 'coupon_search',
                status: 'couponSearchStatus',
                property: 'couponSearchProperty',
                container: '.coupon_table_container',
            },

            '#product_model_search': {
                url: @json(route('admin.product_models.search')),
                key: 'product_model_search_query',
                status: 'product_model_search_status',
                property: 'product_model_search_property',
                container: '.productModel_table_container',
            },

            '#sizeSearch': {
                url: @json(route('admin.sizes.search')),
                key: 'size_search',
                status: 'sizeSearchStatus',
                property: 'sizeSearchProperty',
                container: '.size_table_container',
            }
            //----------------
            '#couponSearch': {
                url: @json(route('admin.coupons.search')),
                key: 'coupon_search',
                status: 'couponSearchStatus',
                property: 'couponSearchProperty',
                container: '.coupon_table_container',
            }
            '#checkoutSearch': {
                url: @json(route('admin.checkoutSearch.search')),
                key: 'checkout_search',
                status: 'checkoutSearchStatus',
                property: 'checkoutSearchProperty',
                container: '.checkout_table_container',
            }
            '#sheepingSearch': {
                url: @json(route('admin.sheepingSearch.search')),
                key: 'sheepingSearch',
                status: 'sheepingSearchStatus',
                property: 'sheepingSearchProperty',
                container: '.sheepingSearch_table_container',
            }
            '#priceSearch': {
                url: @json(route('admin.priceSearch.search')),
                key: 'priceSearch',
                status: 'priceSearchStatus',
                property: 'priceSearchProperty',
                container: '.priceSearch_table_container',
            }
            //----------------
        };

        function performSearch(input) {
            //input field য়ের attribute যার নাম id সেই id য়ের name find করা যেমন colorSearch
            const field_name = input.attr('id');

            //#colorSearch
            const full_field_name = '#' + field_name;

            //searchConfig variable য়ের #colorSearch য়ের মধ্যে যা-যা আছে তা সব find করা যেমন url, key, status.....
            const find_search_config_data = searchConfig[full_field_name];

            if (!find_search_config_data) return;

            const query = input.val().trim();
            const url = find_search_config_data.url;

            if (query === '') {
                toastr.info('Search query is empty!');
                if (find_search_config_data.stopWhenEmpty) return;
            }

            if (!url) {
                toastr.error('Search URL not found!');
                return;
            }

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',

                data: {
                    [find_search_config_data.key]: query
                },

                success: function(response) {
                    if (response[find_search_config_data.status] === 'success') {
                        $(find_search_config_data.container).html(
                            response[find_search_config_data.property]
                        );
                    } else {
                        toastr.warning('Failed to fetch data.');
                    }
                },
                error: function(xhr) {
                    customErrorHandler(xhr);
                }
            });
        }


        // All Search Inputs
        const selectors = Object.keys(searchConfig).join(', ');
        $(document).on('input', selectors, function() {
            performSearch($(this));
        });

    });
</script>
