@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))

@section('pageheader', 'User Roles')
    
@section('content')

<div class="row">
  <div class="col-lg-12">
    @if (session('deleted'))
       <div class="alert alert-danger border-danger alert-dismissable my-3 font-12" role="alert">
         <a class="btn-close px-4 font-14" data-bs-dismiss="alert" aria-label="Close">
           <span aria-hidden="true"></span>
         </a>
         <span class="mt-0">{{session('deleted')}}</span>
       </div>
   @endif
  </div>

@if (count($roles))
  <div class="col-xl-12 stretch-card grid-margin table-card">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover table-bordered table-striped">
            <thead>
              <th>SN</th>
              <th>Role</th>
              <th>Description</th>
                <th></th>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                <tr>
                  <td>{{ $loop->index + 1 }}</td>
                  <td>{{ $role->name }}</td>
                  <td>{{ $role->description }}</td>
                  <td>
                    <a href="{{ route('roles.destroy', ['id' => $role->id]) }}" class=" text-danger font-12 px-2">Delete</a>
                    <a href="" class="font-12 text-muted px-2">Edit</a>
                  </td>
                </tr>
                @endforeach
            </tbody>
          </table>
        </div>
        <div class="">
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-12 text-right">
  </div>
@else
  <div class="col-lf-12">
    <div class="card shadow-sm">
      <div class="card-body font-weight-light">
        <h3 class="font-weight-light py-3">There are no students registered for this term......</h3>
        <a href="" class="btn btn-link btn-fw">Last Term Students</a>
        <a href="" class="btn btn-link btn-fw">Add Student</a>
      </div>
    </div>
  </div>
@endif
  
</div>


@endsection
