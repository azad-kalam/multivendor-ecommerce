<!-- Create Vendor Modal -->
<div class="modal fade" id="create_vendor_modal" tabindex="-1" aria-labelledby="createVendorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-shadow custom_modal_dialog mx-auto">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-secondary">
                <button type="button" class="btn-close bg-danger btn-hover" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <!-- Modal Title -->
            <div class="text-center mt-1">
                <h1 class="modal-heading">Create New Vendor</h1>
            </div>

            <!-- Modal Body -->
            <div class="modal-body custom_modal_body">
                <div class="container">
                    <p class="text-center text-danger">You are not allowed to create new vendor</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const vendorModalEl = document.getElementById('create_vendor_modal');
        const vendorModal = new bootstrap.Modal(vendorModalEl);

        vendorModalEl.addEventListener('shown.bs.modal', function() {
            setTimeout(function() {
                vendorModal.hide();
            }, 1500);
        });
    });
</script>
