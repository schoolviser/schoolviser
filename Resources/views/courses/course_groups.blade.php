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

<div class="row">

    <div class="col-lg-8">
        <div class="card">
             <div class="card-header">
                
            </div>
            <div class="card-body">
                <div
                    class="table-responsive"
                >
                    <table class="table table-hover table-striped m-0" id="courseGroupTable">

                        <thead>
                            <th>ID</th>
                            <th>Group Name</th>
                            <th>Course</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @foreach ($courseGroups as $group)
                            <tr>
                                <td>{{ $group->id }}</td>
                                <td>{{ $group->name }}</td>
                                <td>{{ $group->course->name }}</td>
                                <td class="text-center">
                                    <!-- Edit Button -->
                                    <a href="" class="btn btn-sm btn-primary" data-bs-toggle="offcanvas" data-bs-target="{{ '#editCourseGroupOffcanvas'.$group->id }}"><i class="fa fa-edit"></i></a>

                                    <div
                                        class="offcanvas offcanvas-start"
                                        data-bs-scroll="true"
                                        tabindex="-1"
                                        id="{{ 'editCourseGroupOffcanvas'.$group->id }}"
                                        aria-labelledby="Enable both scrolling & backdrop"
                                    >
                                        <div class="offcanvas-header">
                                            <h5 class="offcanvas-title" id="Enable both scrolling & backdrop">
                                                Update Group Info
                                            </h5>
                                            <button
                                                type="button"
                                                class="btn-close"
                                                data-bs-dismiss="offcanvas"
                                                aria-label="Close"
                                            ></button>
                                        </div>
                                        <div class="offcanvas-body">
                                            <form action="{{route('site.settings.course.groups.update', ['id' => $group->id])}}" method="POST" id="{{'editCourseGroupForm'.$group->id}}" class="row">
                                                @csrf
                                                <div class="col-lg-12 mb-2">
                                                    <input type="text" name="name" class="form-control" value="{{ old('name') ?? $group->name }}" placeholder="Group Name" />
                                                    <small class="text-danger error error-name">{{ $errors->first('name') }}</small>
                                                </div>
                                                <div class="col-lg-12 mb-2">
                                                    <input type="text" name="short_code" placeholder="Group Short Code" value="{{ old('short_code') ?? $group->short_code }}" class="form-control">
                                                    <small class="text-danger error error-short-code text-start">{{ $errors->first('short_code') }}</small>
                                                </div>
                                                <div class="col-lg-12 mb-2">
                                                    <textarea name="description" id="" cols="30" rows="10" class="form-control"></textarea>
                                                </div>
                                                <div class="col-lg-12 mb-2">
                                                    <select name="course_id" id="" class="form-control">
                                                        @foreach ($courses as $course)
                                                            <option value="{{$course->id}}" {{ ($course->id == $group->course_id) ? 'selected' : '' }}>{{$course->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <small class="text-danger error error-course-id">{{ $errors->first('course_id') }}</small>
                                                </div>
                                                <div class="col-lg-12">
                                                    <button type="submit" class="w-100 btn btn-sm btn-primary">update</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>


                                    <!-- Delete Button -->
                                    <a href="{{route('site.settings.course.groups.destroy', ['id' => $group->id])}}" class="btn btn-sm btn-danger" "><i class="fa fa-trash"></i></a>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="card-footer">
                {{ $courseGroups->links() }}
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        @includeIf('admin.includes.settings.courses')
    </div>
</div>

@endsection
