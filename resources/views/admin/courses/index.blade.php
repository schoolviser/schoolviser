@extends(config('schoolviser.admin_layout'))

@section('module-page-heading', 'Courses | Academic Programes')

@section('module-links')
    <a href="{{ route('site.settings.courses.create') }}" data-bs-toggle="offcanvas" data-bs-target="#addNewProgramOffcanvas" class="btn btn-primary btn-sm rounded-5">Add New Course</a>
@endsection

@section('content')
<section>
    <div class="row">
        <div class="col-lg-12">
            @if (session('created'))
            <div
                class="alert alert-success alert-dismissible fade show"
                role="alert"
            >
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close"
                ></button>

                <strong>Success</strong> {{ session('created') }}
            </div>

            @endif

             @if (session('updated'))
            <div
                class="alert alert-success alert-dismissible fade show"
                role="alert"
            >
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close"
                ></button>

                <strong>Success</strong> {{ session('updated') }}
            </div>

            @endif
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-12 text-uppercase">
                            <small class="mb-0 p-0 fw-bold">{{ 'Course Settings' }}</small>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">

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
                                        <a href="{{ route('site.settings.courses.destroy', ['id' => $course->id]) }}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                        <a href="{{ route('site.settings.courses.edit', ['id' => $course->id]) }}" data-bs-toggle="offcanvas"  data-bs-target="{{ '#updateCourseOffcanvas'.$course->id }}" class="btn btn-sm btn-primary" ><i class="fa fa-edit"></i></a>
                                        <div
                                            class="offcanvas offcanvas-start"
                                            data-bs-scroll="true"
                                            tabindex="-1"
                                            id="{{ 'updateCourseOffcanvas'.$course->id }}"
                                            aria-labelledby="Enable both scrolling & backdrop"
                                        >
                                            <div class="offcanvas-header">
                                                <h5 class="offcanvas-title" id="Enable both scrolling & backdrop">
                                                    Update Course Details
                                                </h5>
                                                <button
                                                    type="button"
                                                    class="btn-close"
                                                    data-bs-dismiss="offcanvas"
                                                    aria-label="Close"
                                                ></button>
                                            </div>
                                            <div class="offcanvas-body">
                                                 <form action="{{route('site.settings.courses.update', ['id' => $course->id])}}" method="POST" class="row" autocomplete="off">
                                                    @csrf
                                                    <div class="col-lg-12 my-1">
                                                        <input type="text" class="form-control" name="name" value="{{ $course->name }}" placeholder="Course Name" />
                                                        <small class="text-danger">{{ $errors->first('name') }}</small>
                                                    </div>
                                                    <div class="col-lg-6 my-1">
                                                        <input type="text" class="form-control" name="short_name" value="{{ $course->abbr }}" placeholder="Short Name" />
                                                        <small class="text-danger">{{ $errors->first('short_name') }}</small>
                                                    </div>
                                                    <div class="col-lg-6 my-1">
                                                        <input type="text" class="form-control" name="duration" value="{{ $course->duration }}" placeholder="Duration" />
                                                        <small class="text-danger">{{ $errors->first('duration') }}</small>
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
                                                        <button type="submit" class="btn btn-primary w-100 rounded-2">update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {{ $courses->links() }}
                </div>
            </div>


        </div>
    </div>
</section>

    <div class="offcanvas offcanvas-end rounded-start-2" data-bs-backdrop="static"  tabindex="-1" id="addNewProgramOffcanvas"  aria-labelledby="staticBackdropLabel">

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
            <form action="{{route('site.settings.courses.store')}}" method="POST" class="row" autocomplete="off">
                @csrf
                <div class="col-lg-12 my-1">
                    <input type="text" class="form-control" name="name" placeholder="Course Name" />
                    <small class="text-danger">{{ $errors->first('name') }}</small>
                </div>
                <div class="col-lg-6 my-1">
                    <input type="text" class="form-control" name="short_name" placeholder="Short Name" />
                    <small class="text-danger">{{ $errors->first('short_name') }}</small>
                </div>
                <div class="col-lg-6 my-1">
                    <input type="text" class="form-control" name="duration" placeholder="Duration" />
                    <small class="text-danger">{{ $errors->first('duration') }}</small>
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
