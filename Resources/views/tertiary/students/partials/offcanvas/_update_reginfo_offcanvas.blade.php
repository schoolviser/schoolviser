<div  class="offcanvas offcanvas-start rounded-end-3" data-bs-backdrop="static" tabindex="-1" id="updateReg" aria-labelledby="staticBackdropLabel">
 <div class="offcanvas-header">
  <h5 class="offcanvas-title" id="staticBackdropLabel">
   Update Reg Info
  </h5>
  <button
   type="button"
   class="btn-close"
   data-bs-dismiss="offcanvas"
   aria-label="Close"
  ></button>
 </div>
 <div class="offcanvas-body">
  <form action="{{ route('tertiary.students.updateAcademicInfo', ['id' => $student->id]) }}" method="POST" class="row">
   @csrf

   <div class="col-lg-6">
    <label for="regno">Regno</label>
    <input type="text" name="regno" value="{{ old('regno') ?? $student->regno }}" class="form-control" />
   </div>

   <div class="col-lg-6">
    <label for="regno">Admission Number</label>
    <input type="text" name="admission_number" value="{{ old('admission_number') ?? $student->admission_number }}" class="form-control" />
   </div>

   <div class="col-lg-12 mb-2">
        <label for="course">Course</label>
        <select name="course" id="" class="form-control">
            @foreach ($courses as $course)
                <option value="{{ $course->id }}" {{ ($student->course && $student->course->id == $course->id) ? 'selected' : ''  }}>{{ $course->name }}</option>
            @endforeach
        </select>
   </div>

    <div class="col-lg-6">
        <label for="">Semester</label>
        <select name="semester" id="" class="form-control">
            <option value="1" {{ ($student->currentIntakeRegistration->semester == '1') ? 'selected' : ''  }}>Semester 1</option>
            <option value="2" {{ ($student->currentIntakeRegistration->semester == '2') ? 'selected' : ''  }}>Semester 2</option>
        </select>
    </div>

    <div class="col-lg-6">
        <label for="">Year</label>
        <select name="year" id="" class="form-control">
            <option value="1" {{ ($student->currentIntakeRegistration->year == '1') ? 'selected' : ''  }}>Year 1</option>
            <option value="2" {{ ($student->currentIntakeRegistration->year == '2') ? 'selected' : ''  }}>Year 2</option>
            <option value="3" {{ ($student->currentIntakeRegistration->year == '3') ? 'selected' : ''  }}>Year 3</option>
        </select>
    </div>


   <div class="col-lg-6">
        <label class="text-muted text-small">New Or Continuing</label>
        <select name="new_or_continuing" id="" class="form-control">
            <option value="new" {{ ($student->currentIntakeRegistration->new_or_continuing == 'new') ? 'selected' : '' }}>New</option>
            <option value="continuing" {{ ($student->currentIntakeRegistration->new_or_continuing == 'continuing') ? 'selected' : '' }}>Continuing</option>
        </select>
        <small class="text-danger text-muted p-1">{{ $errors->first('new_or_continuing') }}</small>
   </div>

   <div class="col-lg-6 ">
    <label for="residence">Residence</label>
    <select name="residence" id="" class="form-control">
     <option value="day" {{ ($student->currentIntakeRegistration && $student->currentIntakeRegistration->residence == 'day') ? 'selected' : '' }}>Day</option>
     <option value="boarding" {{ ($student->currentIntakeRegistration && $student->currentIntakeRegistration->residence == 'boarding') ? 'selected' : '' }}>Boarding</option>
    </select>
   </div>

   <div class="col-lg-12 my-3">
    <button type="submit" class="btn btn-dark w-100 ">Update Info</button>
   </div>

  </form>
 </div>
</div>