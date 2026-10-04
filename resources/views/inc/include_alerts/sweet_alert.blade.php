   @push('styles')
       <style>
           .modal-backdrop {
               background-color: rgba(0, 0, 0, 0.2);
           }

           .modal-content {
               border-radius: 10px;
               box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
           }
       </style>
   @endpush

   {{-- SUCCESS MODAL --}}
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
                   <form id="globalDeleteForm" method="POST">
                       @csrf
                       @method('DELETE')

                       <button type="submit" class="btn btn-outline-success" id="DeleteButton">
                           <i class="bi bi-trash me-1"></i>Delete
                       </button>
                   </form>

                   <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
               </div>
           </div>
       </div>
   </div>

   @push('scripts')
       <script>
             document.addEventListener('DOMContentLoaded', function() {
                 const successModalElement =
                     document.getElementById('successModal');

                 if (successModalElement) {

                     const successModal =
                         new bootstrap.Modal(successModalElement);

                     successModal.show();

                     setTimeout(function() {
                         successModal.hide();
                     }, 1500);
                 }

                 const deleteModalElement =
                     document.getElementById('globalDeleteModal');

                 const deleteForm =
                     document.getElementById('globalDeleteForm');

                 if (!deleteModalElement || !deleteForm) {
                     return;
                 }

                 const deleteModal =
                     new bootstrap.Modal(deleteModalElement);

                 document.addEventListener('click', function(event) {

                     const deleteButton =
                         event.target.closest('.deleteBtn');

                     if (!deleteButton) {
                         return;
                     }

                     event.preventDefault();

                     const url =
                         deleteButton.dataset.url;

                     if (!url) {

                         toastr.error(
                             'Delete URL missing for this item.'
                         );

                         return;
                     }

                     deleteForm.action = url;

                     deleteModal.show();

                 });

             });
       </script>
   @endpush
