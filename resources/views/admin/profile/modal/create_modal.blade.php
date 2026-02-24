<!--Modal starts here-->
<div class="modal fade" id="create_admin_profile_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- AJAX content loads here -->
            <div class="modal-header bg-secondary">
                <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="text-center mt-1">
                <h1 class="modal-heading">Create personal profile</h1>
            </div>
            <div class="modal-body custom_modal_body">
                <form method="POST" >
                    @csrf

                    <!-- Full Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">Full Name:</label>
                        <input type="text" class="form-control" name="name" id="name"
                            placeholder="Enter your full name">
                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Profile Image -->
                    <div class="mb-3">
                        <label for="file" class="form-label fw-bold">Profile Image:</label>
                        <input type="file" class="form-control" name="file" id="file">
                        @error('file')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Company Name -->
                    <div class="mb-3">
                        <label for="company_name" class="form-label fw-bold">Company Name:</label>
                        <input type="text" class="form-control" name="company_name" id="company_name"
                            placeholder="Enter your company name">
                        @error('company_name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Job Name -->
                    <div class="mb-3">
                        <label for="job_name" class="form-label fw-bold">Job Name:</label>
                        <input type="text" class="form-control" name="job_name" id="job_name"
                            placeholder="Enter your job name">
                        @error('job_name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Address-->
                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold">Email Address:</label>
                        <input type="email" class="form-control" name="email" id="email"
                            placeholder="Enter your email address">
                        @error('email')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Current Address -->
                    <div class="mb-3">
                        <label for="current_address" class="form-label fw-bold">Current Address:</label>
                        <textarea class="form-control" rows="3" name="current_address" id="current_address"
                            placeholder="Enter your current address"></textarea>
                        @error('current_address')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- permanent Address -->
                    <div class="mb-3">
                        <label for="permanent_address" class="form-label fw-bold">Permanent Address:</label>
                        <textarea class="form-control" rows="3" name="permanent_address" id="permanent_address"
                            placeholder="Enter your permanent address"></textarea>
                        @error('permanent_address')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- bio -->
                    <div class="mb-3">
                        <label for="bio_details" class="form-label fw-bold">Your Bio:</label>
                        <textarea class="form-control" rows="3" name="bio_details" id="bio_details" placeholder="Enter your bio details"></textarea>
                        @error('bio_details')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="mb-3">
                        <label for="phone" class="form-label fw-bold">Phone Number:</label>
                        <input type="text" class="form-control" name="phone" id="phone"
                            placeholder="Enter your phone number">
                        @error('bio_details')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="mt-4 d-flex justify-content-between">
                        <button type="reset" class="btn btn-outline-danger">
                            Reset
                        </button>

                        <button type="submit" class="btn btn-outline-success px-2">
                            Create
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--Modal ends here-->
