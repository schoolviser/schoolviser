@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))


@section('pageheader', 'Employee Profile')
@section('pageheaderDescription', $staff->first_name.' Profile')

@section('pageheader-controls')
<a href="{{ route('staff') }}" class="px-2 py-1 rounded-4 font-12 border border-primary fw-light text-primary bg-white">Employees</a>
<a href="{{ route('staff') }}" class="px-2 py-1 rounded-4 font-12 border border-primary fw-light text-danger bg-white">Employee Positions</a>
@endsection

@section('where-am-i')
<a href="{{route('dashboard')}}" class="font-10 bg-light py-1 px-2 rounded-4 my-1 fw-light text-dark">Dashboard</a>
<a href="" class="font-10 bg-light py-1 px-2 rounded-4 my-1 fw-bold">></a>
<a href="{{route('staff')}}" class="font-10 bg-light py-1 px-2 rounded-4 my-1">Employees</a>
<a href="" class="font-10 bg-light py-1 px-2 rounded-4 my-1 fw-bold">></a>
<a href="{{route('assets')}}" class="font-10 bg-light py-1 px-2 rounded-4 my-1">Employee Profile</a>
@endsection


    
@section('content')
<div class="row mt-4">

  <div class="col-lg-12">
    @include('dashboard.includes.alerts.updated')
  </div>

  <div class="col-lg-12 my-3">
    @if ($staff->left_on)
        <div class="card mb-1 border border-danger">
          <div class="card-body px-3 py-2">
            <p class="p-0 m-0 text-muted ">{{ $staff->full_name }} left this school on {{ $staff->left_on }}</p>
          </div>
        </div>
    @endif
  </div>

  <!-- Student Photo -->
  <div class="col-lg-3">
    <div class="card rounded-3 border border-primary">
      <div class="card-header">
        <img src="{{ asset($staff->photo ?? config('defaults.avator')) }}" class="img-fluid rounded-4 student-avator w-100" alt="image" />
      </div>
      <div class="card-body p-0">
          <form action="{{ route('staff.update.photo', ['id' => $staff->id]) }}" method="POST" enctype="multipart/form-data" class="m-2">
            @csrf
            <label for="choosePhoto" class="custom-file-upload text-small text-muted border border-primary py-1 px-2 rounded-4">
              Choose Photo
            </label>
            <input type="file" id="choosePhoto" name="photo" class="render-image-on-input-file-change d-none" data-imgholder=".student-avator" />
            <input type="submit" class="btn btn-sm btn-white border rounded-4 border-dark font-12" id="avatorChangeBtn" value="Upload" />
            <small class="text-danger">{{ $errors->first('photo') }}</small>
          </form>
      </div>
    </div>
  </div>

  <div class="col-lg-9">

    <div class="col-sm-6 col-lg-12 mb-3">
      <!-- Create user account if does not exist -->
      @if (!$staff->user)
      <a href="" class="px-2 py-1 rounded-4 font-12 border border-primary fw-bold text-primary" data-bs-toggle="modal" data-bs-target="#createStaffAccount">Create Account</a>
      @endif
      @if ($staff->left_on)
      <a class="px-2 py-1 rounded-4 font-12 border border-primary fw-light text-primary" href="{{ route('staff.unmark.as.left', ['id' => $staff->id]) }}"">Unmark As Left</a>
      @else
      <a class="px-2 py-1 rounded-4 font-12 border border-primary fw-light text-primary" href="#" data-bs-toggle="modal" data-bs-target="#markEmployeeAsLeft">Mark As Left</a>
      @endif
      <a class="px-2 py-1 rounded-4 font-12 border border-primary fw-light text-primary" href="#" data-bs-toggle="modal" data-bs-target="#editEmployeePersonalInfoModal">Edit Personal Info</a>
      <a class="px-2 py-1 rounded-4 font-12 border border-primary fw-light text-primary" href="#" data-bs-toggle="modal" data-bs-target="#editEmployeeWorkInfoModal">Edit Work Info</a>
    </div>

    <div class="card shadow-sm rounded-3 border {{ ($staff->age > 50) ? 'border-danger' : 'border-primary' }}">
      <div class="card-body row">
        
        <div class="col-sm-10 col-lg-10">

          <!-- Employee personal info -->
          <div class="row">
            
            <div class="col-sm-6 col-lg-12">
              <h2 class="text-primary fw-bold fs-4">{{ $staff->full_name}}</h2>
              <small class="text-end fw-bold text-danger">
                @if ($staff->position)
                    {{ $staff->position->name }}
                @endif
              </small>
              <hr />
            </div>

            
            
            @if ($staff->nin)
            <div class="col-sm-4 col-lg-3 d-flex">
              <div class="pl-2">
                <span class="font-10  text-muted text-uppercase">nin</span>
                <h5 class="mb-0 bg-light font-14 px-2 rounded-4"> {{ $staff->nin }}</h5>
              </div>
            </div>
            @endif
            
            @if ($staff->date_of_birth)
            <div class="col-sm-4 col-lg-3 d-flex">
              <div class="pl-2">
                <span class="font-10  text-muted text-uppercase px-1">Date Of Birth</span>
                <h5 class="mb-0 bg-light font-14 px-2 rounded-4"> {{ $staff->date_of_birth }}</h5>
              </div>
            </div>
            @endif

            @if ($staff->age && $staff->age > 0)
            <div class="col-sm-4 col-lg-3 d-flex mb-2">
              <div class="pl-2">
                <span class="font-10  text-muted text-uppercase px-1">Age</span>
                <h5 class="mb-0 bg-light font-14 px-2 rounded-4"> {{ $staff->age }} Years Old</h5>
              </div>
            </div>
            @endif

            @if ($staff->gender)
            <div class="col-sm-4 col-lg-3 d-flex">
              <div class="pl-2">
                <span class="font-10 text-muted text-uppercase">Gender</span>
                <h5 class="mb-0 font-14 px-2 rounded-4 bg-light text-capitalize"> {{ $staff->gender }}</h5>
              </div>
            </div>
            @endif

            @if ($staff->marital_status)
            <div class="col-sm-4 col-lg-3 d-flex">
              <div class="pl-2">
                <span class="font-10 text-muted text-uppercase">Marital Status</span>
                <h5 class="mb-0 font-14 px-2 rounded-4 bg-light text-capitalize"> {{ $staff->marital_status }}</h5>
              </div>
            </div>
            @endif

            @if ($staff->nationality)
            <div class="col-sm-4 col-lg-3 d-flex mb-2">
              <div class="pl-2">
                <span class="font-10 text-muted text-uppercase">Nationality</span>
                <h5 class="mb-0 font-14 px-2 rounded-4 bg-light text-capitalize"> {{ $staff->nationality }}</h5>
              </div>
            </div>
            @endif

              
            @if ($staff->phone)
            <div class="col-sm-4 col-lg-3 d-flex mb-2">
              <div class="pl-2">
                <span class="font-10 text-muted text-uppercase">Phone</span>
                <h5 class="mb-0 font-14 px-2 rounded-4 bg-light text-capitalize"> {{ $staff->phone }}</h5>
              </div>
            </div>
            @endif

            @if ($staff->email)
            <div class="col-sm-6 col-lg-6 d-flex">
              <div class="pl-2">
                <span class="font-10 text-muted text-uppercase">Email</span>
                <h5 class="mb-0 font-14 px-2 rounded-4 bg-light text-"> {{ $staff->email }}</h5>
              </div>
            </div>
            @endif

            <div class="col-lg-12 mb-2"></div>

            @if ($staff->hire_date)
            <div class="col-sm-4 col-lg-3 d-flex">
              <div class="pl-2">
                <span class="font-10 text-muted text-uppercase">Hire Date</span>
                <h5 class="mb-0 font-14 px-2 rounded-4 bg-light text-capitalize"> {{ $staff->hire_date }}</h5>
              </div>
            </div>
            @endif

            @if ($staff->work_number)
            <div class="col-sm-4 col-lg-3 d-flex">
              <div class="pl-2">
                <span class="font-10 text-muted text-uppercase">Work Identification</span>
                <h5 class="mb-0 font-14 px-2 rounded-4 bg-light text-capitalize"> {{ $staff->work_number }}</h5>
              </div>
            </div>
            @endif

            
            
          </div>

        </div>

      </div>
    </div>
    <div class="card rounded-3 my-4 border border-dark">
      <div class="card-body row">
        <div col-lg-12>
          <span class="font-10 font-weight-semibold text-muted text-uppercase">departments</span><br />
          @if (count($staff->departments))
              @foreach ($staff->departments as $department)
                  <small class="badge badge-primary text-primary my-2">{{ $department->name }} <a href="" class="text-danger"><i class="mdi mdi-window-close"></i></a></small>
              @endforeach
          @else
              
          @endif
       </div>
      </div>
    </div>
  </div>

  
  <div class="col-lg-12 my-2">
    
  </div>

</div>

<!-- Modals -->

<!-- Mark employee as left modal -->
@include('dashboard.includes.modals.mark_employee_as_left_modal', ['name' => $staff->full_name, 'id' => $staff->id])

<!-- Edit Employee Personal Info Modal -->
@include('dashboard.includes.modals.edit_employee_personal_info_modal', [
  'id' => $staff->id,
  'firstname' => $staff->first_name,
  'lastname' => $staff->last_name,
  'dob' => $staff->date_of_birth,
  'nationality' => $staff->nationality,
  'nin' => $staff->nin,
  'email' => $staff->email,
  'phone' => $staff->primary_phone,
  'otherphone' => $staff->other_phone,
  'religion' => $staff->religion,
  'gender' => $staff->gender,
])

<!-- Edit Employee Work Info Modal -->
@include('dashboard.includes.modals.edit_employee_work_info_modal', [
  'id' => $staff->id,
  'hiredate' => $staff->hire_date,
  'position_id' => $staff->employee_position_id,
  'departmentIds' => collect($staff->departments)->map(function($item, $lkey){
    return $item->id;
  })->toArray(),
  'worknumber' => $staff->work_number
]) 

<form action="{{ route('staff.createUserAccount', ['id' => $staff->id]) }}" method="POST" id="createStaffAccount" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  @csrf
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-body row py-5">
        <div class="col-lg-12 mb-3 text-center">
          <h6>{{ 'Create Account For '.$staff->first_name }}</h6>
        </div>
        <div class="form-group col-lg-12 mb-3">
          <input type="text" name="username" placeholder="Username" class="form-control" value="{{ old('username') }}" required />
          <small class="text-danger">{{ $errors->first('username') }}</small>
        </div>
        <div class="form-group col-lg-12">
          <input type="email" name="email" placeholder="Email" class="form-control" value="{{ old('email') }}">
          <small class="text-danger">{{ $errors->first('email') }}</small>

        </div>
        <div class="form-group col-lg-12 mt-3">
          <input type="password" name="password" placeholder="Password" class="form-control" value="{{ old('password') }}" required />
          <small class="text-danger">{{ $errors->first('password') }}</small>

        </div>
        <div class="form-group col-lg-12 mt-3">
          <input type="password" name="password_confirmation" placeholder="Confirm Password" class="form-control" value="{{ old('password_confirmation') }}" required />
          <small class="text-danger">{{ $errors->first('password_confirmation') }}</small>

        </div>
      </div>
      <div class="modal-footer text-center">
        <button type="submit" class="btn btn-md btn-primary">Crreate Account</button>
      </div>
    </div>
  </div>
</form>


@endsection
