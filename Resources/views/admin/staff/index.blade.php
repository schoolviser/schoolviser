@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))

@section('pageheader', 'Employees')
@section('pageheaderDescription', 'Manage Employee Information')

@section('pageheader-controls')
<a href="{{ route('staff.positions') }}" class="px-2 py-1 rounded-4 font-12 border border-primary text-primary">Employee Positions</a>
<a href="{{ route('staff.trash') }}" class="px-2 py-1 rounded-4 font-12 border border-primary text-primary">Trash</a>
@endsection

@section('where-am-i')
<a href="{{route('dashboard')}}" class="font-10 bg-light py-1 px-2 rounded-4 my-1 fw-light text-dark">Dashboard</a>
<a href="" class="font-10 bg-light py-1 px-2 rounded-4 my-1 fw-bold">></a>
<a href="{{route('staff')}}" class="font-10 bg-light py-1 px-2 rounded-4 my-1">Staff</a>
@endsection
    
@section('content')
<div class="row mt-3">

  <div class="col-lg-12">
    @include('dashboard.includes.alerts.deleted')
  </div>

  <div class="col-12">
    @if (count($staff))
        <div class="table-responsive">
          <table class="table  table-hover table-bordered table-striped">
            <thead>
              <th>SN</th>
              <th>Names | Gender</th>
              <th>Position</th>
              <th>Phone</th>
              <th>Departmentst</th>
              <th></th>
            </thead>
            <tbody>
              @foreach ($staff as $member)
                <tr>
                  <td style="width: 5%;">{{ $loop->index + 1 }}</td>
                  <td>
                   
                    <img src="{{ asset($member->photo ?? config('defaults.avator')) }}" class="mx1 rounded-circle border border-primary mb-1" alt="image" /> 
                    <a href="{{ route('staff.show', ['id' => $member->id]) }}" style="text-decoration: none;" class="pl-5"><span class="ml-4 bg-light border border-light py-1 px-2 rounded-4">{{ $member->full_name }}</span></a>
                  </td>
                  <td>
                    <small class="border border-light px-2 py-1 bg-light font-12 rounded-4 {{ $member->position ?? 'd-none' }}">{{ ($member->position) ? $member->position->name : '' }}</small>
                  </td>
                  <td><small class="border border-light px-2 py-1bg-light font-12 rounded-4">{{ $member->primary_phone }}</small></td>
                  <td>
                    @if ($member->departments && count($member->departments))
                        @foreach ($member->departments as $department)
                            <small class="bg-light border border-light px-2 rounded-4 font-12">{{ $department->name }}</small><br />
                        @endforeach
                    @endif
                    
                  </td>
                  <td class="text-center">
                    <a class="px-2 py-1 border-primary border rounded-4 font-12" href="{{ route('staff.show', ['id' => $member->id]) }}">View Profile</a>
                    <a class="px-2 py-1 border-danger text-danger border rounded-4 font-12" href="{{ route('staff.destroy', ['id' => $member->id]) }}" data-bs-toggle="modal" data-bs-target="{{ '#deleteStaffConfirmationModal'.$member->id }}">Delete</a>
                  </td>
                  <!-- Confirm Staff Deletion Modal -->
                  <div id="{{ 'deleteStaffConfirmationModal'.$member->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog " role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title font-16 fw-bold" id="my-modal-title">Confirm Staff Deletion</h5>
                          <button class="close border border-primary rounded-4" data-bs-dismiss="modal" aria-label="Close">
                            close
                          </button>
                        </div>
                        <div class="modal-body">
                          <p>Are you sure, you want to delete <span class="px-2 py-1 border border-success bg-light rounded-4">{{ $member->full_name }}</span></p>
                        </div>
                        <div class="modal-footer">
                          <a href="" class="btn btn-danger btn-sm px-3 rounded-4 font-12">Delete Permanently</a>
                          <a href="{{ route('staff.destroy', ['id' => $member->id]) }}" class="btn btn-white btn-sm border border-danger font-12 rounded-4 px-3">Delete</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="pagination-links my-2">
          {{ $staff->links() }}
        </div>
    @else
        
    @endif   
  </div>
</div>
@endsection
