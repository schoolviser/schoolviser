<div id="addStudentParentModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <form class="modal-content" action="{{ route('students.parents.add', ['student_id' => $student->id]) }}" method="POST">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="">Add Parent Details For {{ $student->full_name }}</h5>
        <button class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body row">
        <div class="form-group col-lg-6">
          <label for="surname">Surname</label>
          <input type="text" name="surname" class="form-control" value="{{ old('surname') }}" placeholder="Surname" />
          <small class="text-danger">{{ $errors->first('surname') }}</small>
        </div>
        <div class="form-group col-lg-6">
          <label for="other_names">Other Names</label>
          <input type="text" name="other_names" class="form-control" value="{{ old('other_names') }}" placeholder="Other Names" />
          <small class="text-danger">{{ $errors->first('other_names') }}</small>
        </div>
        <div class="form-group col-lg-6">
          <label for="nationality">Nationality</label>
          <input type="text" name="nationality" class="form-control" value="{{ old('nationality') }}" placeholder="Nationality" />
          <small class="text-danger">{{ $errors->first('nationality') }}</small>
        </div>
        <div class="form-group col-lg-6">
          <label for="phone_one">Phone Number</label>
          <input type="text" name="phone_one" class="form-control" value="{{ old('phone_one') }}" placeholder="Phone Number" />
          <small class="text-danger">{{ $errors->first('phone_one') }}</small>
        </div>
        <div class="form-group col-lg-6">
          <label for="email">Email Address</label>
          <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Email Address" />
          <small class="text-danger">{{ $errors->first('email') }}</small>
        </div>
        <div class="form-group col-lg-6">
          <label for="relation">Relationship</label>
          <select name="relationship" id="" class="form-control text-capitalize">
            @php
                $relations = config('defaults.relations', []);
            @endphp
            @for ($i = 0; $i < count($relations); $i++)
              <option value="{{ $relations[$i] }}">{{ $relations[$i] }}</option>
            @endfor
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-md btn-primary">save</button>
      </div>
    </form>
  </div>
</div>