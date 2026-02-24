<!--Modal starts here-->
<div class="modal fade" id="admin_createSubCategory_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel">
    
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-shadow custom_modal_dialog mx-auto">
        <div class="modal-content">
            <!-- AJAX content loads here -->
            <div class="modal-header bg-secondary">
                <button type="button" class="btn-close bg-danger btn-hover" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="text-center mt-1">
                <h1 class="modal-heading">Create New Sub-category</h1>
            </div>
            <div class="modal-body custom_modal_body">
                <form action="#" method="POST" id="subCategoryForm">
                    @csrf

                    <!-- Category Name -->
                    <div class="mb-4 mt-4">
                        <label for="category_id" class="form-label fw-bold">
                            Select Category Name: <span class="text-danger">*</span>
                        </label>
                        <select class="form-select required_field" id="category_id" name="category_id" required
                            aria-label="Category selection">
                            <option disabled selected hidden>Select any category</option>
                            @foreach ($allcategoryIdName as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Sub-category Name -->
                    <div class="mb-4">
                        <label for="subcategory_name" class="form-label fw-bold">
                            Sub-category Name: <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control required_field" id="subcategory_name" name="subcategory_name"
                            value="{{ old('subcategory_name') }}" required>
                        @error('subcategory_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Sub-category Title -->
                    <div class="mb-4">
                        <label for="subcategory_title" class="form-label fw-bold">Sub-category Title:</label>
                        <input type="text" class="form-control required_field" id="subcategory_title" name="subcategory_title"
                            value="{{ old('subcategory_title') }}">
                        @error('subcategory_title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Sub-category Description -->
                    <div class="mb-4">
                        <label for="subcategory_description" class="form-label fw-bold">Sub-category
                            Description:</label>
                        <textarea class="form-control required_field" id="subcategory_description" name="subcategory_description" rows="5" minlength="5"
                            maxlength="300" style="resize: none">{{ old('subcategory_description') }}</textarea>
                        @error('subcategory_description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Sub-category Status -->
                    <div class="mb-4">
                        <label for="subcategory_status" class="form-label fw-bold">
                            Sub-category Status: <span class="text-danger">*</span>
                        </label>
                        <select  class="form-select required_field" name="subcategory_status" id="subcategory_status" required>
                            <option value="" hidden>Select any one</option>
                            <option value="active">Active</option>
                            <option value="inactive">Block</option>
                        </select>
                        @error('subcategory_status')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Sub-category Slug -->
                    <div class="mb-4">
                        <label for="subcategory_slug" class="form-label fw-bold">
                            Sub-category Slug: <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control required_field" id="subcategory_slug" name="subcategory_slug"
                            value="{{ old('subcategory_slug') }}" required>
                        @error('subcategory_slug')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="mt-4 d-flex justify-content-between">
                        <button type="reset" class="btn btn-outline-danger">Reset</button>
                        <button type="submit" class="btn btn-outline-success createBtn px-3">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--Modal ends here-->
