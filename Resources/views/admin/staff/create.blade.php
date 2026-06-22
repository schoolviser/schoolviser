@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))

@section('pageheader', 'Add New Employee')
@section('pageheaderDescription', 'Add New Employee')

@section('pageheader-controls')
<a href="{{ route('staff.trash') }}" class="px-2 py-1 rounded-4 bg-light font-12 border border-primary fw-bold text-primary">Employee Positions</a>
<a href="{{ route('staff.trash') }}" class="px-2 py-1 rounded-4 bg-light font-12 border border-primary fw-bold text-danger">Trash</a>
@endsection

    
@section('content')
<form class="row mt-4" action="{{ route('staff.store') }}" method="POST" enctype="multipart/form-data">
  @csrf

  <div class="col-lg-12 mb-2">
    @include('dashboard.includes.alerts.created')
  </div>
  <div class="card rounded-3 mb-2">
    <div class="card-body row">
      
      <div class="col-lg-3">
        <img src="{{ asset(config('defaults.avator')) }}" class="img-fluid rounded-4 student-avator w-100" alt="image" />
        <label for="choosePhoto" class="custom-file-upload text-small text-muted border border-primary py-1 px-2 rounded-4">
          Choose Photo
        </label>
        <input type="file" id="choosePhoto" name="photo" class="render-image-on-input-file-change d-none" data-imgholder=".student-avator" />
      </div>

      <div class="col-lg-9">
        <div class="row">
          <div class="col-lg-4">
            <label for="firstName" class="mb-1 font-12 text-muted">First Name</label>
            <input type="text" name="first_name" class="form-control" placeholder="First Name" id="firstName" value="{{ old('first_name') }}" />
            <small class="text-danger">{{ $errors->first('first_name') }}</small>
          </div>
    
          <div class="col-lg-4">
            <label for="lastName" class="mb-1 font-12 text-muted">First Name</label>
            <input type="text" name="last_name" class="form-control" placeholder="Last Name" id="lastName" value="{{ old('last_name') }}" />
            <small class="text-danger">{{ $errors->first('last_name') }}</small>
          </div>
    
          <div class="col-lg-4">
            <label for="gender" class="mb-1 font-12 text-muted">Gender</label>
            <select class="form-control" name="gender">
              <option value="male" {{ (old('gender') == 'male') ? 'selected' : '' }}>Male</option>
              <option value="female" {{ (old('gender') == 'male') ? 'selected' : '' }}>Female</option>
            </select>
            <small class="text-danger">{{ $errors->first('gender') }}</small>
          </div>
    
          <div class="col-lg-4">
            <label for="marital_status" class="mb-1 font-12 text-muted">Marital Status</label>
            <select class="form-control" name="marital_status">
              <option value="">Choose Marital Status</option>
              <option value="married" {{ (old('marital_status') == 'married') ? 'selected' : '' }}>Married</option>
              <option value="single" {{ (old('marital_status') == 'single') ? 'selected' : '' }}>Single</option>
              <option value="divorced" {{ (old('marital_status') == 'divorced') ? 'selected' : '' }}>Divorced</option>
            </select>
            <small class="text-danger">{{ $errors->first('marital_status') }}</small>
          </div>
    
          <div class="col-lg-4">
            <label for="marital_status" class="mb-1 font-12 text-muted">Nationality</label>
            <input type="text" name="nationality" value="{{ old('nationality') }}" class="form-control" placeholder="Nationality">
            <small class="text-danger">{{ $errors->first('nationality') }}</small>
          </div>
    
          <div class="col-lg-4">
            <label for="home_address" class="mb-1 font-12 text-muted">Home Address</label>
            <input type="text" name="home_address" value="{{ old('home_address') }}" class="form-control" placeholder="Home District">
            <small class="text-danger">{{ $errors->first('home_address') }}</small>
          </div>
    
    
          <div class="col-md-6">
            <label for="current_address" class="mb-1 font-12 text-muted">Current Address</label>
            <input type="text" name="current_address" value="{{ old('current_address') }}" class="form-control" placeholder="Current Address">
                <small class="text-danger">{{ $errors->first('current_address') }}</small>
          </div>
    
        </div>
      </div>
    </div>
  </div>

  <div class="card rounded-3 my-2">
    <div class="card-body row">

      <div class="col-md-6">
        <div class="form-group row">
          <label class="col-sm-3 col-form-label">Email</label>
          <div class="col-sm-9">
            <input type="text" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email" />
            <small class="text-danger">{{ $errors->first('email') }}</small>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group row">
          <label class="col-sm-3 col-form-label">Telephone 1</label>
          <div class="col-sm-9">
            <input type="text" name="primary_phone"  class="form-control" placeholder="Primary Phone Number" value="{{ old('primary_phone') }}" />
            <small class="text-danger">{{ $errors->first('primary_phone') }}</small>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group row">
          <label class="col-sm-3 col-form-label">Telephone 2</label>
          <div class="col-sm-9">
            <input type="text" name="other_phone"  class="form-control" placeholder="Primary Phone Number" value="{{ old('other_phone') }}" />
            <small class="text-danger">{{ $errors->first('other_phone') }}</small>
          </div>
        </div>
      </div>

    </div>
  </div>

  <div class="card rounded-3 my-2">
    <div class="card-body row">
      <div class="col-md-6">
        <div class="form-group row">
          <label class="col-sm-3 col-form-label">ID Number</label>
          <div class="col-sm-9">
            <input type="text" name="work_number" class="form-control" placeholder="Work Identification Number" value="{{ old('work_number') }}" />
            <small class="text-danger">{{ $errors->first('work_number') }}</small>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group row">
          @inject('department', '\App\Models\Department\Department')
          <label class="col-sm-3 col-form-label">Department</label>
          <div class="col-sm-9">
            @if (count($departments = $department::all()) > 0)
                <select name="department" id="" class="form-control">
                  @foreach ($departments as $department)
                      <option value="{{ $department->id }}" {{ (old('department') == $department->id) ? 'selected' : '' }}>{{ $department->name }}</option>
                  @endforeach
                </select>
            @endif
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group row">
          @inject('levelOfEducation', '\App\Models\Employee\LevelOfEducation')
          <label class="col-sm-3 col-form-label">Education</label>
          <div class="col-sm-9">
            @if (count($levelsOfEducation = $levelOfEducation::all()) > 0)
                <select name="level_of_education" id="" class="form-control">
                  @foreach ($levelsOfEducation as $education)
                      <option value="{{ $education->id }}" {{ (old('level_of_education') == $education->id) ? 'selected' : '' }}>{{ $education->name }}</option>
                  @endforeach
                </select>
            @endif
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group row">
          @inject('position', '\App\Models\Employee\EmployeePosition')
          <label class="col-sm-3 col-form-label">Position</label>
          <div class="col-sm-9">
            @if (count($positions = $position::all()) > 0)
                <select name="position" id="" class="form-control">
                  @foreach ($positions as $position)
                      <option value="{{ $position->id }}" {{ (old('position') == $position->id) ? 'selected' : '' }}>{{ $position->name }}</option>
                  @endforeach
                </select>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-12 my-3">
    <button type="submit" class="btn btn-md btn-primary rounded-4 px-4 w-100">Save</button>
  </div>
</form>
@endsection
