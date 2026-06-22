@extends(setting('dashboard_view_layout', auth()->user(), config('schoolviser.dashboard_view_layout', 'dashboard.layouts.horizontal')))


@section('pageheader', 'Add User')
@section('pageheaderDescription', 'Manage user accounts')

@section('pageheader-controls')

@endsection
    
@section('content')

<div class="row">

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


  <div class="col-lg-6">
    <div class="card rounded-3">
      <form class="card-body row py-4" method="POST" action="{{ route('users.store') }}">
        @csrf

        <div class="col-lg-6">
          <label for="name" class="font-12 pb-1">Username</label>
          <input type="text" name="name" placeholder="Username" class="form-control name" value="{{ old('name') }}" />
          <small class="text-danger error error-name font-12" data-error="name">{{ $errors->first('name') }}</small>
        </div>

        <div class="col-lg-6">
          <label for="email" class="font-12 pb-1">Email Address</label>
          <input type="text" name="email" placeholder="Email Address" class="form-control name" value="{{ old('email') }}" />
          <small class="text-danger error error-email font-12" data-error="email">{{ $errors->first('email') }}</small>
        </div>

        <div class="col-lg-6">
          <label for="usertype" class="font-12">User Type</label>
          <select name="usertype" id="usertype" class="form-control">
            <option value="employee" selected>Employee</option>
          </select>
          <small class="text-danger error error-usertype font-12" data-error="usertype">{{ $errors->first('usertype') }}</small>
        </div>

        <div class="col-lg-6">
          <label for="user" class="font-12">User (Employee)</label>
          <select name="user_id" id="userId" class="form-control">
            <option value="">Choose Employee</option>
          @foreach ($employees as $employee)
            <option value="{{ $employee->id }}">{{ $employee->first_name.' '.$employee->last_name }}</option>
          @endforeach
          <small class="text-danger error error-usertype font-12" data-error="usertype">{{ $errors->first('user_id') }}</small>
          </select>
        </div>

        <div class="col-lg-12 mb-2">
          <label for="role" class="font-12 text-muted">Role</label>
          <select name="role_id" id="" class="form-control text-capitalize">
            @foreach ($roles as $role)
                <option value="{{ $role->id }}" selected>{{$role->name}}</option>
            @endforeach
          </select>
          <small class="text-danger error error-usertype font-12" data-error="usertype">{{ $errors->first('role_id') }}</small>
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

        <div class="col-lg-12 mt-3">
        <button type="submit" class="btn btn-md btn-primary w-100 rounded-4">Add User</button>
        </div>

      </form>
    </div>
  </div>
</div>


@endsection
