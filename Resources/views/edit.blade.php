@extends(config('student.layout', 'student::layouts.master'))


@section('module-page-heading', 'Students Profile')


@section('where-am-i')

@endsection


@section('content')

@include('admin.includes.alerts.updated')

<div class="row mb-3">
 <div class="col-lg-2">
  <img src="{{ asset($student->photo ?? config('defaults.avator')) }}" class="img-fluid rounded-circle student-avator w-100" alt="image" />
  <form action="{{ route('students.update.photo', ['id' => $student->id]) }}" method="POST" enctype="multipart/form-data" class="m-2">
    @csrf
    <label for="choosePhoto" class="custom-file-upload text-small bg-light px-2 py-1 rounded-4 border border-primary">
      Choose Photo
    </label>
    <input type="file" id="choosePhoto" name="photo" class="render-image-on-input-file-change d-none" data-imgholder=".student-avator" />
    <input type="submit" class="btn btn-sm btn-white border-primary rounded-4 " id="avatorChangeBtn" value="upload" />
    <small class="text-danger">{{ $errors->first('photo') }}</small>
  </form>
</div>
</div>


<form action="{{ route('students.update.personal.info', ['id' => $student->id]) }}" method="POST" class="row">
 @csrf
 <div class="col-lg-12">
  <h3>Personal Details</h3>
 </div>
  <div class="col-lg-4">
    <label for="">First Name</label>
    <input type="text" name="first_name" value="{{ old('first_name') ?? $student->first_name }}" class="form-control" />
    <small class="text-danger">{{ $errors->first('first_name') }}</small>
  </div>
  <div class="col-lg-4">
    <label for="">Last Name</label>
    <input type="text" name="last_name" value="{{ old('last_name') ?? $student->last_name }}" class="form-control">
  </div>

  <div class="col-lg-4">
    <label class="">Gender *</label>
    <select class="form-control" name="gender">
      <option value="male" {{ ($student->gender == 'male') ? 'selected' : '' }}>Male</option>
      <option value="male" {{ ($student->gender == 'female') ? 'selected' : '' }}>Female</option>
    </select>
    <small class="text-danger">{{ $errors->first('gender') }}</small>
  </div>

  <div class="col-lg-4">
    <label class="">Date of Birth</label>
    <input type="date" name="dob" class="form-control" value="{{ old('dob') ?? $student->dob }}" placeholder="dd/mm/yyyy" />
    <small class="text-danger">{{ $errors->first('dob') }}</small>
  </div>


  <div class="col-lg-4">
    <label>City</label>
    <input type="text" name="city" value="{{ old('city') ?? $student->city }}" class="form-control" />
    <small class="p-2 text-danger">{{ $errors->first('city') }}</small>

  </div>
  <div class="col-lg-4">
    <label>Country *</label>
    <input type="text" name="country" value="{{ old('country') ?? $student->nationality }}" class="form-control" />
    <small class="p-2 text-danger">{{ $errors->first('country') }}</small>

  </div>

  <div class="col-lg-12">
    <button class="btn btn-md btn-primary w-100" type="submit">Update Student Personal Details</button>
  </div>
</form>

<form class="row mt-4">

  <h3>Academic Information</h3>

  <div class="col-lg-4">
    <label for="regNo" class="text-muted text-small text-danger">RegNo</label>
    <input type="text" name="regno" class="form-control" value="{{ old('regno') }}" placeholder="RegNo" />
    <small class="text-muted text-danger">{{ $errors->first('regno') }}</small>
  </div>

  <div class="col-lg-4">
    <label class="clazz text-muted text-small">Class</label>
    @php
        $clazzes = clazzs();
    @endphp
    @if (count($clazzes))
        <select class="form-control" name="clazz" id="clazz">
          @foreach ($clazzes as $clazz)
            <option value="{{ $clazz->id }}" class="text-capitalize">{{ $clazz->name }}</option>
          @endforeach
        </select>
    @endif
  </div>


  <div class="col-md-4">
    <label class="text-muted text-small">Term</label>
    <select name="term" id="" class="form-control">
      <option value="1">Term 1</option>
      <option value="2">Term 2</option>
      <option value="3">Term 3</option>
    </select>
      <small class="text-danger p-1">{{ $errors->first('term') }}</small>
  </div>

  <div class="col-lg-4">
    <label class="text-muted text-small">Entry Date</label>
    <input type="date" name="entry_date" value="{{ old('entry_date') }}" class="form-control" />
    <small class="text-danger text-muted p-1">{{ $errors->first('entry_date') }}</small>
  </div>

</form>


@endsection
