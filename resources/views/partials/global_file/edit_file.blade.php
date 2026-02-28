<div class="form-group mb-3">
    <label for="image" class="form-label ms-1">Image Choose:</label>

    <input type="file" class="form-control" id="product_image" name="image[]" accept="image/*" capture="camera" multiple>

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

    <div class="d-flex align-items-center justify-content-between mt-2">
        <!-- File Name -->
        <div>
            <span class="text-danger" style="font-size: 15px;">File name:</span>
            <span>[</span>
            <span id="fileNameText" class="text-primary" style="font-size: 15px;">
                {{ $productFind->images->pluck('file_name')->implode(', ') ?: 'No file' }}
            </span>
            <span>]</span>
        </div>

        <!-- Image Preview -->
        <div class="btn btn-outline-success p-1 border border-1 border-dark rounded"
            style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
            <div id="imageDisplay">
                @if (
                    !empty($productFind->images->first()?->public_path) &&
                        file_exists(public_path($productFind->images->first()->public_path)))
                    <img src="{{ asset($productFind->images->first()->public_path) }}"
                        style="width:50px; height:50px; border-radius:5px;" alt="Current Image">
                @else
                    <small class="text-danger">No Image</small>
                @endif
            </div>
        </div>
    </div>

    @error('image')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
