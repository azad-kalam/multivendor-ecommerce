{{-- <script>
    $(document).ready(function() {
        @include('partials.toastr_options.toastr_option')
        @include('partials.error_options.errorHandler')

        $('#category_id').on('change', function() {
            const categoryID = $(this).val();
            const subcategoryDropdown = $('#subcategory_id');
            const oldSubID = "{{ old('subcategory_id') ?? '' }}";

            subcategoryDropdown.empty().append('<option> Loading... </option>').prop('disabled', true);

            if (!categoryID) {
                toastr.warning("Please select a category.");
                subcategoryDropdown.empty().append(
                    '<option disabled selected>Select a category first</option>');
                return;
            }

            $.ajax({
                method: "GET",
                url: "{{ route('admin.products.CRUD.dependentCategoryID', 'id') }}".replace(
                    'id',
                    categoryID),
                dataType: 'json',
                success: function(response) {
                    subcategoryDropdown.empty();
                    if (response.categoryDependentIDStatus === 'success') {
                        subcategoryDropdown.append(
                            '<option disabled selected hidden> Select a sub-category </option>'
                        );

                        $.each(response.subcategories, function(index, sub) {
                            const selected = sub.id == oldSubID ? 'selected' : '';
                            subcategoryDropdown.append(
                                `<option value="${sub.id}" ${selected}> ${sub.subcategory_name} </option>`
                            );
                        });

                        subcategoryDropdown.prop('disabled', false);

                    } else if (response.categoryDependentIDStatus === 'empty') {
                        toastr.warning(response.message || "No subcategories found.");
                        subcategoryDropdown.append(
                            '<option disabled selected class="text-danger"> No sub-categories available </option>'
                        ).prop('disabled', true);
                    } else {
                        toastr.error("Unexpected server response.");
                        subcategoryDropdown.prop('disabled', true);
                    }
                },
                error: function(error) {
                    customErrorHandler(error);
                }
            });
        });

    });
</script> --}}




<script>
    $(document).ready(function() {

        // @include('partials.toastr_options.toastr_option')
        // @include('partials.error_options.errorHandler')

        // subcategory dependency start here
        $('#category_id').on('change', function() {

            let categoryID = $(this).val();
            let subcategoryDropdown = $('#subcategory_id');

            let url = "{{ route('admin.products.CRUD.dependentCategoryID', ':id') }}";
            url = url.replace(':id', categoryID);

            if (!categoryID) {
                toastr.warning("Please select a category.");
                return;
            }

            $.ajax({
                method: "GET",
                url: url,
                dataType: "json",

                beforeSend: function() {
                    subcategoryDropdown.html('<option>Loading...</option>');
                },

                success: function(response) {
                    subcategoryDropdown.empty();

                    $.each(response, function(index, subcategories_data) {
                        subcategoryDropdown.append(
                            `<option value="${subcategories_data.id}">${subcategories_data.subcategory_name}</option>`
                        );
                    });
                },

                error: function(error) {
                    customErrorHandler(error);
                }
            });

        });
        // subcategory dependency end here

        // product_model dependency start here
        $('#brand_id').on('change', function() {

            let brand_id = $(this).val();

            if (!brand_id) {
                toastr.warning("Please select a brand.");
                return;
            }

            $('#product_model_id').html('<option>Loading ...</option>');

            let url = "{{ route('admin.products.CRUD.product_model_dependency', ':id') }}";
            url = url.replace(':id', brand_id);

            $.ajax({
                method: "GET",
                url: url,
                dataType: "json",

                success: function(data) {

                    $('#product_model_id').html(
                        '<option disabled hidden selected>Select model item</option>');

                    $.each(data, function(key, model) {
                        $('#product_model_id').append(
                            `<option value="${model.id}">${model.name}</option>`
                        );
                    });

                },
                error: function(error) {
                    customErrorHandler(error);
                }
            });

        });
        // product_model dependency end here



    });
</script>
