  <div class="col-md-12 text-center">
      @if (!empty($profile) && !empty($profile->image))
          <img src="{{ asset($profile->image->public_path) }}" class="rounded-circle border border-2 border-danger"
              id="oldImage">
      @else
          <i class="fa fa-user-circle fa-5x text-secondary" id="defaultIcon"></i>
      @endif

      <img id="newImagePreview" class="rounded-circle d-none" alt="New profile image">
  </div>
