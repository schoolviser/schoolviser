@extends(config('course.layout', 'course::layouts.master'))

@section('module-page-heading', 'Import Courses')

@section('module-links')
    <a href="{{ route('courses.create') }}" data-bs-toggle="offcanva" data-bs-target="#addNewProgramOffcanvas">Add New Course</a>
    <a href="{{ route('courses.import') }}" data-bs-toggle="offcanva" data-bs-target="#addNewProgramOffcanvas">Import Courses</a>
@endsection
    
@section('content')
@if(session('created'))
        <div style="color: green;">{{ session('created') }}</div>
    @endif

    @if(session('error'))
        <div style="color: red;">{{ session('error') }}</div>
    @endif


    <form action="{{ route('courses.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" required>
        <button type="submit">Import</button>
    </form>

    
@endSection