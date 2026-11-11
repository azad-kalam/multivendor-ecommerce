<script>
    $(document).ready(function() {
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
