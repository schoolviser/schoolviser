@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))


@section('pageheader', 'User Accounts')
@section('pageheaderDescription', 'Manage system users')


@section('pageheader-controls')
<a href="{{ route('roles.permissions') }}" class="px-2 py-1 rounded-4  font-12 border border-primary text-primary">Roles Permissions</a>
<a href="{{ route('assets.import') }}" class="px-2 py-1 rounded-4  font-12 border border-primary text-primary">Import Assets</a>
<a href="{{ route('users.recently.active') }}" class="px-2 py-1 rounded-4  font-12 border border-primary text-primary">Recently Active</a>
@endsection

@section('where-am-i')
<a href="{{route('dashboard')}}" class="font-10 py-1 px-2 rounded-4 my-1 fw-light text-dark">Dashboard</a>
<a href="" class="font-10 py-1 px-2 rounded-4 my-1 fw-bold">></a>
<a href="{{route('users')}}" class="font-10 py-1 px-2 rounded-4 my-1">Users</a>
@endsection
    
@section('content')

<div class="row mt-4">

@if (count($users))
  <div class="col-xl-12 col-lg-12">
    <div class="table-responsive">
      <table class="table table-hover table-bordered table-striped">
        <thead>
          <th>SN</th>
          <th>Names</th>
          <th>Username</th>
          <th>Email</th>
          <th>Role</th>
          <th>User Type</th>
          <th>Last Seen</th>
          <th>Action</th>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
              <td>{{ $loop->index + 1 }}</td>
              <td>{{ ($user->usertype) ? $user->usertype->first_name.' '.$user->usertype->last_name : 'Ghost Account' }}</td>
              <td>
                <a href="{{ route('users.show', ['id' => $user->id]) }}">{{ $user->name }}</a>
              </td>
              <td>{{ $user->email }}</td>
              <td class="text-capitalize">{{ ($user->role) ? $user->role->name : 'No Role Assigned ' }}</td>
              <td>{{ ($user->user_type) ? array_last(explode('\\', $user->user_type)) : 'hello' }}</td>
              <td>{{ ($user->last_seen_at) ? \Carbon\Carbon::parse($user->last_seen_at)->diffForHumans() : 'No recent activity' }}</td>
              
              <td>
                <a href="{{ route('users.destroy', ['id' => $user->id]) }}" data-bs-toggle="modal" data-bs-target="{{'#confirmUserDeletionModal'.$user->id }}" class="btn btn-sm btn-danger"><i class="mdi mdi-delete"></i></a>
              </td>
            </tr>

            <!-- Confirm User Account Deletion -->
            <div
              class="modal fade"
              id="{{ 'confirmUserDeletionModal'.$user->id }}"
              tabindex="-1"
              role="dialog"
              aria-labelledby="modalTitleId"
              aria-hidden="true"
            >
              <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                      Confirm User Account Deletion
                    </h5>
                    <button
                      type="button"
                      class="btn-close"
                      data-bs-dismiss="modal"
                      aria-label="Close"
                    ></button>
                  </div>
                  <div class="modal-body">
                    <div class="container-fluid">
                      Are you sure you want to delete {{ $user->name }}
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button
                      type="button"
                      class="btn btn-secondary"
                      data-bs-dismiss="modal"
                    >
                      Close
                    </button>
                    <a href="{{ route('users.destroy', ['id' => $user->id]) }}" class="btn btn-danger">Yes, Continue</a>
                  </div>
                </div>
              </div>
            </div>
            
            
            @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <div class="col-lg-12 text-right">
  </div>
@else
  <div class="col-lf-12 my-5">
    <div class="alert alert-primary" role="alert">
      <strong>You do not have any users</strong> <a class="px-3" href="{{ route('users.create') }}">Click Here</a> to add employee user accounts
    </div>
  </div>
@endif
  
</div>

<!-- Create User Model -->
<div id="createUserModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <form class="modal-content" class="create-user-form" id="createUserForm" data-action="{{ route('users.store') }}" data-url="{{ route('users.store') }}" method="POST">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title font-16" id="my-modal-title">Add User</h5>
        <button class="close d-none" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body row">

        <div class="col-lg-12">
          <label for="name" class="font-12 pb-1">Username</label>
          <input type="text" name="name" placeholder="Username" class="form-control name" />
          <small class="text-danger error error-name" data-error="name">{{ $errors->first('name') }}</small>
        </div>

        <div class="col-lg-12">
          <label for="email" class="font-12 pb-1">Email Address</label>
          <input type="text" name="email" placeholder="Email Address" class="form-control name" />
          <small class="text-danger error error-email" data-error="email">{{ $errors->first('email') }}</small>
        </div>

        <div class="col-lg-12">
          <label for="usertype" class="font-12">User Type</label>
          <select name="usertype" id="usertype" class="form-control">
            <option value="employee" selected>Employee</option>
          </select>
          <small class="text-danger error error-usertype" data-error="usertype">{{ $errors->first('usertype') }}</small>
        </div>

        <div class="col-lg-12">
          <label for="user" class="font-12">User</label>
          <select name="user_id" id="userId" class="form-control">
            <option value="">users here</option>
          </select>
        </div>

        <div class="col-lg-6">
          <label for="password" class="font-12 pb-1">Password</label>
          <input type="password" name="password" placeholder="Password" class="form-control password" value="{{ old('password') }}" />
          <small class="text-danger error error-password font-12" data-error="email">{{ $errors->first('password') }}</small>
        </div>
        
        <div class="col-lg-6">
          <label for="password" class="font-12 pb-1">Confirm Password</label>
          <input type="password" name="password_confirmation" placeholder="Confirm Password" class="form-control password-confirmation" />
          <small class="text-danger error error-password-confirmation font-12" data-error="email">{{ $errors->first('password_confirmation') }}</small>
        </div>

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-md btn-primary font-12">Create</button>
      </div>
    </form>
  </div>
</div>


@endsection
