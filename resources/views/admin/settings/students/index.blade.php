@extends('layouts.master')

@section('pageheader', 'Students Registration Settings')
    

@section('content')

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <form class="card" action="{{ route('settings.students.registration.update') }}" method="POST">
      @csrf
      <div class="card-body row">

        <div class="form-check">
          <input id="my" class="form-check-input" type="checkbox" name="" value="true">
          <label for="my" class="form-check-label">Text</label><br />

          <input id="my-input" class="form-check-input" type="checkbox" name="" value="true">
          <label for="my-input" class="form-check-label">Text</label>
        </div>

        <div class="col-lg-12 py-5">
          <button type="submit" class="btn btn-sm btn-primary">Update</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection
