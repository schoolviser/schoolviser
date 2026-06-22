@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))


@section('pageheader', 'Register Student')
@section('pageheaderDescription', 'Register Student')


@section('content')

<div class="row my-3">
  <div class="col-lg-12">
    @include('dashboard.includes.alerts.created')
  </div>
  <div class="col-lg-12">
    <span class="px-3 py-1 bg-white fw-light fst-italic font-14 border border-primary rounded-5">Register student for this term</span>
    <span class="px-3 py-1 bg-white font-14 border fst-italic border-primary rounded-5">{{ 'Term '.term()->term.', '.term()->year }}</span>
  </div>
</div>

<form class="row" action="{{ route('students.registration.register.process') }}" method="POST" enctype="multipart/form-data">
  @csrf

  <div class="col-lg-6">
    <div class="card rounded-3 border-danger">
      <div class="card-body row">

        <div class="col-lg-6">
          <label for="" class="mb-1 font-12 text-muted">First Name *</label>
          <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" placeholder="Enter First Name" required />
          <small class="text-danger p-2">{{ $errors->first('first_name') }}</small>
        </div>

        <div class="col-lg-6">
          <label for="" class="mb-1 font-12 text-muted">Last Name *</label>
          <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}" placeholder="Enter last_name" required />
          <small class="text-danger p-2">{{ $errors->first('last_name') }}</small>
        </div>

        <div class="col-lg-6">
          <label for="" class="mb-1 font-12 text-muted">Gender *</label>
          <select class="form-control" name="gender">
            <option value="male">Male</option>
            <option value="female">Female</option>
          </select>
          <small class="p-2 text-danger">{{ $errors->first('gender') }}</small>
        </div>

        <div class="col-lg-6">
          <label for="" class="mb-1 font-12 text-muted">Date Of Birth *</label>
          <input type="date" name="dob" class="form-control" value="{{ old('dob') }}" placeholder="dd/mm/yyyy" />
          <small class="p-2 text-danger">{{ $errors->first('dob') }}</small>
        </div>

        <div class="col-lg-6">
          <label for="" class="mb-1 font-12 text-muted">City/Home</label>
          <input type="text" name="city" value="{{ old('city') }}" class="form-control" />
        </div>

        <div class="col-lg-6">
          <label for="" class="mb-1 font-12 text-muted">Country</label>
          <input type="text" name="country" value="{{ old('country') }}" class="form-control" />
        </div>

      </div>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="card rounded-3 border-primary">
      <div class="card-body row">

        <div class="col-lg-6">
          <label for="" class="mb-1 font-12 text-muted">Reg No *</label>
          <input type="text" name="regno" class="form-control" value="{{ old('regno') }}" placeholder="RegNo" />
          <small class="text-muted text-danger">{{ $errors->first('regno') }}</small>
        </div>

        <div class=" col-lg-4">
          <label for="" class="mb-1 font-12 text-muted">Class *</label>

          @if (count(clazzs()))
              <select class="form-control" name="clazz" id="clazz">
                @foreach (clazzs() as $clazz)
                  <option value="{{ $clazz->id }}" class="text-capitalize">{{ $clazz->name }}</option>
                @endforeach
              </select>
          @endif
        </div>

        <div class=" col-lg-6">
          <label for="" class="mb-1 font-12 text-muted">Year</label>

          @if (option('allow_selection_of_year_to_register_student'))
          <select name="year" id="year" class="form-control">
            <option value="2023">2024</option>
            <option value="2023" selected>2023</option>
            <option value="2023">2022</option>
            <option value="2023">2021</option>
            <option value="2023">2020</option>
          </select>
          <small class="text-danger text-small p-1">{{ $errors->first('year') }}</small>
          @else
            <input type="text" name="year" value="{{ term()->year }}" class="form-control" readonly />
            <small class="text-danger text-small p-1">{{ $errors->first('year') }}</small>
          @endif
        </div>

        <div class="col-lg-6">
          <label for="" class="mb-1 font-12 text-muted">Term</label>

            @if (option('allow_selection_of_term_to_register_student'))
            <select name="term" id="term" class="form-control">
              <option value="1" {{ (term()->term == '1') ? 'selected' : '' }}>Term 1</option>
              <option value="2" {{ (term()->term == '2') ? 'selected' : '' }}>Term 2</option>
              <option value="3" {{ (term()->term == '3') ? 'selected' : '' }}>Term 3</option>
            </select>
            @else
            <input type="text" name="term" value="{{ term()->term }}" class="form-control" readonly />
            @endif
            <small class="text-danger p-1">{{ $errors->first('term') }}</small>
        </div>

        <div class="col-lg-6">
          <label for="" class="mb-1 font-12 text-muted">Entry Date</label>
          <input type="date" name="entry_date" value="{{ old('entry_date') }}" class="form-control" />
          <small class="text-danger text-muted p-1">{{ $errors->first('entry_date') }}</small>
        </div>

        <div class="col-lg-6">
          <label for="" class="mb-1 font-12 text-muted">Residence</label>
          <select name="residence" id="" class="form-control">
            <option value="boarding" {{(old('residence') == 'boarding') ? 'selected' : ''}}>Boarding</option>
            <option value="day" {{(old('residence') == 'day') ? 'selected' : ''}}>Day</option>
          </select>
        </div>

        
      </div>
    </div>
  </div>

  <div class="col-lg-12 mt-4">
    <button type="submit" class="btn btn-md btn-primary rounded-5 w-100">Register</button>
  </div>


</form>


@endsection
