@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))


@section('pageheader', 'General Settings')

@section('pageheader-controls')
<a href="{{ route('settings') }}" class="d-inline text-small text-muted cursor-pointer font-weight-bold text-primary">Go Back To Settings</a>
<div class="d-inline px-2"></div>
@endsection
    
@section('content')

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <form class="forms-sample row" action="{{ route('settings.general.update') }}" method="POST">
          @csrf

          <div class="form-group col-lg-6 col-md-6">
            <div class="mb-3">
             <label for="schoolName" class="py-1 text-small text-muted">School Name</label>
              <input type="text" name="school_name" class="form-control" id="schoolName" value="{{ old('school_name') ?? option('school_name') }}" placeholder="School Name" />
              <small class="text-danger">{{ $errors->first('school_name') }}</small>
            </div>
          </div>

          <div class="form-group col-lg-3 col-md-3">
            <div class="mb-3">
              <label for="currentYear" class="py-1 text-small text-muted ">Current Year</label>
              <input type="text" class="form-control" name="current_year" id="currentYear" value="{{ old('year') ?? option('current_year') }}" placeholder="Current Year" />
              <small class="text-danger text-muted">{{ $errors->first('current_year') }}</small>
            </div>
          </div>

          <div class="form-group col-lg-3 col-md-3">
            <div class="mb-3">
              <label for="currentYear" class="py-1 text-small text-muted ">Current Term</label>
              <select name="current_term" class="form-control" id="">
                <option value="1" {{ (option('current_term') == '1') ? 'selected' : '' }}>Term 1</option>
                <option value="2" {{ (option('current_term') == '2') ? 'selected' : '' }}>Term 2</option>
                <option value="3" {{ (option('current_term') == '3') ? 'selected' : '' }}>Term 3</option>
              </select>
              <small class="text-danger">{{ $errors->first('current_term') }}</small>
            </div>
          </div>

          <div class="form-group col-lg-3 col-md-3">
            <div class="mb-3">
              <label for="currentYear" class="py-1 text-muted text-small ">Current Term Start Date</label>
              <input type="date" class="form-control" value="{{ old('current_term_start_date') ?? option('current_term_start_date') }}" name="current_term_start_date" />
              <small class="text-danger">{{ $errors->first('current_term_start_date') }}</small>
            </div>
          </div>

          <div class="form-group col-lg-3 col-md-3">
            <div class="mb-3">
              <label for="currentYear text-secondary" class="py-1 text-muted text-small ">Current Term End Date</label>
              <input type="date" class="form-control" name="current_term_end_date" value="{{ old('current_term_end_date') ?? option('current_term_end_date') }}" />
              <small class="text-danger">{{ $errors->first('current_term_end_date') }}</small>
            </div>
          </div>

          <div class="form-group col-lg-3 col-md-3">
            <div class="mb-3">
              <label for="currentYear text-secondary" class="py-1 text-muted text-small ">Look Back Years</label>
              <input type="text" class="form-control" name="look_back_years" value="{{ old('look_back_years') ?? option('look_back_years') }}" />
              <small class="text-danger">{{ $errors->first('look_back_years') }}</small>
            </div>
          </div>

          <div class="form-group col-lg-3 col-md-3">
            <div class="mb-3">
              <label for="currentYear text-secondary" class="py-1 text-muted text-small ">Next Term Starts On</label>
              <input type="date" class="form-control" name="next_term_start_date" value="{{ old('next_term_start_date') ?? option('next_term_start_date') }}" />
              <small class="text-danger">{{ $errors->first('next_term_start_date') }}</small>
            </div>
          </div>

          <div class="col-lg-12 py-2">
            <button class="btn btn-md btn-primary" type="submit">Update Settings</button>
          </div>
          
          
        </form>
      </div>
    </div>
  </div>
  
</div>
@endsection
