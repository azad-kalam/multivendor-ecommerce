@foreach ($admin_details as $admin)
    <div class="modal fade" id="admin_details_edit_modal_{{ $admin->id }}" tabindex="-1"
        aria-labelledby="adminDetailsEditModalLabel{{ $admin->id }}" data-bs-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-shadow custom_modal_dialog mx-auto">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-secondary">
                    <button type="button" class="btn-close bg-danger btn-hover" data-bs-dismiss="modal"
                        aria-label="Close">
                    </button>
                </div>

                <!-- Modal Title -->
                <div class="text-center mt-2">
                    <h1 class="modal-heading h5">Edit Single Admin Info</h1>
                </div>
                <form action="{{ route('admin.details.update', $admin->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Modal Body -->
                    <div class="modal-body role_modal_body mx-3 mt-3 custom_modal_body">
                        <div class="container p-2">
                            <!-- Admin Name (Editable) -->
                            <div class="mb-3 row">
                                <label for="name" class="col-sm-3 col-form-label fw-bold">Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" id="name" value="{{ old('name', $admin->name) }}"
                                        autocomplete="name" placeholder="Enter admin name" required>

                                    @error('name')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <!-- Admin Email (Editable) -->
                            <div class="mb-3 row">
                                <label for="email" class="col-sm-3 col-form-label fw-bold">Email</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" id="email" value="{{ old('email', $admin->email) }}"
                                        autocomplete="email" placeholder="Enter admin email" required>

                                    @error('email')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <!-- Admin Phone (editable) -->
                            <div class="mb-3 row">
                                <label for="phone" class="col-sm-3 col-form-label fw-bold">Phone</label>
                                <div class="col-sm-9">
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                        name="phone" id="phone" autocomplete="tel" placeholder="Enter admin phone"
                                        value="{{ old('phone', $admin->phone) }}">
                                    @error('phone')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <!-- Admin role -->
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label fw-bold">Role</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="{{ $admin->role }}" readonly>
                                    <input type="hidden" name="role" value="{{ $admin->role }}">
                                    <small class="text-danger text-center">Role field cannot be changed</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer border-0 mx-2">
                        <button type="button" class="btn btn-outline-danger me-4"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-outline-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
