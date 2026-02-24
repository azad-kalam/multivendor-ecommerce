<!--Modal starts here-->
<div class="modal fade mt-0" id="categoryEditModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="categoryEditModal">
     <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-shadow custom_modal_dialog mx-auto">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <button type="button" class="btn-close bg-danger btn-hover" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="text-center mt-1">
                <h1 class="modal-heading">Edit Category</h1>
            </div>
            <div class="modal-body custom_modal_body">
                <form id="categoryUpdateForm">
                    @csrf
                    <input type="hidden" id="catEditId" name="catEditId">

                    <!-- Category Name -->
                    <div class="mb-4 mt-4">
                        <label for="catEditName" class="form-label fw-bold">Category Name:</label>
                        <input type="text" class="form-control custom-border" id="catEditName" name="name"
                            value="{{ old('name') }}" required autofocus>
                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category Title -->
                    <div class="mb-4">
                        <label for="catEditTitle" class="form-label fw-bold">Category Title:</label>
                        <input type="text" class="form-control custom-border" id="catEditTitle" name="title"
                            value="{{ old('title') }}" required>
                        @error('title')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category Description -->
                    <div class="mb-4">
                        <label for="catEditDescription" class="form-label fw-bold">Category Description:</label>
                        <textarea class="form-control custom-border" id="catEditDescription" name="description" rows="5" minlength="5"
                            maxlength="300" style="resize: none;" required>{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category Status -->
                    <div class="mb-4">
                        <label for="catEditStatus" class="form-label fw-bold">Category Status:</label>
                        <select name="status" id="catEditStatus" class="form-select custom-border" required>
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
                        <label for="catEditSlug" class="form-label fw-bold">Category Slug:</label>
                        <input type="text" class="form-control custom-border" id="catEditSlug" name="slug"
                            value="{{ old('slug') }}" required>
                        @error('slug')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="mt-4 d-flex justify-content-between">
                        <button type="reset" class="btn btn-outline-danger">Reset</button>

                        <button type="submit" id="catUpdateBtn" class="btn btn-outline-success createBtn px-2">
                            Update
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<!--Modal ends here-->
