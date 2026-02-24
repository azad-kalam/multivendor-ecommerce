@foreach ($user_details as $user)
    <div class="modal fade" id="user_details_edit_modal_{{ $user->id }}" tabindex="-1"
        aria-labelledby="userDetailsEditModalLabel{{ $user->id }}" data-bs-backdrop="static" aria-hidden="true">
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
                    <h1 class="modal-heading h5">Edit Single User Info</h1>
                </div>
                <form action="{{ route('admin.all_user.update', $user->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Modal Body -->
                    <div class="modal-body role_modal_body mx-3 mt-3 custom_modal_body">
                        <div class="container p-2">
                            <p class="text-danger text-center">Role Filled Will Be Editable</p>
                            <!-- user Name-->
                            <div class="mb-3 row">
                                <label for="name" class="col-sm-3 col-form-label fw-bold">Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" id="name" value="{{ old('name', $user->name) }}"
                                        autocomplete="name" readonly>
                                </div>
                            </div>

                            <!-- user Email-->
                            <div class="mb-3 row">
                                <label for="email" class="col-sm-3 col-form-label fw-bold">Email</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" id="email" value="{{ old('email', $user->email) }}"
                                        autocomplete="email" readonly>
                                </div>
                            </div>

                            <!-- user Phone-->
                            <div class="mb-3 row">
                                <label for="phone" class="col-sm-3 col-form-label fw-bold">Phone</label>
                                <div class="col-sm-9">
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                        name="phone" id="phone" autocomplete="tel"
                                        value="{{ old('phone', $user->phone) }}" readonly>
                                </div>
                            </div>

                            <!-- user Role-->
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><strong>Role</strong></label>
                                <div class="col-sm-9">
                                    <select name="role" class="form-select" required>
                                        @foreach (['admin', 'vendor', 'user'] as $role)
                                            <option value="{{ $role }}"
                                                {{ old('role', $user->role) === $role ? 'selected class=text-danger' : '' }}>
                                                {{ ucfirst($role) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer border-0 mx-2">
                        <a href="{{ route('admin.all_register_info.index', $user->id) }}"
                            class="me-auto ms-3 text-decoration-underline">
                            Click Here
                        </a>

                        <button type="button" class="btn btn-outline-danger me-4" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" class="btn btn-outline-success">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
