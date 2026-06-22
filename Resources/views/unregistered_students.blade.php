@extends(config('student.layout', 'student::layouts.master'))


@section('module-page-heading', 'Unregistered Students')
@section('pageheaderDescription', 'Manage Students')

@section('module-links')
@if (config('schoolviser.package') == 'premium')
    <a href="{{route('students.import')}}">Inport Students</a>
@endif

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

<div class="row">
  <div class="col-lg-12">
    <div class="table-responsive">
      <table class="table table-hover table-bordered">
        <thead>
          <th>Regno</th>
          <th>Names</th>
          <th>Gendar</th>
          <th>Admission No.</th>
          <th>Admited On</th>
        </thead>
        <tbody>
          @foreach ($students as $student)
              <tr>
                <td>{{ $student->regno }}</td>
                <td>{{ $student->first_name.' '.$student->last_name }}</td>
                <td>{{ $student->gender }}</td>
                <td>{{ $student->admmission_number ?? $student->regno }}</td>
                <td>{{ $student->created_at }}</td>
                <td>
                  <a href="" class="btn btn-success btn-sm">Register</a>
                </td>
              </tr>
          @endforeach
         
        </tbody>
      </table>
    </div>
    
  </div>
</div>
@endsection
