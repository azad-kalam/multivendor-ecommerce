<div class="form-group mb-5">
    <label for="image" class="form-label ms-1">
        Image Choose: <span class="text-danger" aria-hidden="true">*</span>
    </label>

    <input type="file" class="form-control" id="product_image" name="image[]" accept="image/*" capture="camera" multiple>

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
            <span class="text-danger" style="font-size: 15px;">File name:</span>
            <span>[</span>
            <span id="fileNameText" class="text-primary" style="font-size: 14px;">
                {{ $productFind->images->pluck('file_name')->implode(', ') ?: 'No file' }}
            </span>
            <span>]</span>
        </div>

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

{{-- <script>
    document.getElementById('product_image').addEventListener('change', function(event) {
        const imageDisplay = document.getElementById('imageDisplay');
        const fileNameText = document.getElementById('fileNameText');

        imageDisplay.innerHTML = "";
        fileNameText.innerHTML = "";

        const files = event.target.files;

        if (files.length > 0) {
            let names = [];

            for (let i = 0; i < files.length; i++) {
                names.push(files[i].name);
            }

            const firstFile = files[0];

            const reader = new FileReader();
            reader.onload = function(e) {
                let img = document.createElement('img');
                img.src = e.target.result;
                img.style.width = "50px";
                img.style.height = "50px";
                img.style.borderRadius = "5px";
                img.style.objectFit = "cover";

                imageDisplay.appendChild(img);
            };

            reader.readAsDataURL(firstFile);

            fileNameText.innerHTML = names.join(', ');
        } else {
            imageDisplay.innerHTML = "<small class='text-danger'>No Image</small>";
            fileNameText.innerHTML = "No file";
        }
    });
</script> --}}
