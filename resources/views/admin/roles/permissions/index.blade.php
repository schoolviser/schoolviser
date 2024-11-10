@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))


@section('pageheader', 'Roles & Permission Groups')

@section('pageheaderDescription', 'Roles & Permission Groups')

@section('pageheader-controls')
<a class="font-12 font-weight-bold"  href="{{ route('roles') }}">Roles</a>

  <div class="d-inline px-2">|</div>
  <a class="font-12 font-weight-bold" data-bs-toggle="modal" data-bs-target="#createRole" href="{{ route('users.create') }}">Create Role</a>
@endsection



@section('content')

<div class="row">

  <div class="col-lg-12">
    @if (session('deleted'))
        <div class="alert alert-warning alert-dismissable" role="alert">
          <a class="btn-close px-4 font-14" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"></span>
          </a>
          <span class="mt-0">{{session('deleted')}}</span>
        </div>
    @endif
  </div>
  <div class="col-lg-12">
    @if (session('created'))
        <div class="alert alert-success alert-dismissable" role="alert">
          <a class="btn-close px-4 font-14" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"></span>
          </a>
          <span class="mt-0">{{session('created')}}</span>
        </div>
    @endif
  </div>

  <div class="col-lg-12"">
    <div class="table-responsive">
      <table class="table table-hover table-bordered">
        <thead>
          <th>SN</th>
          <th>Role</th>
          <th>Permission Groups</th>
          <th>Action</th>
        </thead>
        <tbody>
            @foreach ($roles as $role)
            <tr>
              <td>{{ $loop->index + 1 }}</td>
              <td class="text-capitalize">{{ $role->name }}</td>
              <td class="text-capitalize w-25 ">
                @if (count($permissionGroup) > 0)
                    @foreach ($permissionGroup as $group)
                    <a href="{{ route('roles.permissions.show', ['role_id' => $role->id, 'permission_group_id'=> $group->id]) }}" class="rounded-2 bg-light text-small p-2">{{ $group->name }}</a><br /><br />
                    @endforeach
                @else
                    {{ 'No permission groups defined' }}
                @endif
              </td>
              <td class="text-capitalize">
                <a href="{{ route('roles.edit', ['id' => $role->id]) }}" class="link text-muted">edit</a>
                <a href="{{ route('roles.destroy', ['id' => $role->id]) }}" class="text-danger font-12 link">delete</a>
              </td>
            </tr>
            
            @endforeach
        </tbody>
      </table>
    </div>
    <div class="">
    </div>
  </div>


  <!-- Create Role MOdal -->
  <div id="createRole" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form class="modal-content" method="POST" action="{{ route('roles.store') }}">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="my-modal-title">Create Role</h5>
          <button class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body row">
          <div class="col-lg-12">
            <input type="text" name="name" class="form-control" placeholder="Role" />
            <small class="text-danger">{{ $errors->first('name') }}</small>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-md btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection
