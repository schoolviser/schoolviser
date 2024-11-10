@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))

@section('pageheader', 'Departments')


@section('pageheader-controls')
<a href="" class="px-2 py-1 rounded-4 font-12 border border-primary text-primary" data-bs-toggle="modal" data-bs-target="#createDepartmentModal">Add Department</a>

@endsection
    
@section('content')
<div class="row">
  <div class="col-12">
    @if (count($departments))
            <div class="table-responsive">
              <table class="table  table-hover table-bordered table-striped">
                <thead>
                  <th>Name</th>
                  <th class="text-center">Members</th>
                  <th>Head Of Department</th>
                  <th></th>
                </thead>
                <tbody>
                  @foreach ($departments as $department)
                    <tr>
                      <td>{{ $department->name }}</td>
                      <td class="text-center">{{ $department->employees_count }}</td>
                      <td>Next Version</td>
                      <td class="">
                        <a href="" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="{{ '#editDepartmentModal'.$department->id }}"><i class="mdi mdi-pencil"></i></a>
                        <div id="{{ 'editDepartmentModal'.$department->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                          <form class="modal-dialog" role="document" action="{{ route('departments.update', ['id' => $department->id]) }}" method="POST">
                            @csrf
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="my-modal-title">Update Department </h5>
                                <button class="close" data-bs-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <label for="name" class="text-small text-muted">Department Name</label>
                                <input type="text" name="name" placeholder="Department Name" class="form-control" value="{{ old('name') ?? $department->name }}" />
                              </div>
                              <div class="modal-footer">
                                <button type="submit" class="btn btn-primary btn-sm">Update</button>
                              </div>
                            </div>
                          </form>
                        </div>
                        <a href="{{ route('departments.destroy', ['id' => $department->id]) }}" class="btn btn-sm btn-danger"><i class="mdi mdi-delete"></i></a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            
        @endif   
  </div>
</div>


<div id="createDepartmentModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <form class="modal-dialog" role="document" action="{{ route('departments.store') }}" method="POST">
    @csrf
    <div class="modal-content">
      <div class="modal-header">Create Department</h5>
        <button class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <label for="name">Department Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Department">
        <small class="text-danger">{{ $errors->first('name') }}</small>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-md">Save</button>
      </div>
    </div>
  </form>
</div>
@endsection
