@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))

@section('pageheader', 'Students Trash')
    
@section('content')

<div class="row">

@if (count($students))
  <div class="col-xl-12 stretch-card table-card">
    <div class="table-responsive">
      <table class="table table-hover table-striped text-dark custom-table">
        <thead>
            <th>Reg No</th>
            <th>Name</th>
            <th>Class</th>
            <th>Section</th>
            <th>Gender</th>
            <th></th>
        </thead>
        <tbody>
            @foreach ($students as $student)
            <tr class="font-weight-bold">
              <td><small>{{ $student->regno ?? $student->id }}</small></td>
              <td>
                <img src="{{ asset(($student->photo) ?? asset(config('defaults.avator'))) }}" class="mx-1" alt="image" /> 
                <a href="{{ route('students.profile', ['id' => $student->id]) }}"  style="text-decoration: none;" class="pl-5"><span class="ml-4">{{ $student->fullname }}</span></a> 
              </td>
              <td><small class="font-weight-bold text-capitalize">{{ ($student->currentTermlyRegistration) ? $student->currentTermlyRegistration->clazz->abbr : '' }}</small></td>
              <td><small class="text-capitalize">{{ $student->currentTermlyRegistration->residence }}</small></td>
              <td><small class="text-capitalize">{{ $student->gender }}</small></td>
              <td >
                <a href="{{ route('students.trash.restore', ['id' => $student->id]) }}" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="{{ '#confirmStudentRestore'.$student->id }}" style="font-size:10px;">Restore</a>
                <a href="{{ route('students.delete.permanently', ['id' => $student->id]) }}" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="{{ '#confirmStudentPermanentDelete'.$student->id }}" style="font-size:10px;">Delete Permanently</a>


                <div id="{{ 'confirmStudentRestore'.$student->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="my-modal-title">Confirm Student Restoration</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <p>Are your sure you want to restore {{ $student->surname }}</p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          <a href="{{ route('students.trash.restore', ['id' => $student->id]) }}" class="btn btn-primary">Yes, Continue</a>
                      </div>
                    </div>
                  </div>
                </div>

                <div id="{{ 'confirmStudentPermanentDelete'.$student->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="my-modal-title">Confirm Student Deletion</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <p>Are your sure you want to permanently delete {{ $student->fullname }}</p>
                        <p>This action can not be undone....</p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          <a href="{{ route('students.delete.permanently', ['id' => $student->id]) }}" class="btn btn-primary">Yes, Continue</a>
                      </div>
                    </div>
                  </div>
                </div>

              </td>
            </tr>
            @endforeach
        </tbody>
      </table>
    </div>
  </div>
@else
<div class="col-lg-12 text-center p-0">
  <i class="mdi mdi-cloud-outline" style="font-size: 50px;"></i><br />
  <h6>There is no data ....!</h6>
</div>
@endif
  
</div>


@endsection
