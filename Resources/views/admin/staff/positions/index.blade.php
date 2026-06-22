@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))

@section('pageheader', 'Staff Positions')
@section('pageheaderDescription', 'Your Employee Positions')


@section('pageheader-controls')
<a href="{{ route('staff') }}" class="px-2 py-1 rounded-4 bg-light font-12 border border-primary fw-bold text-primary">Employees</a>
@endsection
@inject('employeeControlPermissions', '\App\EmployeeControlPermissionRegistrar')

    
@section('content')
<div class="row mt-4">
  <div class="col-lg-8">
    @if (count($positions))
            <div class="table-responsive">
              <table class="table  table-hover table-bordered table-striped">
                <thead>
                  <th>Position</th>
                  <th>Members</th>
                  <th></th>
                </thead>
                <tbody>
                  @foreach ($positions as $position)
                    <tr>
                      <td>{{ $position->name }}</td>
                      <td>{{ $position->members_count }}</td>
                      <td class="text-end">
                        @if (auth()->user()->hasPermissionViaSingleRole($employeeControlPermissions::CAN_UPDATE_EMPLOYEE_POSITIONS))
                            <a href="" class="btn btn-primary btn-sm px-3 rounded-4 font-12" data-bs-toggle="modal" data-bs-target="{{ '#editEmployeePositionModal'.$position->id }}">Edit</a>
                            <div id="{{ 'editEmployeePositionModal'.$position->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <form class="modal-content" action="{{ route('staff.positions.update', ['id' => $position->id]) }}" method="POST">
                                  @csrf
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="my-modal-title">Update Employee Position</h5>
                                    <button class="close" data-bs-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <input type="text" name="name" class="form-control" value="{{ old('name') ?? $position->name }}" placeholder="Position" />
                                    <small class="text-danger">{{ $errors->first('name') }}</small>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="submit" class="btn btn-md btn-primary">Save</button>
                                  </div>
                                </form>
                              </div>
                            </div>
                        @endif
                        @if (auth()->user()->hasPermissionViaSingleRole($employeeControlPermissions::CAN_DELETE_EMPLOYEE_POSITIONS))
                          <a href="{{ route('staff.positions.destroy', ['id' => $position->id]) }}" class="btn btn-danger btn-sm px-3 font-12 rounded-4">Delete</a>
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <div class="pagination-links my-2">
              {{ $positions->links() }}
            </div>
        @else
            
        @endif   
  </div>

  <!-- Create Employee Postion Form -->
  <div class="col-lg-4">
    <div class="card rounded-3">
      <div class="card-header">
        <h6 class="font-14 fw-bold mb-0">Create New Employee Position</h6>
      </div>
      <div class="card-body">
        <form class="modal-content" action="{{ route('staff.positions.store') }}" method="POST">
          @csrf
          
          <div class="">
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Position" />
            <small class="text-danger">{{ $errors->first('name') }}</small>
          </div>
          <div class=" my-2">
            <button type="submit" class="btn btn-md btn-primary w-100 rounded-4">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


@endsection
