<div class="form-group mb-4">
    <label class="form-label ms-1">
        Choose File: <span class="text-danger">*</span>
    </label>

    <input type="file" class="form-control product_image product_field" name="image[]" accept="image/*" multiple
        required>

    @error('image')
        <span class="text-danger d-block">{{ $message }}</span>
    @enderror

    @error('image.*')
        <span class="text-danger d-block">{{ $message }}</span>
    @enderror

    <!-- File Allowed Info -->
    <div class="d-flex mt-2">
        <small class="text-success mx-1">
            <span class="text-danger" style="font-size: 14px;">Allowed:</span>
            <b class="text-danger">[</b>
            <span style="font-size: 13px;">JPG, JPEG, PNG, GIF, WEBP
            </span>
            <b class="text-danger">].</b>
            Maximum: 2 MB.
        </small>
    </div>

    <div class="d-flex align-items-center justify-content-between">
        <!-- File name -->
        <div>
            <span class="text-danger" style="font-size: 14px;">
                Filename:
            </span>
            <b class="text-danger">[</b>
            <span class="text-primary fileNameText" style="font-size: 14px;">
                No file
            </span>
            <b class="text-danger">]</b>
        </div>

        <!-- Image display -->
        <div class="imageDisplay image-preview-box btn btn-outline-success">
            {{-- image display here --}}
        </div>
    </div>
</div>
