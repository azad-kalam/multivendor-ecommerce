
// $(document).ready(function () {
//     toastr.options = {
//         closeButton: true,
//         progressBar: true,
//         positionClass: "toast-top-right",
//         preventDuplicates: true,
//         showDuration: "300",
//         hideDuration: "1000",
//         timeOut: "2000",
//         extendedTimeOut: "1000",
//         showEasing: "swing",
//         hideEasing: "linear",
//         showMethod: "fadeIn",
//         hideMethod: "fadeOut",
//         zIndex: 9999
//     };

//     const categoryFields = ["#name", "#title", "#description", "#status", "#slug"];

//     categoryFields.forEach(field => {
//         $(field).on("blur", function () {

//             categoryFields.forEach(selector => {
//                 const value = $(selector).val();

//                 if (!value || value.trim() === "") {

//                     let fieldName = $(selector).attr("id")
//                         .replace(/_/g, " ")
//                         .replace(/\b\w/g, c => c.toUpperCase());

//                     toastr.warning(fieldName + " field is empty!", "Warning");
//                 }
//             });
//         });
//     });

//     const subCategoryFields = {
//         "Category name": "#category_id",
//         "Subcategory name": "#subcategory_name",
//         "Subcategory title": "#subcategory_title",
//         "Subcategory description": "#subcategory_description",
//         "Subcategory status": "#subcategory_status",
//         "Subcategory slug": "#subcategory_slug",
//     };

//     Object.entries(subCategoryFields).forEach(([name, selector]) => {
//         $(selector).on("blur", function () {
//             const value = $(this).val();
//             if (!value || value.trim() === "") {
//                 toastr.warning(`${name} field is empty!`, "Warning");
//             }
//         });
//     });

//     const requiredFields = [
//         "#product_name", "#short_description", "#full_description",
//         "#category_id", "#subcategory_id",
//         "#product_image", "#video_url",
//         "#product_visibility", "#product_status",
//         "#product_sku", "#stock_quantity", "#stock_status",
//         "#regular_price", "#selling_price", "#discount_value", "#discount_start", "#discount_end",
//         "#brand", "#model", "#size", "#color", "#product_weight", "#warranty",
//         "#meta_title", "#meta_description", "#meta_keywords"
//     ];

//     function isEmpty(selector) {
//         const element = $(selector);
//         if (!element.length) return true;

//         const value = element.val();
//         return !value || value.trim() === "";
//     }

//     function countEmptyFields() {
//         let count = 0;

//         requiredFields.forEach(selector => {
//             if (isEmpty(selector)) count++;
//         });

//         if ($("input[name='featured']:checked").length === 0) count++;
//         if (!$("#manage_stock").is(":checked")) count++;
//         if ($("input[name='discount_type']:checked").length === 0) count++;

//         return count;
//     }

//     function showWarning() {
//         const missing = countEmptyFields();

//         if (missing > 0) {
//             const word = missing === 1 ? "Field is" : "Fields are";
//             toastr.warning(`${missing} ${word} empty!`, "Warning");
//         }
//     }

//     requiredFields.forEach(selector => {
//         $(selector).on("blur change", showWarning);
//     });

//     $("#manage_stock").on("change", showWarning);
//     $("input[name='featured'], input[name='discount_type']").on("change", showWarning);

// });








