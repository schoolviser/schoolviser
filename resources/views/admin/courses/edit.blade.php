@extends(config('course.layout', 'course::layouts.master'))

@section('module-page-heading', 'Edit Course')

@section('module-links')
    <a href="{{ route('courses.create') }}" data-bs-toggle="offcanva" data-bs-target="#addNewProgramOffcanvas">Add New Course</a>
    <a href="{{ route('courses.import') }}" data-bs-toggle="offcanva" data-bs-target="#addNewProgramOffcanvas">Import Courses</a>
@endsection
    
@section('content')
<form action="{{route('courses.update', ['id' => $course->id])}}" method="POST" class="row" autocomplete="off">
 @csrf
 <div class="col-lg-4 my-1">
     <input type="text" class="form-control" name="name" placeholder="Course Name" value="{{ old('name') ?? $course->name }}" />
     <small class="text-danger">{{ $errors->first('name') }}</small>
 </div>
 <div class="col-lg-4 my-1">
 <input type="text" class="form-control" name="abbr" placeholder="Course Abbreviation" value="{{ old('abbr') ?? $course->abbr }}" />
 <small class="text-danger">{{ $errors->first('abbr') }}</small>
 </div>
 <div class="col-lg-4 my-1">
 @if (count($departments) > 0)
 <select name="department" id="" class="form-control"> 
     <option value="">Choose Department</option>
     @foreach ($departments as $department)
         <option value="{{$department->id}}" {{ ($course->department_id == $department->id) ? 'selected' : '' }}>{{$department->name}}</option>
     @endforeach
 </select>
 @endif
 </div>
 <div class="col-lg-12 my-1">
     <textarea name="description" id="" cols="30" rows="5" class="form-control" placeholder="Course Description"></textarea>
 </div>
 
 <div class="col-lg-12 mt-3">
     <button type="submit" class="btn btn-primary w-100 rounded-2">Update</button>
 </div>
</form>
@endSection