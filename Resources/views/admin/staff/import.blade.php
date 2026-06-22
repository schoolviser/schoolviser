@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))

@section('pageheader', 'Import Employees')
@section('pageheaderDescription', 'Manage Employee Information')

@section('pageheader-controls')
<a href="{{ route('staff.positions') }}" class="px-2 py-1 rounded-4 font-12 border border-primary text-primary">Employee Positions</a>
<a href="{{ route('staff.trash') }}" class="px-2 py-1 rounded-4 font-12 border border-primary text-primary">Trash</a>
@endsection

@section('where-am-i')
<a href="{{route('dashboard')}}" class="font-10 bg-light py-1 px-2 rounded-4 my-1 fw-light text-dark">Dashboard</a>
<a href="" class="font-10 bg-light py-1 px-2 rounded-4 my-1 fw-bold">></a>
<a href="{{route('staff')}}" class="font-10 bg-light py-1 px-2 rounded-4 my-1">Staff</a>
@endsection
    
@section('content')
<div class="row mt-3">

  <div class="col-lg-12">
    @include('dashboard.includes.alerts.created')
  </div>

  <div class="col-lg-8">
   <form action="{{ route('staff.import.process') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
     <label for="" class="form-label">Choose file</label>
     <input
      type="file"
      class="form-control"
      name="file"
      id=""
      placeholder=""
      aria-describedby="fileHelpId"
     />
     <div id="fileHelpId" class="form-text">Choose excell file</div>
    </div>

    <div>
     <button class="w-100 rounded-5 btn btn-md btn-primary" type="submit">Import</button>
    </div>
    
   </form>
  </div>

  <div class="col-lg-4">
   <div class="card text-start rounded-3">
    <img class="card-img-top" src="{{ asset('images/employee_import.jpg') }}" alt="Title" />
    <div class="card-body">
     <h4 class="card-title">Excell Template Parameters</h4>
     <ul class="font-12 fw-light fst-italic">
      <li>Work Number <span class="text-danger"></span></li>
      <li>First Name <span class="text-danger">Required</span></li>
      <li>Last Name <span class="text-danger">Required</span></li>
      <li>Gender <span class="text-danger">Required</span> <span class="text-primary">(Male, Female)</span></li>
      <li>Marital Status <span class="text-danger">Required</span> <span class="text-primary">(Male, Female)</span></li>
      <li>Nationality</li>
      <li>Home Address</li>
      <li>Curent Address</li>
      <li>Nin</li>
      <li>Email <span class="text-danger">Required</span> <span class="text-primary">Unique</span></li>
      <li>Phone <span class="text-danger">Required</span> <span class="text-primary">Unique</span></li>
      <li>Department</li>

     </ul>
    </div>
   </div>
   
  </div>
  
</div>
@endsection
