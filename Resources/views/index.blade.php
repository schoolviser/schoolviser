@extends(config('student.layout', 'student::layouts.master'))


@section('module-page-heading', 'Current Students')
@section('pageheaderDescription', 'Manage Students')

@section('module-page-links')
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


<div class="row mt-3 ">

  <div class="col-lg-12 mb-2">
    <div class="row d-none">
      <!-- Show year and term of the fee payments -->
      <div class="col-lg-6">
        <div class="card mt-3">
          <div class="card-body px-3 py-2 row">
            <div class="col-lg-6 text-primary"><h6 style="font-weight: 800;">{{ request('year').' | Term '.request('term') }}</h6></div>
          </div>
        </div>
      </div>

      <form action="" method="POST" class="col-lg-6">
        @csrf
        <div class="row">

          <div class="col-lg-3">
            <label for="" class="font-10 text-muted">Year</label>
            <select name="year" id="" class="form-control text-success rounded-0" style="font-weight: 700;">
              @for ($i = 0; $i < option('look_back_years', 5); $i++)
              <option value="{{ term()->year - $i }}" {{ ((term()->year - $i) == request('year')) ? 'selected' : '' }}>{{ term()->year - $i }}</option>
              @endfor
            </select>
          </div>
          <div class="col-lg-3">
            <label for="" class="font-10 text-muted">Term</label>
            <select name="term" id="" class="form-control text-danger rounded-0">
              <option value="1" {{ (request('term') == 1) ? 'selected' : '' }}>Term One</option>
              <option value="2" {{ (request('term') == 2) ? 'selected' : '' }}>Term Two</option>
              <option value="3" {{ (request('term') == 3) ? 'selected' : '' }}>Term Three</option>
            </select>
          </div>
          @php
              $classes = clazzs();
          @endphp
          <div class="col-lg-3">
            <label for="" class="font-10 text-muted">Class</label>
            <select name="class" id="" class="form-control text-primary rounded-0">
              <option value="">All Students</option>
              @foreach ($classes as $class)
                  <option value="{{ $class->id }}" {{ (request('class') == $class->id) ? 'selected' : '' }}>{{ $class->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-lg-3 px-1">
            <button class="btn btn-md btn-primary mt-4 rounded-0" type="submit">Search</button>
          </div>

        </div>
      </form>

    </div>
  </div>

@if (count($registrations))
  <div class="col-xl-12">
    <div class="table-responsive">
      <table class="table table-hover table-bordered table-striped" id="studentsTables">
        <thead>
          <tr>
            <th></th>
            <th>Reg No</th>
            <th>Name</th>
            <th>Gender</th>
            <th>Class</th>
            <th>Section</th>
            <th>New Or Old</th>
            <th class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($registrations as $registration)
              <tr class="">
                <td style="width: 5%;">{{ $registration->id }}</td>
                <td><a href="{{ route('students.profile', ['id' => $registration->student->id]) }}" style="text-decoration: none;"><small class="font-12 bg-light ">{{ $registration->student->regno ?? $registration->student->id }}</small></a></td>
                <td>
                  <a href="{{ route('students.profile', ['id' => $registration->student->id]) }}" style="text-decoration: none;" class="pl-5"><span class="font-14 bg-light py-1 px-3 rounded-4 fw- text-dark">{{ $registration->student->first_name." ".$registration->student->last_name }}</span></a>
                </td>
                <td><small class="text-capitalize">{{ $registration->student->gender }}</small></td>
                <td><small class="font-weight-bold text-capitalize">{{ $registration->clazz->name }}</small></td>
                <td><small class="font-weight-bold text-capitalize">{{ $registration->residence }}</small></td>
                <td><small class="font-weight-bold text-capitalize">{{ $registration->new_or_continuing }}</small></td>
                <td class="text-center">
                  <a href="{{ route('students.edit', ['id' => $registration->student->id]) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                  <a href="{{ route('students.delete', ['id' => $registration->id]) }}" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="{{ '#confirmStudentDeleteModal'.$registration->id }}"><i class="fa fa-trash"></i></a>

                  @include('student::includes.modals.confirm_student_deletion_modal', [
                    'student_id' => $registration->id,
                    'student_names' => $registration->student->fullname
                  ])

                </td>
              </tr>
            @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <div class="col-lg-12 my-2">
    {{ $registrations->links() }}
  </div>
@else
<div class="text-center p-5">
  <a href=""><img src="{{asset('icons/addnewitem.svg')}}" class="w-10" style="width: 15%;" alt=""></a>
 </div>
@endif
  
</div>


@endsection
