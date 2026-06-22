@extends(config('course.layout', 'course::layouts.master'))

@section('module-page-heading', 'Add Course')

@section('module-links')
    <a href="{{ route('courses.create') }}" data-bs-toggle="offcanva" data-bs-target="#addNewProgramOffcanvas">Add New Course</a>
@endsection
    
@section('content')

<form action="{{route('courses.store')}}" method="POST" class="row" autocomplete="off">
    @csrf
    <div class="col-lg-4 my-1">
        <input type="text" class="form-control" name="name" placeholder="Course Name" />
        <small class="text-danger">{{ $errors->first('name') }}</small>
    </div>
    <div class="col-lg-4 my-1">
    <input type="text" class="form-control" name="abbr" placeholder="Course Abbreviation" />
    <small class="text-danger">{{ $errors->first('abbr') }}</small>
    </div>
    <div class="col-lg-4 my-1">
    @if (count($departments) > 0)
    <select name="department" id="" class="form-control"> 
        <option value="">Choose Department</option>
        @foreach ($departments as $department)
            <option value="{{$department->id}}">{{$department->name}}</option>
        @endforeach
    </select>
    @endif
    </div>
    <div class="col-lg-12 my-1">
        <textarea name="description" id="" cols="30" rows="5" class="form-control" placeholder="Course Description"></textarea>
    </div>
    
    <div class="col-lg-12 mt-3">
        <button type="submit" class="btn btn-primary w-100 rounded-2">Save</button>
    </div>
</form>
@endsection
