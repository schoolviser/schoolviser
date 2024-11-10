@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))


@section('pageheader', 'Term Settings')
@section('pageheaderDescription', 'Set your current term...')

@section('pageheader-controls')
<a href="{{ route('settings') }}" class="d-inline text-small text-muted cursor-pointer font-weight-bold text-primary">Go Back To Settings</a>
<div class="d-inline px-2"></div>
@endsection
    
@section('content')

<form class="forms-sample row" action="{{ route('settings.current.term.update') }}" method="POST">
  @csrf

  <div class="col-lg-12">
    <div class="card">
      <div class="card-body row">
        
      
        <div class="form-group col-lg-3 col-md-3">
          <div class="mb-3">
            <label for="currentYear" class="py-1 text-small text-muted ">Current Year</label>
            <input type="text" class="form-control" name="year" id="currentYear" value="{{ old('year') ?? term()->year }}" placeholder="Current Year" />
            <small class="text-danger text-muted">{{ $errors->first('year') }}</small>
          </div>
        </div>
      
        <div class="form-group col-lg-3 col-md-3">
          <div class="mb-3">
            <label for="currentTerm" class="py-1 text-small text-muted ">Current Term</label>
            <select name="term" class="form-control" id="">
              <option value="1" {{ (term()->term == '1') ? 'selected' : '' }}>Term 1</option>
              <option value="2" {{ (term()->term == '2') ? 'selected' : '' }}>Term 2</option>
              <option value="3" {{ (term()->term == '3') ? 'selected' : '' }}>Term 3</option>
            </select>
            <small class="text-danger">{{ $errors->first('term') }}</small>
          </div>
        </div>
      
        <div class="form-group col-lg-3 col-md-3">
          <div class="mb-3">
            <label for="currentYear" class="py-1 text-muted text-small ">Current Term Start Date</label>
            <input type="date" class="form-control" value="{{ old('start_date') ?? term()->start_date }}" name="start_date" />
            <small class="text-danger">{{ $errors->first('start_date') }}</small>
          </div>
        </div>
      
        <div class="form-group col-lg-3 col-md-3">
          <div class="mb-3">
            <label for="currentYear text-secondary" class="py-1 text-muted text-small ">Current Term End Date</label>
            <input type="date" class="form-control" name="end_date" value="{{ old('end_date') ?? term()->end_date }}" />
            <small class="text-danger">{{ $errors->first('end_date') }}</small>
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
      </div>
    </div>
  </div>

  <div class="col-lg-12 my-4">
    <button class="btn btn-md btn-primary w-100 rounded-4" type="submit">Update Settings</button>
  </div>
  
  
</form>
@endsection
