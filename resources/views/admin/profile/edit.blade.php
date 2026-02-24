 <form action="{{ route('admin.profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
     @csrf
     @method('PUT')

     <div class="row mb-3">
         <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile
             Image</label>
         <div class="col-md-8 col-lg-9">
             <img src="{{ $profile && $profile->image ? asset($profile->image->public_path) : asset('default-profile.png') }}"
                 alt="Profile" class="rounded-circle">
             <div class="pt-2">
                 <input type="file" name="image" class="form-control">
             </div>
         </div>
     </div>

     @include('partials.global_file.profile.edit_file')

     <div class="row mb-3">
         <label class="col-md-4 col-lg-3 col-form-label">Full Name</label>
         <div class="col-md-8 col-lg-9">
             <input name="name" type="text" class="form-control" value="{{ $user->name }}">
         </div>
     </div>

     <div class="row mb-3">
         <label class="col-md-4 col-lg-3 col-form-label">About</label>
         <div class="col-md-8 col-lg-9">
             <textarea name="about" class="form-control" style="height: 100px">{{ $profile->about }}</textarea>
         </div>
     </div>

     <div class="row mb-3">
         <label class="col-md-4 col-lg-3 col-form-label">Company</label>
         <div class="col-md-8 col-lg-9">
             <input name="company" type="text" class="form-control" value="{{ $profile->company }}">
         </div>
     </div>

     <div class="row mb-3">
         <label class="col-md-4 col-lg-3 col-form-label">Job</label>
         <div class="col-md-8 col-lg-9">
             <input name="job" type="text" class="form-control" value="{{ $profile->job }}">
         </div>
     </div>

     <div class="text-center">
         <button type="submit" class="btn btn-primary">Save Changes</button>
     </div>
 </form>
