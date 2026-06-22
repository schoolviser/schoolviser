@extends(config('student.layout', 'student::layouts.master'))


@section('module-page-heading', 'Create Year Groups')
@section('pageheaderDescription', 'Manage Students')

@section('module-links')
<a href="{{ route('settings.year.groups.create') }}">Create New</a>
<a href="{{ route('settings') }}">Settings</a>
@endsection

@section('where-am-i')

@endsection

@section('content')
<form action="{{ route('settings.year.groups.store') }}" method="POST" class="row">
 @csrf

 <div class="col-lg-4 mb-2">
  <label for="name">Name</label>
  <input type="text" name="name" class="form-control" placeholder="Year Group Name" id="name" />
  <small class="text-danger">{{ $errors->first('name') }}</small>
 </div>

 <div class="col-lg-2">
  <label for="year">Academic Year</label>
  <select name="year" id="" class="form-control">
   @foreach ($academic_years as $year)
       <option value="{{  $year->id}}">{{ $year->name }}</option>
   @endforeach
  </select>
  <small class="text-danger">{{ $errors->first('year') }}</small>
 </div>

 <div class="col-lg-7 mb-3">
  <label for="description">Description</label>
  <textarea name="description" id="description" cols="30" rows="2" class="form-control"></textarea>
 </div>

 <div class="col-lg-6">
  <button type="submit" class="btn btn-primary btn-md w-100 rounded-5">Save</button>
 </div>


</form>
@endsection
