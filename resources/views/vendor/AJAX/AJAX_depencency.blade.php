<script>
    $(document).ready(function() {

        @include('partials.toastr_options.toastr_option')
        @include('partials.error_options.errorHandler')

        $('#category_id').on('change', function() {

            let categoryID = $(this).val();
            let subcategoryDropdown = $('#subcategory_id');

            let url = "{{ route('vendor.products.dependent_Category', ':id') }}";
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
                    $.each(response, function(index, subcategory) {
                        subcategoryDropdown.append(
                            `<option value="${subcategory.id}">${subcategory.subcategory_name}</option>`
                        );
                    });
                },
                error: function(error) {
                    customErrorHandler(error);
                    toastr.error("There was a problem while loading the subcategories.");
                }
            });

        });

    });
</script>
