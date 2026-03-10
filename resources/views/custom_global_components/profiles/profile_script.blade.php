<script>
    document.addEventListener('DOMContentLoaded', function() {

        const input = document.querySelector('.product_image');
        const oldImage = document.getElementById('oldImage');
        const defaultIcon = document.getElementById('defaultIcon');
        const newImage = document.getElementById('newImagePreview');
        const fileNameText = document.querySelector('.fileNameText');

        if (input) {
            input.addEventListener('change', function(e) {

                let file = e.target.files[0];

                if (file) {

                    fileNameText.textContent = file.name;

                    const reader = new FileReader();

                    reader.onload = function(event) {

                        newImage.src = event.target.result;
                        newImage.classList.remove('d-none');

                        if (oldImage) {
                            oldImage.style.display = "none";
                        }

                        if (defaultIcon) {
                            defaultIcon.style.display = "none";
                        }

                    }

                    reader.readAsDataURL(file);

                } else {

                    fileNameText.textContent = "No file";
                    newImage.classList.add('d-none');

                    if (oldImage) {
                        oldImage.style.display = "block";
                    }

                    if (defaultIcon) {
                        defaultIcon.style.display = "block";
                    }

                }

            });
        }

    });
</script>
