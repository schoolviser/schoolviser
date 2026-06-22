<div id="editStudentPersonalInfoModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form class="modal-content" action="{{ route('students.update.personalinfo', ['id' => $student->id]) }}" method="POST">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="">Edit {{ $student->full_name }} Info</h5>
        <button class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body row">
        <div class="col-lg-6 mb-1">
          <label for="" class="text-small text-muted">Surname</label>
          <input id="surname" class="form-control" type="text" name="first_name" value="{{ old('first_name') ?? $student->first_name }}">
        </div>
        <div class="form-group col-lg-6">
          <label for="" class="text-small text-muted">Other Names</label>
          <input id="my-input" class="form-control" type="text" name="last_name" value="{{ old('last_name') ?? $student->last_name }}" />
        </div>
        <div class="col-lg-6">
          <label for="" class="text-small text-muted">Gender</label>
          <select class="form-control" name="gender">
            <option value="male" {{ ($student->gender == 'male') ? 'selected' : '' }}>Male</option>
            <option value="female" {{ ($student->gender == 'female') ? 'selected' : '' }}>Female</option>
          </select>
          <small class="p-2 text-danger">{{ $errors->first('gender') }}</small>
        </div>
        <div class="form-group col-lg-6">
          <label for="my-input" class="text-small text-muted">Date of birth</label>
          <input id="" class="form-control" type="date" name="dob" value="{{ old('dob') ?? $student->dob }}">
        </div>
        <div class="form-group col-lg-6">
          <label for="my-input" class="text-small text-muted">Nationality</label>
          <input id="my-input" class="form-control" type="text" name="nationality" value="{{ old('nationality') ?? $student->nationality }}">
        </div>
        <div class="form-group col-lg-6">
          <label for="my-input" class="text-small text-muted">Address</label>
          <input id="my-input" class="form-control" type="text" name="address" value="{{ old('address') ?? $student->address }}">
        </div>
        <div class="form-group col-lg-6">
          <label for="my-input" class="text-small text-muted">Nin</label>
          <input id="my-input" class="form-control" type="text" name="nin" value="{{ old('nin') ?? $student->nin }}">
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-md btn-primary">Update</button>
      </div>
    </form>
  </div>
</div>