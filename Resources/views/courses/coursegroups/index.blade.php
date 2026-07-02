@extends(config('delxero.dashboard_layout', 'schoolviser::layouts.main_layout'))


@section('module-page-heading', 'Manage Courses')

@section('module-page-actions')
<a href="#" data-bs-toggle="offcanvas" data-bs-target="#addNewCourseGroupOffcanvas" class="btn btn-light page-link-btn btn-sm"><i class="bi bi-plus"></i> Course Group</a>
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

        <div class="table-responsive">
            <table class="table table-hover align-middle table-row-dashed table-row-gray-400 fs-6 gy-5" id="courseGroupTable">

                <thead>
                    <th> <input type="checkbox" class="form-check-input" id="selectAllCourseGroups" /></th>
                    <th>ID</th>
                    <th>Group Name</th>
                    <th>Course</th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach ($courseGroups as $group)
                    <tr>
                        <td><input type="checkbox" class="student-checkbox form-check-input" value="{{ $group->uuid }}"></td>
                        <td>{{ $group->id }}</td>
                        <td>{{ $group->name }}</td>
                        <td>{{ $group->course->name }}</td>
                        <td class="text-center">
                            <!-- Edit Button -->
                            <a href="" class="btn btn-sm btn-primary" data-bs-toggle="offcanvas" data-bs-target="{{ '#editCourseGroupOffcanvas'.$group->id }}"><i class="bi bi-pencil"></i></a>

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
                                    <form action="{{route('managecourses.coursegroups.update', $group->uuid)}}" method="POST" id="{{'editCourseGroupForm'.$group->id}}" class="row">
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
                            <a href="" class="btn btn-sm btn-danger" "><i class="bi bi-trash"></i></a>

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


<!-- Add New Course Group Offcanvas -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="addNewCourseGroupOffcanvas" aria-labelledby="addNewCourseGroupLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="addNewCourseGroupLabel">Add New Course Group</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form action="{{ route('managecourses.coursegroups.store') }}" method="POST" id="createCourseGroupForm" class="row">
            @csrf
            <div class="col-lg-12 mb-2">
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Group Name" required />
                <small class="text-danger error error-name">{{ $errors->first('name') }}</small>
            </div>
            <div class="col-lg-12 mb-2">
                <input type="text" name="short_code" placeholder="Group Short Code" value="{{ old('short_code') }}" class="form-control">
                <small class="text-danger error error-short-code">{{ $errors->first('short_code') }}</small>
            </div>
            <div class="col-lg-12 mb-2">
                <textarea name="description" cols="30" rows="4" class="form-control" placeholder="Description">{{ old('description') }}</textarea>
            </div>
            <div class="col-lg-12 mb-2">
                <input type="date" name="completes_on" class="form-control" value="{{ old('completes_on') }}">
                <small class="text-danger error error-completes-on">{{ $errors->first('completes_on') }}</small>
            </div>
            <div class="col-lg-12 mb-2">
                <select name="course_id" id="createCourseGroupForm" class="form-control">
                </select>
                <small class="text-danger error error-course-id">{{ $errors->first('course_id') }}</small>
            </div>
            <div class="col-lg-12 mb-2">
                <select name="term_id" class="form-control" id="createCourseGroupForm">
                    
                </select>
                <small class="text-danger error error-term-id">{{ $errors->first('term_id') }}</small>
            </div>
            <div class="col-lg-12">
                <button type="submit" class="w-100 btn btn-sm btn-success">Create</button>
            </div>
        </form>
    </div>
</div>


@endsection

@section('scripts')
<script>
$(document).ready(function () {
    // When the offcanvas is shown, fetch courses and terms
    $('#addNewCourseGroupOffcanvas').on('shown.bs.offcanvas', function () {
        // Fetch courses
       $.ajax({
            url: "{{ route('managecourses.allCoursesMinimal') }}",
            type: "GET",
            success: function (response) {
                let $courseSelect = $('#createCourseGroupForm select[name="course_id"]');
                $courseSelect.empty().append('<option value="">Select Course</option>');
                $.each(response.data, function (i, course) {
                    $courseSelect.append(
                        `<option value="${course.id}">${course.name}</option>`
                    );
                });
            },
            error: function (jqXHR, textStatus, errorThrown) {
                switch (jqXHR.status) {
                    case 404:
                        alert('Courses endpoint not found (404).');
                        break;
                    case 422:
                        // Laravel validation errors usually come back as 422
                        let errors = jqXHR.responseJSON?.errors;
                        if (errors) {
                            let messages = Object.values(errors).flat().join("\n");
                            alert("Validation failed:\n" + messages);
                        } else {
                            alert('Validation error (422).');
                        }
                        break;
                    case 500:
                        alert('Server error (500). Please try again later.');
                        break;
                    default:
                        alert('Request failed (' + jqXHR.status + '): ' + errorThrown);
                }
            }
        });


        // Fetch terms
        $.ajax({
            url: "{{ route('manageterms.currentYearTermsMinimal') }}", // adjust to your API route
            type: "GET",
            success: function (response) {
                let $termSelect = $('#createCourseGroupForm select[name="term_id"]');
                $termSelect.empty().append('<option value="">Select Term</option>');
                $.each(response.data, function (i, term) {
                    $termSelect.append(
                        `<option value="${term.id}">${term.name}</option>`
                    );
                });
            },
            error: function () {
                alert('Failed to load terms.');
            }
        });
    });
});
</script>
@endsection

