{{-- <div class="form-group mb-5">
    <label class="form-label ms-1">
        Choose File [s]: <span class="text-danger">*</span>
    </label>

    <input type="file" class="form-control product_image product_field" name="image[]" accept="image/*" multiple
        required>

    @error('image')
        <span class="text-danger d-block">{{ $message }}</span>
    @enderror

    @error('image.*')
        <span class="text-danger d-block">{{ $message }}</span>
    @enderror

    <div class="d-flex mt-2">
        <small class="text-success mx-1">
            <span class="text-danger" style="font-size: 14px;">Allowed:</span>
            <b class="text-danger">[</b>
            <span style="font-size: 13px;">JPG, JPEG, PNG, WEBP
            </span>
            <b class="text-danger">].</b>
            Maximum: 2 MB.
        </small>
    </div>

    <div class="d-flex align-items-center justify-content-between mt-2">
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

        <div class="imageDisplay image-preview-box btn btn-outline-success">

        </div>
    </div>
</div> --}}




<style>
    .image-preview-wrapper {
        display: flex;
        flex-direction: row-reverse;
        gap: 5px;
        align-items: center;
    }

    .imageDisplay {
        width: 65px;
        height: 65px;
        padding: 3px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .imageDisplay img {
        width: 55px;
        height: 55px;
        object-fit: cover;
        border-radius: 5px;
    }
</style>

<div class="form-group mb-4">
    <label class="form-label ms-1">
        Choose File [s]: <span class="text-danger">*</span>
    </label>

    <input type="file" class="form-control product_image product_field" name="image[]" accept="image/*" multiple
        required>

    @error('image')
        <span class="text-danger d-block">{{ $message }}</span>
    @enderror

    @error('image.*')
        <span class="text-danger d-block">{{ $message }}</span>
    @enderror

    <div class="d-flex mt-3">
        <small class="text-success mx-1">
            <span class="text-danger" style="font-size: 14px;">Allowed:</span>
            <b class="text-danger">[</b>
            <span style="font-size: 13px;">JPG, JPEG, PNG, WEBP
            </span>
            <b class="text-danger">].</b>
            Maximum: 2 MB.
        </small>
    </div>

    <div class="d-flex align-items-center justify-content-between mt-2">
        <div>
            <span class="text-danger ms-1" style="font-size: 15px;">
                Filename:
            </span>
            <b class="text-danger">[</b>
            <span class="text-primary fileNameText" style="font-size: 14px;">
                No file
            </span>
            <b class="text-danger">]</b>
        </div>

    </div>
    <div class="image-preview-wrapper mt-2">
        <div class="imageDisplay image-preview-box btn btn-outline-success">
            <small class="text-danger">Empty</small>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const productImage = document.querySelector('.product_image');
            const fileNameText = document.querySelector('.fileNameText');
            const imageWrapper = document.querySelector('.image-preview-wrapper');

            if (!productImage) return;
            productImage.addEventListener('change', function() {
                const files = this.files;

                imageWrapper.innerHTML = "";
                fileNameText.innerHTML = "";

                if (files.length === 0) {

                    imageWrapper.innerHTML = `
                <div class="imageDisplay image-preview-box btn btn-outline-success">
                    <small class="text-muted">No Image</small>
                </div>
            `;

                    fileNameText.innerHTML = "No file";
                    return;
                }

                let names = [];

                Array.from(files).forEach(function(file) {
                    names.push(file.name);
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const imageBox = document.createElement('div');
                        imageBox.className =
                            "imageDisplay image-preview-box btn btn-outline-success";

                        const img = document.createElement('img');

                        img.src = e.target.result;

                        img.style.width = "55px";
                        img.style.height = "55px";
                        img.style.objectFit = "cover";
                        img.style.borderRadius = "5px";

                        imageBox.appendChild(img);
                        imageWrapper.appendChild(imageBox);
                    };
                    reader.readAsDataURL(file);
                });

                fileNameText.innerHTML = names.join(', ');
            });
        });
    </script>
@endpush
