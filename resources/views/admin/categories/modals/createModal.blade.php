<!--Modal starts here-->
<div class="modal fade" id="admin_createCategory_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-shadow custom_modal_dialog mx-auto">
        <div class="modal-content">
            <!-- AJAX content loads here -->
            <div class="modal-header bg-secondary">
                <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="text-center mt-1">
                <h1 class="modal-heading">Create New Category</h1>
            </div>
            <div class="modal-body custom_modal_body">
                <form method="POST" id="categoryForm">
                    @csrf

                    <!-- Category Name -->
                    <div class="mb-4 mt-4">
                        <label for="name" class="form-label fw-bold">
                            Category Name: <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control custom-border required_field" id="name" name="name" required>
                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category Title -->
                    <div class="mb-4">
                        <label for="title" class="form-label fw-bold">
                            Category Title: <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control custom-border required_field" id="title" name="title" required>
                        @error('title')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category Description -->
                    <div class="mb-4">
                        <label for="description" class="form-label fw-bold">
                            Category Description: <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control custom-border required_field" id="description" name="description" rows="5" minlength="5"
                            maxlength="300" style="resize: none;" required></textarea>
                        @error('description')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category Status -->
                    <div class="mb-4">
                        <label for="status" class="form-label fw-bold">
                            Category Status: <span class="text-danger">*</span>
                        </label>
                        <select name="status" id="status" class="form-select custom-border required_field" required>
                            <option value="" hidden>Select any one</option>
                            <option value="active">Active</option>
                            <option value="inactive">Block</option>
                        </select>
                        @error('status')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Category Slug -->
                    <div class="mb-4">
                        <label for="slug" class="form-label fw-bold">
                            Category Slug: <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control custom-border required_field" id="slug" name="slug" required>
                        @error('slug')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="mt-4 d-flex justify-content-between">
                        <button type="reset" class="btn btn-outline-danger">
                            Reset
                        </button>

                        <button type="submit" class="btn btn-outline-success px-2">
                            Create
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<!--Modal ends here-->
