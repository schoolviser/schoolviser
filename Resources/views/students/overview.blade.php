@extends(config('student.layout', 'student::layouts.master'))


@section('module-page-heading', 'Students Overview')
@section('pageheaderDescription', 'Manage Students')

@section('module-links')
@if (config('schoolviser.package') == 'premium')
    <a href="{{route('students.import')}}">Import Students</a>
@endif
<a href="https://stephenokello.com/" target="_blank">Stephen Okello</a>


@section('requiredCss')
<style>
  .table-responsive {
    overflow-x: auto !important;
  }
</style>
@endsection

@section('requiredJs')
<script src="{{ asset('chart.js/Chart.min.js') }}" defer></script>
<script src="{{ asset('js/student.js') }}" defer></script>
@endsection


@if (config('schoolviser.type') == 'tertiary')
<div class="dropdown d-inline">
  <a
    class=" dropdown-toggle"
    type="button"
    id="triggerId"
    data-bs-toggle="dropdown"
    aria-haspopup="true"
    aria-expanded="false"
  >
    View By Course
  </a>
  <div class="dropdown-menu" aria-labelledby="triggerId">
    <a class="dropdown-item" href="#">Action</a>
    <a class="dropdown-item disabled" href="#">Disabled action</a>
    <h6 class="dropdown-header">Section header</h6>
    <a class="dropdown-item" href="#">Action</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="#">After divider action</a>
  </div>
</div>
@else
<div class="dropdown d-inline">
  <a
    class=" dropdown-toggle"
    type="button"
    id="triggerId"
    data-bs-toggle="dropdown"
    aria-haspopup="true"
    aria-expanded="false"
  >
    View By Class
  </a>
  <div class="dropdown-menu" aria-labelledby="triggerId">
    @foreach (clazzs() as $clazz)
    <a class="dropdown-item" href="{{route('students.clazz', ['id' => $clazz->id])}}">{{$clazz->name}}</a>
    @endforeach
  </div>
</div>
@endif

@endsection



@section('where-am-i')

@endsection

@section('content')

<div class="row mb-5">

 <div class="col-lg-2 p-0">
  <div class="bg-light rounded-2 px-2 mx-1">
   <small class="text-muted">Total</small>
   <h2 class="">{{ number_format($overview->total_students, 0) }}</h2>
  </div>
 </div>

 <div class="col-lg-2 px-1">
  <div class="bg-light rounded-2 px-2">
   <small class="text-muted">Female</small>
  <h2>{{ number_format($overview->total_female, 0) }}</h2>
  </div>
 </div>

 <div class="col-lg-2 p-0">
  <div class="bg-light rounded-2 px-2 mx-1">
   <small class="text-muted">Male</small>
   <h2>{{ number_format($overview->total_male, 0) }}</h2>
  </div>
 </div>

</div>


<div class="row mb-5">
 <div class="col-lg-6 rounded-2 py-4 d-none"><canvas id="studentsPerYearGroupChart" height="200px"></canvas></div>
 <div class="col-lg-6 rounded-2 py-4"><canvas id="studentsPerCourseChart" height="200px"></canvas></div>
</div>

<div class="row mb-5">
 <div class="col-lg-6 rounded-2 py-4"><canvas id="studentsPerSemesterChart" height="200px"></canvas></div>
 <div class="col-lg-6 rounded-2 py-4"><canvas id="studentsPerAcademicYearChart" height="200px"></canvas></div>
</div>



@endsection
