
@extends(config('delxero.dashboard_layout', 'schoolviser::layouts.main_layout'))


@section('module-page-heading', 'Manage Courses')

@section('module-page-actions')
<a href="{{ route('managecourses.create') }}" data-bs-toggle="offcanvas" data-bs-target="#addNewProgramOffcanvas" class="btn btn-light page-link-btn btn-sm">Add New Course</a>
<x-dropdown 
  buttonLabel="Other Settings" icon="bi-gear"
  :items="[
      [
          'label' => 'Term Translations',
          'url' => route('term.translations.index', 'en'),
          'id' => 'term-translation-link',
          'class' => 'text-primary',
          'data' => ['action' => 'open-term', 'locale' => 'en']
      ],
      [
          'label' => 'Manage Academic Years',
          'url' => route('manageacademicyears.index'),
      ],
      [
          'label' => 'Manage Classes',
          'url' => route('manageclazzs.index'),
      ]
  ]"
/>
@endsection

@section('module-breadcrumbs')
<x-ui.breadcrumb :items="[
    [
        'label' => 'Settings',
    ],
    [
        'label' => 'Manage Courses',
    ]
    
]" />
@endsection

@section('module-page-links')
@endsection

@section('content')
<x-alert-success />
<x-alert-errors />

<div class="card">
    <div class="card-body">
        <table class="table table-hover align-middle table-row-dashed fs-6 gy-5">
            <thead>
                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                    <th>SN</th>
                    <th>Course Name</th>
                    <th>Abbr</th>
                    <th>Department</th>
                    <th></th>
                </tr>
                
            </thead>
            <tbody>
                @foreach ($courses as $course)
                <tr class="">
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $course->name }}</td>
                    <td>{{ $course->abbr }}</td>
                    <td>{{ ($course->department) ? $course->department->name : '' }}</td>
                    <td>
                        <a href="{{ route('managecourses.destroy', ['id' => $course->id]) }}" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></a>
                        <a href="{{ route('managecourses.edit', ['id' => $course->id]) }}" data-bs-toggle="offcanvas"  data-bs-target="{{ '#updateCourseOffcanvas'.$course->id }}" class="btn btn-sm btn-primary" ><i class="bi bi-pencil"></i></a>
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
                                    <form action="{{route('managecourses.update', ['id' => $course->id])}}" method="POST" class="row" autocomplete="off">
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
    <div class="card-footer">
        {{ $courses->links('pagination::bootstrap-5') }}
    </div>
</div>

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
        <form action="{{route('managecourses.store')}}" method="POST" class="row" autocomplete="off">
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
