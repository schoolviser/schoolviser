@extends(config('delxero.dashboard_layout', 'schoolviser::layouts.main_layout'))

@section('module-page-heading', 'Add Student')

@section('module-page-actions')
<a href="{{ route('students.index') }}" class="btn btn-sm btn-light">View Students</a>
@endsection

@section('hello')
  @php
    $term = term();
  @endphp
    {{ $term->academicYear?->name.' '.$term->name }}
@endsection

@section('module-breadcrumbs')
<x-ui.breadcrumb :items="[
    [
        'label' => 'Manage Students',
        'url' => route('students.index')
    ],
    [
        'label' => 'Add New',
    ]
    
]" />
@endsection



@section('content')

<x-alert-errors />
<x-alert-success />

<div class="card">
  <div class="card-body">
    <form class="" action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
  @csrf
  <div class="row">

    <!-- Student Personal Info -->

    <div class="col-lg-12">
      <h3>Personal Information</h3>
    </div>

    <div class="col-lg-4">
      <label class="">Surname </label>
      <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" placeholder="Enter Surname" required />
      <small class="text-danger p-2">{{ $errors->first('first_name') }}</small>
    </div>
    
    <div class="col-lg-4">
      <label class="">Last Name</label>
      <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}" placeholder="Last Name" required />
      <small class="text-danger p-2">{{ $errors->first('last_name') }}</small>
    </div>

    <div class="col-lg-4">
      <label class="">Gender *</label>
      <select class="form-control" name="gender">
        <option value="male">Male</option>
        <option value="female">Female</option>
      </select>
      <small class="p-2 text-danger">{{ $errors->first('gender') }}</small>
    </div>

    <div class="col-lg-4">
      <label class="">Date of Birth</label>
      <input type="date" name="dob" class="form-control" value="{{ old('dob') }}" placeholder="dd/mm/yyyy" />
      <small class="p-2 text-danger">{{ $errors->first('dob') }}</small>
    </div>

  </div>

  
  
  <div class="row">
    <div class="col-lg-4">
      <label class="col-sm-3 col-form-label">City</label>
      <input type="text" name="city" value="{{ old('city') }}" class="form-control" />
    </div>
    <div class="col-lg-4">
      <label class="col-sm-3 col-form-label">Country *</label>
      <input type="text" name="country" value="{{ old('country') }}" class="form-control" />
    </div>
  </div>

  <div class="row mt-4">

    <h3>Academic Information</h3>

    <div class="col-lg-4">
      <label for="regNo" class="text-muted text-small text-danger">RegNo</label>
      <input type="text" name="regno" class="form-control" value="{{ old('regno') }}" placeholder="RegNo" />
      <small class="text-muted text-danger">{{ $errors->first('regno') }}</small>
    </div>

    <div class="col-lg-4">
      <label class="clazz text-muted text-small">Class</label>
      @if (count($clazzes))
          <select class="form-control" name="clazz_id" id="clazz">
            @foreach ($clazzes as $clazz)
              <option value="{{ $clazz->id }}" class="text-capitalize">{{ $clazz->name }}</option>
            @endforeach
          </select>
      @endif
    </div>

    @if ($academicYear && $academicYear->terms)
        <div class="col-md-4">
        <label class="text-muted text-small">Term</label>
        
        <select name="term_id" id="" class="form-control">
          @foreach ($academicYear->terms as $term)
          <option value="{{$term->id}}">{{$term->name}} </option>
          @endforeach
        </select>
          <small class="text-danger p-1">{{ $errors->first('term') }}</small>
      </div>
    @else
        
    @endif

    

    <div class="col-lg-4">
      <label class="text-muted text-small">Entry Date</label>
      <input type="date" name="entry_date" value="{{ old('entry_date') }}" class="form-control" />
      <small class="text-danger text-muted p-1">{{ $errors->first('entry_date') }}</small>
    </div>

  </div>

  <div class="row">

    <div class="form-group col-lg-4">
      <label class="text-small text-muted">Residence</label>
      <select name="residence" id="" class="form-control">
        <option value="boarding" {{(old('residence') == 'boarding') ? 'selected' : ''}}>Boarding</option>
        <option value="day" {{(old('residence') == 'day') ? 'selected' : ''}}>Day</option>
      </select>
    </div>

    <div class="col-lg-12">
        <label class="text-muted text-small">New Or Continuing</label>
        <select name="new_or_continuing" id="" class="form-control">
            <option value="new" selected>New</option>
            <option value="continuing">Continuing</option>
        </select>
        <small class="text-danger text-muted p-1">{{ $errors->first('new_or_continuing') }}</small>
    </div>
    
    <div class="form-group col-lg-4">
      <label class="text-muted text-small">Hostel</label>
      <select name="hostel_id" id="" class="form-control">
        <option value="">Hostel here</option>
      </select>
      
    </div>

  </div>

  <div class="row">

    <div class="col-lg-4">
      <label class="clazz text-muted text-small">Year Group</label>
      @if (count($yearGroups))
          <select class="form-control" name="year_group" id="clazz">
            @foreach ($yearGroups as $group)
              <option value="{{ $group->id }}" class="text-capitalize">{{ $group->name }}</option>
            @endforeach
          </select>
      @endif
    </div>
    
  </div>

  <div class="row mt-4">

    <h3>Fees & Billing</h3>

    <div class="col-lg-4">
      <label for="balanceCarriedForWard" class="text-muted text-small text-danger">Balance Carried Forward</label>
      <input type="text" id="balanceCarriedForWard" name="balance_carried_forword" class="form-control" value="{{ old('balance_carried_forword') }}" placeholder="Balance Carried Forward" />
      <small class="text-muted text-danger">{{ $errors->first('balance_carried_forword') }}</small>
    </div>


  </div>

  <div class="row mt-5 border-1 border-top py-4 mb-5">
    <div class="col-lg-12 text-center">
      <button type="submit" class="btn btn-md btn-primary rounded-5 w-100">Save</button>
    </div>
  </div>


</form>
  </div>
</div>

@endsection
