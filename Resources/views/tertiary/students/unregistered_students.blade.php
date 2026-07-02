@extends(config('delxero.dashboard_layout', 'schoolviser::layouts.main_layout'))

@section('title', 'Un registered Students Information')
@section('module-page-heading', 'Un registered Students Information')

@section('hello')
    @php
        $term = term();
    @endphp
    {{ $term->academicYear?->name.' '.$term->name }}
@endsection

@section('module-page-actions')
<a href="{{route('tertiary.students.create')}}" class="btn btn-sm btn-light">Add Student</a>

@endsection

@section('module-breadcrumbs')
<x-ui.breadcrumb :items="[
    [
        'label' => 'Manage Students',
        'url' => route('tertiary.students.index')
    ],
    [
        'label' => 'Students Information',
        'url' => route('tertiary.students.index')
    ],
    [
        'label' => 'Unregisered Students',
        'url' => route('tertiary.students.index')
    ]
    
]" />
@endsection

@section('content')

<x-alert-success />
<x-alert-errors />
<x-alert-warning />

<div class="card">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table align-middle table-row-dashed table-hover table-row-gray-400 gy-5">
        <thead>
          <tr>
            <th>
              <input type="checkbox" id="selectAllStudents" />
            </th>
            <th>Personal Details</th>
            <th>Academic Info.</th>
            <th>Previous Registration</th>
            <th></th>
          </tr>
        </thead>
        <tbody class="fs-6 fw-semibold text-gray-600">
          @foreach ($students as $student)
              <tr>
                <td>
                  <input type="checkbox" class="student-checkbox" value="{{ $student->uuid }}">
                </td>
                <td class="text-capitalize">
                  <span><b>Full Names: </b> <a href="{{ route('tertiary.students.show', ['id' => $student->uuid]) }}">{{ $student->first_name.' '.$student->last_name }}</a></span><br />
                  <span><b>Gender: </b>{{ $student->gender }}</span><br />
                  <span><b>Nationality: </b>{{ $student->nationality }}</span><br />
                  <span><b>Nin: </b>{{ $student->nin }}</span><br />
                </td>
                <td class="text-capitalize">
                  <span><b>Reg No: </b>{{ $student->regno }}</span><br />
                  <span><b>Access Number: </b>{{ $student->access_number }}</span><br />
                  <span><b>Course: </b>{{ optional($student->course)->name }}</span><br />
                  <span><b>Set: </b>{{ optional($student->courseGroup)->name }}</span><br />
                </td>
                <td class="text-capitalize">
                  @foreach ($student->intakeRegistrations as $registration)
                    <div class="bg-light p-1">
                      <span>
                        <b>Intake: </b>
                        {{ $registration?->term?->term ? termLabel($registration?->term?->term) : 'No term label' }}
                        {{ $registration?->term?->academicYear?->name }}
                      </span><br />
                      <span><b>Residence: </b>{{ $registration->residence }}</span><br />
                      <span><b>Entry: </b>{{ $registration->new_or_continuing }}</span><br />
                      <span><b>Semester: </b>{{ $registration->semester }}</span><br />
                      <span><b>Year: </b>{{ $registration->year }}</span><br />
                    </div>
                  @endforeach
                </td>
                <td>
                  <!-- existing single enroll button -->
                  <a class="btn btn-success btn-sm" data-bs-toggle="offcanvas" data-bs-target="{{ '#enrollStudent'.$student->uuid }}">
                    Enroll
                  </a>
                  <div class="offcanvas offcanvas-start" tabindex="-1" id="{{ 'enrollStudent'.$student->uuid }}">
                    <div class="offcanvas-header">
                      <h5 class="offcanvas-title">Register</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                    </div>
                    <div class="offcanvas-body">
                      <form method="POST" action="{{ route('tertiary.students.enroll', $student->id) }}">
                        @csrf
                        @php $terms = active_terms(); @endphp
                        <div class="mb-3">
                          <label>Intake</label>
                          <select name="term_id" class="form-control">
                            @foreach ($terms as $term)
                              <option value="{{ $term->id }}">{{ termLabel($term->term).' '.$term?->academicYear?->name }}</option>
                            @endforeach
                          </select>
                        </div>

                        <div class="mb-3">
                          <label>Semester</label>
                          <select name="semester" class="form-control">
                            <option value="1">Semester 1</option>
                            <option value="2">Semester 2</option>
                          </select>
                        </div>

                        <div class="mb-3">
                          <label>Year</label>
                          <select name="year" class="form-control">
                            <option value="1">Year 1</option>
                            <option value="2">Year 2</option>
                            <option value="3">Year 3</option>
                            <option value="4">Year 4</option>
                            <option value="5">Year 5</option>
                          </select>
                        </div>

                        <div class="mb-3">
                          <label>New Or Continuing</label>
                          <select name="new_or_continuing" class="form-control">
                            <option value="new">New</option>
                            <option value="continuing" selected>Continuing</option>
                          </select>
                        </div>

                        <button class="btn btn-success w-100">Enroll Student</button>
                      </form>
                    </div>
                  </div>

                </td>
              </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="card-footer d-flex justify-content-between">
      {{ $students->links() }}
      <button class="btn btn-dark btn-sm" data-bs-toggle="offcanvas" data-bs-target="#bulkEnrollOffcanvas">
        Bulk Enroll Selected
      </button>
    </div>
  </div>
</div>

<div class="offcanvas offcanvas-start" tabindex="-1" id="bulkEnrollOffcanvas">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title">Bulk Enroll Students</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body">
    <form id="bulkEnrollForm" method="POST" action="{{ route('tertiary.students.bulkEnroll') }}">
      @csrf
      <input type="hidden" name="student_ids" id="bulkStudentIds">

      @php $terms = active_terms(); @endphp
      <div class="mb-3">
        <label>Intake</label>
        <select name="term_id" class="form-control">
          @foreach ($terms as $term)
            <option value="{{ $term->id }}">{{ termLabel($term->term).' '.$term?->academicYear?->name }}</option>
          @endforeach
        </select>
      </div>

      <div class="mb-3">
        <label>Semester</label>
        <select name="semester" class="form-control">
          <option value="1">Semester 1</option>
          <option value="2">Semester 2</option>
        </select>
      </div>

      <div class="mb-3">
        <label>Year</label>
        <select name="year" class="form-control">
          <option value="1">Year 1</option>
          <option value="2">Year 2</option>
          <option value="3">Year 3</option>
          <option value="4">Year 4</option>
          <option value="5">Year 5</option>
        </select>
      </div>

      <div class="mb-3">
        <label>New Or Continuing</label>
        <select name="new_or_continuing" class="form-control">
          <option value="new">New</option>
          <option value="continuing" selected>Continuing</option>
        </select>
      </div>

      <button class="btn btn-success w-100">Enroll Selected Students</button>
    </form>
  </div>
</div>


@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Select/Deselect all
    $('#selectAllStudents').on('change', function() {
        $('.student-checkbox').prop('checked', $(this).prop('checked'));
    });

    // Before opening bulk enroll, collect selected IDs
    $('#bulkEnrollOffcanvas').on('show.bs.offcanvas', function () {
        let selected = [];
        $('.student-checkbox:checked').each(function() {
            selected.push($(this).val());
        });
        $('#bulkStudentIds').val(selected.join(','));
    });

    // Optional: prevent submit if no students selected
    $('#bulkEnrollForm').on('submit', function(e) {
        if ($('#bulkStudentIds').val() === '') {
            e.preventDefault();
            alert('Please select at least one student to enroll.');
        }
    });
});
</script>
@endsection
