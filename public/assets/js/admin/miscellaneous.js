
// $(document).ready(function () {
//     const input = $("#product_image");
//     const fileNameText = $("#fileNameText");
//     const imageDisplay = $("#imageDisplay");

//     const MAX_FILE_SIZE = 2 * 1024 * 1024;
//     const ALLOWED_TYPES = [
//         "image/jpg",
//         "image/jpeg",
//         "image/png",
//         "image/gif",
//         "image/svg+xml",
//         "image/webp"
//     ];

//     input.on("change", function () {

//         const file = this.files[0];
//         if (!file) return;

//         if (!ALLOWED_TYPES.includes(file.type)) {
//             toastr.error("Only JPG, JPEG, PNG, GIF, SVG, WEBP are allowed.");
//             this.value = "";
//             fileNameText.text("No file");
//             imageDisplay.html(`<small class="text-danger">No Image</small>`);
//             return;
//         }

//         if (file.size > MAX_FILE_SIZE) {
//            toastr.error("File size is too large. Maximum allowed 2MB.");
//             this.value = "";
//             fileNameText.text("No file");
//             imageDisplay.html(`<small class="text-danger">No Image</small>`);
//             return;
//         }

//         fileNameText.text(file.name);

//         const reader = new FileReader();
//         reader.onload = function (e) {
//             imageDisplay.html(`<img src="${e.target.result}" class="preview-img">`);
//         };

//         reader.readAsDataURL(file);
//     });
// });





$(document).ready(function () {

    const MAX_FILE_SIZE = 2 * 1024 * 1024; // 2MB

    const ALLOWED_TYPES = [
        "image/jpg",
        "image/jpeg",
        "image/png",
        "image/gif",
        "image/svg+xml",
        "image/webp"
    ];

    $(document).on("change", ".product_image", function () {

        const files = this.files;
        const fileNameText = $(".fileNameText");
        const imageDisplay = $(".imageDisplay");

        imageDisplay.empty();
        fileNameText.text("No file");

        if (!files || !files.length) return;

        let fileNames = [];

        for (let i = 0; i < files.length; i++) {

            const file = files[i];

            if (!ALLOWED_TYPES.includes(file.type)) {
                toastr.error("Only JPG, JPEG, PNG, GIF, SVG, WEBP files are allowed.");
                this.value = "";
                imageDisplay.empty();
                fileNameText.text("No file");
                return;
            }

            if (file.size > MAX_FILE_SIZE) {
                toastr.error("File size is too large. Maximum allowed size is 2MB.");
                this.value = "";
                imageDisplay.empty();
                fileNameText.text("No file");
                return;
            }

            fileNames.push(file.name);

            const reader = new FileReader();
            reader.onload = function (e) {
                imageDisplay.append(`
                    <img src="${e.target.result}"
                         class="preview-img">
                `);
            };
            reader.readAsDataURL(file);
        }

        fileNameText.text(fileNames.join(", "));
    });
});


