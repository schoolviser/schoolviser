@extends('layouts.master')

@section('pageheader', 'Students Registration Settings')
    

@section('content')

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <form class="card" action="{{ route('settings.students.registration.update') }}" method="POST">
      @csrf
      <div class="card-body row">

        <div class="form-check col-lg-6">
          <input id="autoGenStudentRegNo" class="form-check-input" type="checkbox" name="auto_generate_student_regno" value="1" {{ (option('auto_generate_student_regno') ? 'checked' : '') }} />
          <label for="autoGenStudentRegNo" class="form-check-label">Auto Generate Student RegNo</label><br />
          <small class="text-small text-muted">
            If turned on you student regiatratio n numbers will be generated automatically, You wont be able to enter regno manually.
          </small>
        </div>

        <div class="form-check col-lg-6">
          <input id="d" class="form-check-input" type="checkbox" name="allow_selection_of_term_to_register_student" value="1" {{ (option('allow_selection_of_term_to_register_student') ? 'checked' : '') }} />
          <label for="d" class="form-check-label">Allow Selection Of Term When Registering Student</label><br />
          <small class="text-small text-muted">
            If turned off, the term will be set to the current system term.
          </small>
        </div>

        <div class="col-lg-12 py-5">
          <button type="submit" class="btn btn-sm btn-primary">Update</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection
