<!--Modal starts here-->
<div class="modal fade mt-0" id="showModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="showModalLabel">

    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-shadow custom_modal_dialog mx-auto">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-secondary">
                <button type="button" class="btn-close bg-danger btn-hover" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <!-- Modal Title -->
            <div class="text-center mt-1">
                <h1 class="modal-heading">Show Single Category</h1>
            </div>

            <!-- Modal Body -->
            <div class="modal-body role_modal_body m-3 custom_modal_body">
                <div class="container p-2 mt-2">
                    <p class="my-4">
                        <strong class="heading-show">NAME:</strong>
                        <i id="catShowName"></i>
                    </p>

                    <p>
                        <strong class="heading-show">TITLE:</strong>
                        <i id="catShowTitle"></i>
                    </p>

                    <p class="my-4">
                        <strong class="heading-show">DESCRIPTION:</strong>
                        <i id="catShowDescription"></i>
                    </p>

                    <p>
                        <strong class="heading-show">SLUG:</strong>
                        <i id="catShowSlug"></i>
                    </p>

                    <p class="my-4 d-flex">
                        <strong class="heading-show m-0">STATUS:</strong>
                        <i id="catShowStatus" class="ms-auto"></i>
                    </p>

                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer pt-1 border-0">
                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--Modal ends here-->
