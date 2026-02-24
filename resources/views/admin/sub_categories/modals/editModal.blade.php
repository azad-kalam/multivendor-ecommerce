<!--Modal starts here-->
<div class="modal fade mt-0" id="admin_edit_SubCategory_modal" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="admin_edit_SubCategory_modal">

    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-shadow custom_modal_dialog mx-auto">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <button type="button" class="btn-close bg-danger btn-hover" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="text-center mt-1">
                <h1 class="modal-heading">Edit Sub-category</h1>
            </div>
            <div class="modal-body custom_modal_body">
                <form action="javascript:void(0)" method="POST" id="subCategoryForm">
                    @csrf
                    <input type="hidden" name="subCategoryEditId" id="subCategoryEditId" class="form-control">

                    {{-- cattegory start here --}}
                    <div class="form-group mt-4">
                        <label for="categoryEditName" class="form-label fw-bolder">Select Category Name:
                            <span class="text-danger fw-bolder">*</span>
                        </label>
                        <select name="category_id" id="categoryEditName" class="form-control form-select" required
                            aria-label="Category selection">
                            <option value="" disabled>Select any category</option>
                        </select>

                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- cattegory end here --}}

                    {{-- sub-cattegory start here --}}
                    <div class="form-group mt-4">
                        <label for="subCategoryEditName" class="form-label fw-bolder">Sub-category Name:
                            <span class="text-danger fw-bolder">*</span>
                        </label>
                        <input type="text" class="form-control" id="subCategoryEditName" name="subcategory_name"
                            value="{{ old('subcategory_name') }}" required>

                        @error('subcategory_name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- sub-cattegory end here --}}

                    {{-- sub-cattegory title start  here --}}
                    <div class="form-group mt-4">
                        <label for="subCategoryEditTitle" class="form-label fw-bolder">Sub-category Title:</label>
                        <input type="text" class="form-control" id="subCategoryEditTitle" name="subcategory_title"
                            placeholder="optional">
                        @error('subcategory_title')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- sub-cattegory title end  here --}}

                    {{-- sub-cattegory description start  here --}}
                    <div class="form-group mt-4">
                        <label for="subCategoryEditDescription" class="form-label fw-bolder">Sub-category
                            Description:</label>
                        <textarea class="form-control" id="subCategoryEditDescription" name="subcategory_description" rows="5"
                            minlength="5" maxlength="300" style="resize: none" placeholder="optional">{{ old('subcategory_description') }}
                        </textarea>
                        @error('subcategory_description')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- sub-cattegory description end  here --}}

                    {{-- sub-cattegory status  here --}}
                    <div class="form-group mt-4">
                        <label for="subCategoryEditStatus" class="form-label fw-bolder">Sub-category Status:
                            <span class="text-danger fw-bolder">*</span>
                        </label>
                        <select name="subcategory_status" id="subCategoryEditStatus" class="form-control form-select"
                            required>
                            <option value="" hidden>select any one</option>
                            <option value="active">Active</option>
                            <option value="inactive">Block</option>
                        </select>
                        @error('subcategory_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- sub-cattegory status end here --}}

                    {{-- sub-cattegory slug start  here --}}
                    <div class="form-group mt-4">
                        <label for="subCategoryEditSlug" class="form-label fw-bolder">Sub-category Slug:
                            <span class="text-danger fw-bolder">*</span>
                        </label>
                        <input type="text" class="form-control" id="subCategoryEditSlug" name="subcategory_slug"
                            value="{{ old('subcategory_slug') }}" required>
                        @error('subcategory_slug')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- sub-cattegory slug end  here --}}

                    <!-- Buttons -->
                    <div class="mt-4 d-flex justify-content-between">
                        <button type="reset" class="btn btn-outline-danger" id="cancel">Reset</button>

                        <button type="submit" class="btn btn-outline-success createBtn px-2"
                            id="subCategoryUpdateBtn">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--Modal ends here-->
