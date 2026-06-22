<div id="editStudentAcademicInfoModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form class="modal-content" action="{{ route('students.update.academicinfo', ['id' => $student->currentRegistration->id]) }}" method="POST">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="">Edit <small class="text-primary">{{ $student->full_name }}</small> Academic Info</h5>
        <button class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body row">
        <div class="form-group col-lg-6">
          @php
              $clazz_or_course_id = clazz_or_course_id();
          @endphp
          <label for="my-input">Current Class</label>
          <select name="{{ clazz_or_course_id() }}" id="" class="form-control">
            @foreach ( clazzs_or_courses() as $clazz_or_course)
                <option value="{{ $clazz_or_course->id }}" {{ ($student->currentRegistration->$clazz_or_course_id == $clazz_or_course->id) ? 'selected' : '' }}>{{ $clazz_or_course->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label for="residence"></label>
          <select name="residence" id="" class="form-control">
            <option value="day" {{ ($student->currentRegistration->currentTerm->residence == 'day') ? 'selected' : '' }}>Day</option>
            <option value="boarding" {{ ($student->currentRegistration->currentTerm->residence == 'boarding') ? 'selected' : '' }}>Boarding</option>
          </select>
        </div>
        <div class="form-group col-lg-6">
          <label for="">Hostel</label>
          <select name="hostel" id="" class="form-control">
            @foreach (hostels_of_gender($student->gender) as $hostel)
                <option value="{{ $hostel->id }}">{{ $hostel->name }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-md btn-primary">Update</button>
      </div>
    </form>
  </div>
</div>