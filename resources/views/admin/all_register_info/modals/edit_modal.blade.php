<!--Edit Modal start here-->
@foreach ($all_register as $register)
    <div class="modal fade" id="register_edit_modal_{{ $register->id }}" tabindex="-1"
        aria-labelledby="registerEditModalLabel{{ $register->id }}" data-bs-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
            <div class="modal-content p-0">
                <!-- Modal Header -->
                <div class="modal-header bg-secondary">
                    <button type="button" class="btn-close bg-danger btn-outline-danger" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="text-center mt-2">
                    <h1 class="modal-heading">Edit Single Register Role</h1>
                </div>

                <form action="{{ route('admin.all_register_info.update', $register->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Modal Body -->
                    <div class="modal-body role_modal_body mx-3 mt-3">
                        <div class="container p-2">
                            <p class="text-danger text-center">Role field can be changed</p>
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><strong>Name</strong></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"
                                        value="{{ old('name', $register->name) }}" readonly>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><strong>Email</strong></label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control"
                                        value="{{ old('email', $register->email) }}" readonly>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><strong>Phone</strong></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"
                                        value="{{ old('phone', $register->phone) }}" readonly>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label"><strong>Role</strong></label>
                                <div class="col-sm-9">

                                    @php
                                        $selectedRole = old('role', $register->role);
                                    @endphp

                                    <select name="role" class="form-select" required>
                                        @foreach (['admin', 'vendor', 'user'] as $role)
                                            <option value="{{ $role }}"
                                                @if ($selectedRole === $role) selected class="text-danger" @endif>
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
                        <button type="button" class="btn btn-outline-danger me-4"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-outline-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
<!--Edit Modal ends here-->
