<script>
    $(document).ready(function() {
         // custom toastr option + error option start here
        @include('partials.toastr_options.toastr_option')
        @include('partials.error_options.errorHandler')
        // custom toastr option + error option end here


        // product category-depency start here
        $('#category_id').on('change', function() {
            const categoryID = $(this).val();
            const subcategoryDropdown = $('#subcategory_id');
            const oldSubID = "{{ old('subcategory_id') ?? '' }}";

            // Reset subcategory dropdown
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
        // product category-depency end here

    });
</script>
