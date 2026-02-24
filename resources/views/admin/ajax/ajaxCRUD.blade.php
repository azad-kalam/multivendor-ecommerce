<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // Global Toastr JS start here
    $(document).ready(function() {
        // custom toastr option + error option start here
        @include('partials.toastr_options.toastr_option')
        @include('partials.error_options.errorHandler')
        // custom toastr option + error option end here

        // ↓ ....................................................................
        // category slug generate start here
        $('#name').on('input', function() {
            var thisCategoryName = $(this).val().trim().toLowerCase()
                .replace(/[^\w\s-]/g, '') // Remove special characters
                .replace(/\s+/g, '-') // Replace multiple spaces with a single hyphen
                .replace(/-+/g, '-'); // Replace multiple hyphens with a single hyphen
            $('#slug').val(thisCategoryName);
        });
        // category slug generate end here

        // Category Create start here
        $(document).on('submit', '#categoryForm', function(e) {
            e.preventDefault();
            var categoryName = $('#name').val().trim().replace(/\s+/g, ' ');
            var categoryTitle = $('#title').val().toLowerCase().trim().replace(/\s+/g, ' ');
            var categoryDescription = $('#description').val().toLowerCase().trim().replace(/\s+/g, ' ');
            var categoryStatus = $('#status').val().trim();
            var categorySlug = $('#slug').val().trim().toLowerCase()
                .replace(/[^\w\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
            var myData = {
                name: categoryName,
                title: categoryTitle,
                description: categoryDescription,
                status: categoryStatus,
                slug: categorySlug,
            };
            $.ajax({
                url: "{{ route('admin.categories.CRUD.store') }}",
                method: "POST",
                data: myData,
                dataType: 'json',
                success: function(res) {
                    if (res.categoryCreateStatus === 'success') {
                        $('#admin_createCategory_modal').modal('hide');
                        $('#categoryForm')[0].reset();

                        if (res.redirectCategoryURL) {
                            var categoryURL = res.redirectCategoryURL;
                            var LastpaginationNumber = res.CategoryLastPagination;
                            var lastPageUrl = categoryURL +
                                '?page=' + LastpaginationNumber;

                            window.history.pushState(null, null, lastPageUrl);
                            $('.category_table_container').load(lastPageUrl +
                                ' .category_table_container');
                            toastr.success('Category created successfully !');
                        } else {
                            toastr.error('Redirect URL missing in response.');
                        }
                    }
                },
                error: function(err) {
                    customErrorHandler(err);
                }
            });
        });

        // Category Create end here

        // Category show start here
        $(document).on('click', '.showIcon', function(e) {
            e.preventDefault();
            var categoryFindID = $(this).data('id');
            if (!categoryFindID) {
                toastr.error('Data not found !', 'Error');
                return;
            }
            $.ajax({
                url: "{{ route('admin.categories.CRUD.show', 'id') }}".replace('id',
                    categoryFindID),
                method: "GET",
                success: function(response) {
                    if (response.categoryShowStatus === 'success') {
                        $('#showModal').modal('show');
                        var responseSuccess = response.categoryDetails;
                        $('#catShowName').text(responseSuccess.name);
                        $('#catShowTitle').text(responseSuccess.title);
                        $('#catShowDescription').text(responseSuccess.description);
                        $('#catShowSlug').text(responseSuccess.slug);
                        if (responseSuccess.status == 'active') {
                            $('#catShowStatus').html(
                                '<span class="btn btn-outline-info text-success fw-bolder ms-1">Active</span>'
                            );
                        } else {
                            $('#catShowStatus').html(
                                '<span class="btn btn-outline-info text-danger fw-bolder ms-1">Inactive</span>'
                            );
                        }
                    }
                },
                error: function(err) {
                    customErrorHandler(err);
                }
            });
        });
        // Category show end here

        // category edit slug start here
        $('#catEditName').on('input', function() {
            var thisCatEditName = $(this).val().trim().toLowerCase()
                .replace(/[^\w\s-]/g, '') // Remove special characters
                .replace(/\s+/g, '-') // Replace multiple spaces with a single hyphen
                .replace(/-+/g, '-'); // Replace multiple hyphens with a single hyphen
            $('#catEditSlug').val(thisCatEditName);
        })
        // category edit slug end here

        // Category Edit start here
        $(document).on('click', '.editIcon', function(e) {
            e.preventDefault();
            var categoryFindEditID = $(this).data('id');
            if (!categoryFindEditID) {
                window.location.href = "{{ route('admin.categories.CRUD.index') }}";
                toastr.error("Data not found !", "Error");
                return;
            }
            $.ajax({
                method: "GET",
                url: "{{ route('admin.categories.CRUD.edit', 'id') }}".replace('id',
                    categoryFindEditID),
                success: function(response) {
                    if (response.categoryEditStatus === 'success') {
                        $('#categoryEditModal').modal('show');
                        $('#catEditId').val(response.categoryEditDetails.id);
                        $('#catEditName').val(response.categoryEditDetails.name);
                        $('#catEditTitle').val(response.categoryEditDetails.title);
                        $('#catEditDescription').val(response.categoryEditDetails
                            .description);
                        $('#catEditStatus').val(response.categoryEditDetails.status);
                        $('#catEditSlug').val(response.categoryEditDetails.slug);
                    }
                },
                error: function(err) {
                    customErrorHandler(err);
                }
            });
        });
        // Category Edit end here

        // Category update start here
        $(document).on('click', '#catUpdateBtn', function(e) {
            e.preventDefault();
            var findCategoryId = $('#catEditId').val();
            if (!findCategoryId) {
                toastr.error("Data not found !", "Error");
                return;
            }
            var categoryUpdateData = {
                name: $('#catEditName').val().trim().replace(/\s+/g, ' '),
                title: $('#catEditTitle').val().toLowerCase().trim().replace(/\s+/g, ' '),
                description: $('#catEditDescription').val().trim().replace(/\s+/g, ' ')
                    .toLowerCase(),
                status: $('#catEditStatus').val().trim(),
                slug: $('#catEditSlug').val().trim()
                    .replace(/[^\w\s-]/g, ' ')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-'),

            };

            Swal.fire({
                    title: `<h5 class="text-dark">Do you want to update this item ?</h5>`,
                    showCancelButton: true,
                    confirmButtonText: "Y e s",
                    reverseButtons: true,
                    customClass: {
                        popup: 'before_update_swal_popup',
                        confirmButton: 'btn btn-success px-3 ms-5',
                        cancelButton: 'btn btn-danger px-2 me-5',
                    },
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('admin.categories.CRUD.update', ':id') }}"
                                .replace(':id', findCategoryId),
                            method: "PUT",
                            data: categoryUpdateData,
                            dataType: 'json',
                            success: function(response) {
                                if (response.categoryUpdateStatus === 'success') {
                                    $('#categoryEditModal').modal('hide');
                                    $('#categoryUpdateForm')[0].reset();
                                    var CurrentPage = response.CategoryCurrentPage;
                                    window.history.pushState(null, null,
                                        '?page=' +
                                        CurrentPage);
                                    // Load the new table data with current page number
                                    $('#categoryTable').load(location.href +
                                        " #categoryTable");

                                    Swal.fire({
                                        title: `<h5 class="text-dark">Data updated successfully !</h5>`,
                                        icon: "success",
                                        timer: 1500,
                                        showConfirmButton: false,
                                        customClass: {
                                            popup: 'after_update_swal_popup',
                                            icon: 'small border border-2 border-danger',
                                        },
                                    });
                                }
                            },
                            error: function(err) {
                                customErrorHandler(err);
                            }
                        });

                    } else if (result.isDenied) {
                        Swal.fire({
                            title: "Update not saved",
                            icon: "info",
                        });
                    }
                });
        });
        // Category update end here

        // Category delete start here
        $(document).on('click', '.deletIcon', function(e) {
            e.preventDefault();
            var categoryFindDeleteID = $(this).data('id');
            if (!categoryFindDeleteID) {
                toastr.error("Data not found !", "Error");
                return;
            }
            Swal.fire({
                    title: `<h5 class="text-danger">Are you sure ?</h5>`,
                    text: "You want to delete this item !",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Y e s',
                    reverseButtons: true,
                    customClass: {
                        popup: 'before_delete_swal_popup',
                        icon: 'text-danger small',
                        confirmButton: 'btn btn-success px-3 ms-5',
                        cancelButton: 'btn btn-danger px-2 me-5',
                    },
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('admin.categories.CRUD.destroy', 'id') }}"
                                .replace('id', categoryFindDeleteID),
                            method: "DELETE",
                            success: function(res) {
                                if (res.categoryDeleteStatus === 'success') {
                                    $('#categoryTable').load(location.href +
                                        " #categoryTable");
                                    window.location.href = res.redirect;
                                    Swal.fire({
                                        title: `<h5 class="text-dark">Data deleted successfully !</h5>`,
                                        icon: "success",
                                        timer: 1500,
                                        showConfirmButton: false,
                                        customClass: {
                                            popup: 'after_delete_swal_popup',
                                            icon: 'small border border-2 border-danger',
                                        },
                                    });
                                }
                            },
                            error: function(err) {
                                customErrorHandler(err);
                            }
                        });
                    }
                });
        });
        // Category delete end here
        // ↑ ....................................................................

        // ↓ ....................................................................
        // sub-category slug generate start here
        $('#subcategory_name').on('input', function() {
            var thisSubCategoryName = $(this).val().trim().toLowerCase()
                .replace(/[^\w\s-]/g, '') // Remove special characters
                .replace(/\s+/g, '-') // Replace multiple spaces with a single hyphen
                .replace(/-+/g, '-'); // Replace multiple hyphens with a single hyphen
            $('#subcategory_slug').val(thisSubCategoryName);
        });
        // sub-category slug generate end here

        // Sub-category create start here
        $('#subCategoryForm').on('submit', function(e) {
            e.preventDefault();
            var category_id = $('#category_id').val().trim();
            var subcategory_name = $('#subcategory_name').val().trim().replace(/\s+/g, ' ');
            var subcategory_title = $('#subcategory_title').val().trim().replace(/\s+/g,
                ' ');
            var subcategory_description = $('#subcategory_description').val().trim()
                .replace(/\s+/g,
                    ' ');
            var subcategory_status = $('#subcategory_status').val().trim();
            var subcategory_slug = $('#subcategory_slug').val().trim().toLowerCase()
                .replace(/[^\w\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');

            var subCategoryData = {
                category_id: category_id,
                subcategory_name: subcategory_name,
                subcategory_title: subcategory_title,
                subcategory_description: subcategory_description,
                subcategory_status: subcategory_status,
                subcategory_slug: subcategory_slug,
            };

            $.ajax({
                url: "{{ route('admin.sub_categories.CRUD.store') }}",
                method: "POST",
                data: subCategoryData,
                dataType: 'json',
                success: function(response) {
                    if (response.subcategoryCreateStatus === 'success') {
                        $('#admin_createSubCategory_modal').modal('hide');
                        $('#subCategoryForm')[0].reset();

                        if (response.redirectSubcategoryURL) {
                            var subcategoryURL = response
                                .redirectSubcategoryURL;
                            var lastpaginationNumber = response
                                .SubCategoryLastPagination;
                            var pageUrl = subcategoryURL +
                                '?page=' +
                                lastpaginationNumber;

                            window.history.pushState(null, null, pageUrl);
                            $('.subcategory_table_container').load(pageUrl +
                                ' .subcategory_table_container');

                            toastr.success(
                                'Sub-category created successfully !');
                        } else {
                            toastr.error('Redirect URL missing in response.');
                        }
                    }
                },
                error: function(err) {
                    var errorMessage;
                    if (err.responseJSON && err.responseJSON.message) {
                        errorMessage = err.responseJSON.message;
                    } else {
                        errorMessage = 'Something went wrong.';
                    }
                    toastr.error('AN ERROR OCCURRED: ' + errorMessage);
                }
            });
        });
        // Sub-category create end here

        // Sub-category show start here
        $(document).on('click', '.subCatShowIcon', function(e) {
            e.preventDefault();
            var subCategoryFindShowID = $(this).data('id');
            if (!subCategoryFindShowID) {
                toastr.error('Data not found !', 'Error');
                return;
            }
            $.ajax({
                url: "{{ route('admin.sub_categories.CRUD.show', 'id') }}".replace(
                    'id',
                    subCategoryFindShowID),
                method: "GET",
                dataType: 'json',
                success: function(response) {
                    if (response.subCategoryShowStatus === 'success') {
                        $('#admin_show_SubCategory_modal').modal('show');
                        $('#subCatShowCategory').text(response
                            .subCategoryDetails.category.name);

                        $('#subCatShowName').text(response.subCategoryDetails
                            .subcategory_name);

                        if (response.subCategoryDetails.subcategory_title ==
                            null) {
                            $('#subCatShowTitle').html(
                                '<span class="text-danger">Sorry Title Empty !</span>'
                            );
                        } else {
                            $('#subCatShowTitle').text(response
                                .subCategoryDetails
                                .subcategory_title);
                        }

                        if (response.subCategoryDetails
                            .subcategory_description == null) {
                            $('#subCatShowDescription').html(
                                '<span class="text-danger">Sorry Description Empty !</span>'
                            );
                        } else {
                            $('#subCatShowDescription').text(response
                                .subCategoryDetails
                                .subcategory_description);
                        }

                        $('#subCatShowSlug').text(response.subCategoryDetails
                            .subcategory_slug);
                        if (response.subCategoryDetails.subcategory_status ==
                            'active') {
                            $('#subCatShowStatus').html(
                                '<span class="btn btn-outline-info text-success fw-bolder ms-1">Active</span>'
                            );
                        } else {
                            $('#subCatShowStatus').html(
                                '<span class="btn btn-outline-info text-danger fw-bold ms-1">Inactive</span>'
                            );
                        }
                    }
                },
                error: function(err) {
                    customErrorHandler(err);
                }
            });
        });
        // Sub-category show end here

        // sub-category auto-generate slug start here
        $('#subCategoryEditName').on('input', function() {
            var slug = $(this).val().trim().toLowerCase()
                .replace(/[^\w\s-]/g, '') // Remove special characters
                .replace(/\s+/g, '-') // Replace spaces with hyphens
                .replace(/-+/g, '-'); // Remove multiple hyphens
            $('#subCategoryEditSlug').val(slug);
        });
        // sub-category auto generate slug end here

        // sub-category Edit start here
        $(document).on('click', '.subCatEditIcon', function(e) {
            e.preventDefault();
            var subCategoryFindEditID = $(this).data('id');

            if (!subCategoryFindEditID) {
                window.location.href = "{{ route('admin.sub_categories.CRUD.index') }}";
                $('#admin_edit_SubCategory_modal').modal('hide');
                toastr.error("Data not found !", "Error");
                return;
            }

            $.ajax({
                url: "{{ route('admin.sub_categories.CRUD.edit', ':ID') }}".replace(
                    ':ID',
                    subCategoryFindEditID),
                method: "GET",
                dataType: 'json',
                success: function(response) {
                    if (response.subCategoryEditStatus === 'success') {
                        $('#admin_edit_SubCategory_modal').modal('show');
                        $('#subCategoryEditId').val(response.subCategoryDetails
                            .id);

                        // Remove duplicate categories and sort
                        if (response.categories && response.categories.length >
                            0) {
                            var findCategoryID = response.subCategoryDetails
                                .category_id;

                            var uniqueCategories = response.categories.reduce((
                                acc,
                                category) => {
                                if (!acc.find(cat => cat.id === category
                                        .id)) {
                                    acc.push(category);
                                }
                                return acc;
                            }, []);

                            uniqueCategories.sort((a, b) => a.name
                                .localeCompare(b.name));

                            $('#categoryEditName').empty().append(
                                '<option value="" disabled>Select a category</option>'
                            );

                            uniqueCategories.forEach(function(category) {
                                var selected = (findCategoryID ===
                                        category.id) ?
                                    'selected class="bg-success text-white"' :
                                    '';
                                $('#categoryEditName').append(
                                    `<option value="${category.id}" ${selected}>${category.name}</option>`
                                );
                            });
                        } else {
                            $('#categoryEditName').empty().append(
                                '<option value="" disabled>No categories available</option>'
                            );
                        }

                        // Populate sub-category fields
                        $('#subCategoryEditName').val(response
                            .subCategoryDetails
                            .subcategory_name);
                        $('#subCategoryEditTitle').val(response
                            .subCategoryDetails
                            .subcategory_title);
                        $('#subCategoryEditDescription').val(response
                            .subCategoryDetails
                            .subcategory_description);
                        $('#subCategoryEditStatus').val(response
                            .subCategoryDetails
                            .subcategory_status);
                        $('#subCategoryEditSlug').val(response
                            .subCategoryDetails
                            .subcategory_slug);
                    } else {
                        toastr.error("Failed to load sub-category data.");
                    }
                },
                error: function(err) {
                    customErrorHandler(err);
                }
            });
        });
        // Sub-category Edit end here

        // Sub-category Update start here
        $(document).on("click", "#subCategoryUpdateBtn", function(e) {
            e.preventDefault();
            var subCategoryUpdateID = $("#subCategoryEditId").val();
            if (!subCategoryUpdateID) {
                toastr.error("Data not found !", "Error");
                return;
            }
            var subcategoryUpdateData = {
                category_id: $("#categoryEditName").val().trim(),
                subcategory_name: $("#subCategoryEditName").val().trim().replace(/\s+/g,
                    ' '),
                subcategory_title: $("#subCategoryEditTitle").val().trim().replace(
                    /\s+/g, ' '),
                subcategory_description: $("#subCategoryEditDescription").val().trim()
                    .toLowerCase()
                    .replace(/\s+/g, ' '),
                subcategory_status: $("#subCategoryEditStatus").val().trim(),
                subcategory_slug: $("#subCategoryEditSlug").val().trim(),
                _token: $('meta[name="csrf-token"]').attr("content"),
                _method: "PUT",
            };
            Swal.fire({
                    title: `<h5 class="text-dark">Do you want to update this item ?</h5>`,
                    showCancelButton: true,
                    confirmButtonText: "Y e s",
                    reverseButtons: true,
                    customClass: {
                        popup: 'before_update_swal_popup',
                        confirmButton: 'btn btn-success px-3 ms-5',
                        cancelButton: 'btn btn-danger px-2 me-5',
                    },
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `{{ route('admin.sub_categories.CRUD.update', ':ID') }}`
                                .replace(":ID", subCategoryUpdateID),
                            method: "POST",
                            data: subcategoryUpdateData,
                            dataType: "json",
                            success: function(response) {
                                if (response.subcategoryUpdateStatus ===
                                    "success") {
                                    $("#admin_edit_SubCategory_modal")
                                        .modal("hide");
                                    $("#subCategoryForm")[0].reset();
                                    $("#subCategoryTable").load(location
                                        .href +
                                        " #subCategoryTable");
                                    history.pushState(null, "", response
                                        .redirect);

                                    Swal.fire({
                                        title: `<h5 class="text-dark">Data updated successfully !</h5>`,
                                        icon: "success",
                                        timer: 2000,
                                        showConfirmButton: false,
                                        customClass: {
                                            popup: 'after_update_swal_popup',
                                            icon: 'small border border-2 border-danger',
                                        },
                                    });
                                }
                            },
                            error: function(err) {
                                customErrorHandler(err);
                            },
                        });
                    } else if (result.isDenied) {
                        Swal.fire({
                            title: "Update not saved",
                            icon: "info",
                        });
                    }
                });
        });
        // Sub-category Update end here

        // Sub-category delete start here
        $(document).on('click', '.subCatDeleteIcon', function(e) {
            e.preventDefault();
            var subCategoryFindDeleteID = $(this).data('id');
            if (!subCategoryFindDeleteID) {
                window.location.href = "{{ route('admin.sub_categories.CRUD.index') }}";
                toastr.error('Data not found !', 'Error');
                return;
            }
            Swal.fire({
                    title: `<h5 class="text-danger">Are you sure ?</h5>`,
                    text: "You want to delete this item !!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Y e s',
                    reverseButtons: true,
                    customClass: {
                        popup: 'before_delete_swal_popup',
                        icon: 'text-danger small',
                        confirmButton: 'btn btn-success px-3 ms-5',
                        cancelButton: 'btn btn-danger px-2 me-5',
                    },
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('admin.sub_categories.CRUD.destroy', 'id') }}"
                                .replace(
                                    'id', subCategoryFindDeleteID),
                            method: "DELETE",
                            success: function(res) {
                                if (res.subcategoryDeleteStatus ===
                                    'success') {
                                    $('#subCategoryTable').load(location
                                        .href +
                                        " #subCategoryTable");

                                    Swal.fire({
                                        title: `<h5 class="text-dark">Data deleted successfully !</h5>`,
                                        icon: "success",
                                        timer: 2000,
                                        showConfirmButton: false,
                                        customClass: {
                                            popup: 'after_delete_swal_popup',
                                            icon: 'small border border-2 border-danger',
                                        },
                                    });
                                }
                            },
                            error: function(err) {
                                customErrorHandler(err);
                            }
                        });
                    }
                });
        });
        // Sub-category delete end here
        // ↑ ....................................................................
        // Admin Sub-category CRUD end here
    });
</script>
