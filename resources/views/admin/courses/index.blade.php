@extends(config('course.layout', 'course::layouts.master'))

@section('module-page-heading', 'Courses | Academic Programes')

@section('module-links')
    <a href="{{ route('courses.create') }}" data-bs-toggle="offcanva" data-bs-target="#addNewProgramOffcanvas">Add New Course</a>
    <a href="{{ route('courses.import') }}" data-bs-toggle="offcanva" data-bs-target="#addNewProgramOffcanvas">Import Courses</a>
@endsection
    
@section('content')
    <section>
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table
                        class="table table-bordered table-striped"
                    >
                        <thead>
                            <th>SN</th>
                            <th>Course Name</th>
                            <th>Abbr</th>
                            <th>Department</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($courses as $course)
                            <tr class="">
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $course->name }}</td>
                                <td>{{ $course->abbr }}</td>
                                <td>{{ ($course->department) ? $course->department->name : '' }}</td>
                                <td>
                                    <a href="{{ route('courses.destroy', ['id' => $course->id]) }}" class="btn btn-sm btn-danger"><i class="{{ (config('course.font') == 'font-awesome') ? 'fa fa-trash' : '' }}"></i></a>
                                    <a href="{{ route('courses.edit', ['id' => $course->id]) }}" class="btn btn-sm btn-primary" ><i class="{{ (config('course.font') == 'font-awesome') ? 'fa fa-edit' : '' }}"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
    </section>

    <div
        class="offcanvas offcanvas-start rounded-end-2"
        data-bs-backdrop="static"
        tabindex="-1"
        id="addNewProgramOffcanvas"
        aria-labelledby="staticBackdropLabel"
    >
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="staticBackdropLabel">
                Add New Course
            </h5>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="offcanvas"
                aria-label="Close"
            ></button>
        </div>
        <div class="offcanvas-body">
            <form action="{{route('courses.store')}}" method="POST" class="row" autocomplete="off">
                @csrf
                <div class="col-lg-12 my-1">
                    <input type="text" class="form-control" name="name" placeholder="Course Name" />
                    <small class="text-danger">{{ $errors->first('name') }}</small>
                </div>
                <div class="col-lg-12 my-1">
                    <textarea name="description" id="" cols="30" rows="5" class="form-control" placeholder="Course Description"></textarea>
                </div>
                <div class="col-lg-12 my-1">
                    @if (count($departments) > 0)
                    <select name="department" id="" class="form-control">
                        <option value="">Choose Department</option>
                        @foreach ($departments as $department)
                            <option value="{{$department->id}}">{{$department->name}}</option>
                        @endforeach
                    </select>
                    @endif
                </div>
                <div class="col-lg-12 mt-3">
                    <button type="submit" class="btn btn-primary w-100 rounded-2">Save</button>
                </div>
            </form>
        </div>
    </div>
    
@endsection
