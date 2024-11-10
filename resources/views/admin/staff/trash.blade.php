@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))

@section('pageheader', 'Deleted Staff Members')
@section('pageheaderDescription', 'Manage Employee Information')

@section('pageheader-controls')
<a href="{{ route('staff') }}" class="px-2 py-1 rounded-4 font-12 border border-primary fw-bold text-primary">Employee</a>
<a href="{{ route('staff.trash') }}" class="px-2 py-1 rounded-4 font-12 border border-primary fw-bold text-danger">Empty Trash</a>
@endsection
    
@section('content')
<div class="row mt-4">

  <div class="col-lg-12">
    @include('dashboard.includes.alerts.restored')
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
                    <img src="{{ asset(($member->photo) ?? asset(config('defaults.avator'))) }}" class="mx1 rounded-circle border border-primary mb-1" alt="image" /> 
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
                    <a class="px-2 py-1 border-primary border rounded-4 font-12 bg-light" href="{{ route('staff.trash.restore', ['id' => $member->id]) }}">Restore</a>
                  </td>
                  
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
