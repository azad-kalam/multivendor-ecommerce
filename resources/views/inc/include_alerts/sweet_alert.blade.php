{{-- modal success --}}
@if (session('session_success'))
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel">
        <div class="modal-dialog modal-dialog-centered mx-auto" style="max-width: 430px;">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title fs-5 mx-auto text-white" id="successModalLabel">Success</h5>
                </div>
                <div class="modal-body text-center">
                    <i class="fa-solid fa-circle-check fa-2x text-success"></i>
                    <p class="text-center h5 fw-bold my-2">Great!</p>
                    <p class="text-center">{{ session('session_success') }}</p>
                </div>
                <div class="modal-footer border-0 d-flex justify-content-center">
                    <button type="button" class="btn btn-success text-white" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = new bootstrap.Modal(document.getElementById('successModal'));
            modal.show();

            setTimeout(() => {
                modal.hide();
            }, 1500);
        });
    </script>
@endif

{{-- Delete Confirmation Modal --}}
<div class="modal fade" id="globalDeleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="globalDeleteModalLabel">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h1 class="modal-title fs-5 mx-auto text-white" id="globalDeleteModalLabel">Delete Confirmation</h1>
            </div>
            <div class="modal-body text-center">
                <i class="bi bi-exclamation-triangle-fill text-danger fs-1"></i>
                <p class="mt-2">Are you sure you want to delete this item?</p>
                <p>This action cannot be undone.</p>
            </div>
            <div class="modal-footer d-flex justify-content-between border-0 mt-2">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                <form id="globalDeleteForm" method="POST">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-success" id="DeleteButton">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.deleteBtn');
        const deleteForm = document.getElementById('globalDeleteForm');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const deleteUrl = this.getAttribute('data-url');

                if (!deleteUrl) {
                    console.error('Delete URL not found');
                    return;
                }

                deleteForm.setAttribute('action', deleteUrl);
            });
        });
    });
</script>

<style>
    .modal-backdrop {
        background-color: rgba(0, 0, 0, 0.2);
    }

    .modal-content {
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
</style>
