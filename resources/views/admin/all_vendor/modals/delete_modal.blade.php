@foreach ($vendor_details as $vendor)
    <div class="modal fade" id="vendor_delete_modal_{{ $vendor->id }}" tabindex="-1"
        aria-labelledby="vendorDeleteModalLabel{{ $vendor->id }}" data-bs-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-shadow custom_modal_dialog mx-auto">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Delete Vendor</h5>
                    <button type="button" class="btn-close bg-light" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body text-center">
                    <p class="text-danger fw-bold">
                        Are you sure you want to delete <br>
                        <span class="text-dark">"{{ $vendor->name }}"</span>?
                    </p>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer border-0 mx-2">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                    <form action="{{ route('admin.all_vendor.destroy', $vendor->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            Yes, Delete
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endforeach
