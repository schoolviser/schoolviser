@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))

@section('pageheader', $role->name.' ~ '.$permissionGroup->name.' Permissions')

@section('pageheader-controls')
    <a href="{{ route('roles.permissions') }}">Back</a>
@endsection

@section('content')

<div class="row">

  <div class="col-lg-12 stretch-card grid-margin table-card"">
    <div class="card ">
      <div class="card-body">
        @if (count($permissionGroup->permissions) > 0)
          <form class="table-responsive" action="{{ route('roles.permissions.set.permissions', ['role_id' => $role->id, 'permission_group_id' => $permissionGroup->id]) }}" method="POST">
            @csrf
            <table class="table table-hover table-bordered table-striped">
              <thead>
                <th>SN</th>
                <th>Permission</th>
                <th class="text-center"><input class="form-check-input" type="checkbox" name="" id="checkAll"></th>
              </thead>
              <tbody>
                @foreach ($permissionGroup->permissions as $permission)
                    <tr>
                      <td>{{ $loop->index + 1 }}</td>
                      <td>
                        <label for="{{ 'check'.$permission->id }}" class="text-capitalize">{{ str_replace('_', ' ', $permission->name) }}</label><br />
                        <small class="text-muted">{{ $permission->description }}</small>
                      </td>
                      <td class="text-center">
                        <input id="{{ 'check'.$permission->id }}" class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" {{ (in_array($permission->name, $rolePermissionsArray) ? 'checked' : '') }}>
                      </td>
                    </tr>
                    
                @endforeach
                <tr>
                  <td colspan="2"></td>
                  <td class="text-center">
                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </form>
          <div class="">
          </div>
        @else
            
        @endif
      </div>
    </div>
  </div>


</div>

@endsection
