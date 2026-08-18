<div class="form-group mb-5">
    <label class="form-label ms-1">
        Choose File:
    </label>

    <input type="file" class="form-control product_image product_field" name="image" accept="image/*">

    @error('image')
        <span class="text-danger d-block">{{ $message }}</span>
    @enderror

    <!-- File Allowed Info -->
    <div class="d-flex mt-2">
        <small class="text-success mx-1">
            <span class="text-danger" style="font-size: 14px;">Allowed:</span>
            <b class="text-danger">[</b>
            <span style="font-size: 13px;">JPG, JPEG, PNG, WEBP</span>
            <b class="text-danger">]</b>
            Maximum: 2 MB.
        </small>
    </div>

    <div class="d-flex align-items-center justify-content-between mt-2">
        <!-- File name -->
        <div>
            <span class="text-danger" style="font-size: 15px;">
                Filename:
            </span>
            <b class="text-danger">[</b>
            <span class="text-primary fileNameText" style="font-size: 14px;">
                No file
            </span>
            <b class="text-danger">]</b>
        </div>

        <!-- Image Preview -->
        <div class="imageDisplay image-preview-box btn btn-outline-success">
            {{-- image preview here --}}
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener("click", function(e) {

            const resetBtn = e.target.closest(".reset");
            if (!resetBtn) return;

            const form = resetBtn.closest("form");
            if (!form) return;

            setTimeout(() => {

                form.querySelectorAll(".form-group").forEach(group => {

                    const imageDisplay = group.querySelector(".imageDisplay");
                    const fileNameText = group.querySelector(".fileNameText");

                    if (imageDisplay) imageDisplay.innerHTML = "";
                    if (fileNameText) fileNameText.textContent = "No file";

                });

            }, 0);

        });
    </script>
@endpush
