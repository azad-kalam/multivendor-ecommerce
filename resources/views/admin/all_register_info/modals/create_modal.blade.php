<!-- Modal starts here -->
<div class="modal fade" id="register_create_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="registerCreateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="width: 400px;">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-secondary">
                <button type="button" class="btn-close bg-danger btn-outline-danger" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="text-center mt-2">
                <h1 class="modal-heading">Create New Register</h1>
            </div>

            <!-- Modal Body -->
            <div class="modal-body mx-1" style="scroll-behavior: smooth; scrollbar-width: thin;">
                <form method="POST" action="{{ route('admin.all_register_info.store') }}">
                    @csrf

                    <!-- Name -->
                    <div class="mb-4">
                        <label for="name" class="form-label fw-bold">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" required>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="form-label fw-bold">Email
                            <span class="text-danger">*</span>
                        </label>
                        <input type="email" class="form-control" id="email" name="email" required>
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="mb-4">
                        <label for="phone" class="form-label fw-bold">Phone
                            <span class="text-danger">*</span>
                        </label>
                        <input type="tel" class="form-control" id="phone" name="phone" required>
                        @error('phone')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Role -->
                    <div class="mb-4">
                        <label for="role" class="form-label fw-bold">User Type
                            <span class="text-danger">*</span>
                        </label>
                        <select name="role" id="role" class="form-select" required>
                            <option value="" hidden>Select any one</option>
                            <option value="admin">Admin</option>
                            <option value="vendor">Vendor</option>
                            <option value="user">User</option>
                        </select>
                        @error('role')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="phone" class="form-label fw-bold">Password
                            <span class="text-danger">*</span>
                        </label>
                        <input id="password" type="password" name="password" class="form-control" required>
                        @error('password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-3">
                        <label for="phone" class="form-label fw-bold">Confirm Password <span
                                class="text-danger">*</span></label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="form-control @error('password_confirmation') is-invalid @enderror" required>
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Actions -->
                    <div>
                        <a class="text-decoration-underline fw-bold small text-secondary hover:text-dark"
                            href="{{ route('login') }}">
                            {{ __('Already registered?') }}
                        </a>
                    </div>

                    <!-- button -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <button type="reset" class="btn btn-outline-danger me-3">
                            Reset
                        </button>
                        <button type="submit" class="btn btn-outline-success">
                            {{ __('Register') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal ends here -->
