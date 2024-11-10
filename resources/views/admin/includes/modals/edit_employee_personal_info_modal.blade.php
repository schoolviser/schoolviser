<div id="editEmployeePersonalInfoModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
  <form class="modal-dialog modal-lg" role="document" method="POST" action="{{ route('staff.update.personal.info', ['id' => $id]) }}">
    @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="my-modal-title">Update Employee Personal Info</h5>
        <button class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body row">
        <div class="col-12 col-lg-3">
          <label for="first_name" class="text-muted text-small">First Name</label>
          <input type="text" name="first_name" class="form-control" value="{{ old('first_name') ?? $firstname }}" placeholder="First Name" />
        </div>
        <div class="col-lg-3">
          <label for="last_name" class="text-muted text-small">Last Name</label>
          <input type="text" name="last_name" class="form-control" value="{{ old('last_name') ?? $lastname }}" placeholder="Last Name" />
        </div>
        <div class="col-lg-3">
          <label for="nin" class="text-muted text-small">Nin</label>
          <input type="text" name="nin" class="form-control" value="{{ old('nin') ?? $nin }}" placeholder="Nin" />
        </div>
        <div class="col-lg-3">
          <label for="dob" class="text-muted text-small">Date Of Birth</label>
          <input type="date" name="dob" class="form-control" value="{{ old('dob') ?? $dob }}" placeholder="Date Of Birth" />
        </div>
        <div class="col-lg-3">
          <label for="gender" class="text-muted text-small">Gender</label>
          <select name="gender" id="gender" class="form-control">
            <option value="male" {{ ($gender == 'male') ? 'selected' : '' }}>Male</option>
            <option value="female" {{ ($gender == 'female') ? 'selected' : '' }}>Female</option>
          </select>
        </div>
        <div class="col-lg-3">
          <label for="nationality" class="text-muted text-small">Nationality</label>
          <input type="text" name="nationality" class="form-control" value="{{ old('nationality') ?? $nationality }}" placeholder="Nationality" />
        </div>
        <div class="col-lg-3">
          <label for="religion" class="text-muted text-small">Religion</label>
          <input type="text" name="religion" class="form-control" value="{{ old('religion') ?? $religion }}" placeholder="Religion" />
        </div>
        <div class="col-lg-3">
          <label for="email" class="text-muted text-small">Email</label>
          <input type="text" name="email" class="form-control" value="{{ old('email') ?? $email }}" placeholder="Email" />
        </div>
        <div class="col-lg-3">
          <label for="phone" class="text-muted text-small">Phone</label>
          <input type="text" name="phone" class="form-control" value="{{ old('phone') ?? $phone }}" placeholder="phone" />
        </div>
        <div class="col-lg-3">
          <label for="otherphone" class="text-muted text-small">Other Phone</label>
          <input type="text" name="other_phone" class="form-control" value="{{ old('other_phone') ?? $otherphone }}" placeholder="phone" />
        </div>
      </div>
      <div class="modal-footer text-start">
        <button type="submit" class="btn btn-md btn-primary">Update Info</button>
      </div>
    </div>
  </form>
</div>
