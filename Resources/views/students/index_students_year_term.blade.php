@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))


@section('requiredCss')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
@endsection

@section('requiredJs')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js" defer></script>
<script src="{{ asset('js/datatables.js') }}" defer></script>
@endsection

@section('pageheader', 'Students')


@section('content')


<div class="row">

  <div class="col-lg-12 mb-3">
    <div class="card">
      <div class="card-body p-1 row">
        <div class="col-lg-6">
          <form class="py-2 row" method="POST" action="{{ route('students.of') }}">
            @csrf
            <div class="col-lg-4">
              <select name="year" id="year" class="form-control">
                @for ($i = 0; $i < option('look_back_years', 5); $i++)
                  <option value="{{ option('current_year') - $i }}" {{ (($year ?? option('current_year')) == option('current_year') - $i) ? 'selected' : '' }}>{{ option('current_year') - $i }}</option>
                @endfor
              </select>
            </div>
    
            <div class="col-lg-4">
              <select name="term" id="year" class="form-control">
                @for ($i = 1; $i < 4; $i++)
                  <option value="{{ $i }}" {{ (option('current_term') == $i) ? 'selected' : '' }}>{{ 'Term '.$i}}</option>
                @endfor
              </select>
            </div>
    
            <div class="col-lg-4">
              <button type="submit" class="btn btn-primary btn-md">Search</button>
            </div>
          </form>
        </div>
  
        <div class="col-lg-6 pt-2">
          <div class="dropdown">
            <a id="my-dropdown" class="dropdown-bs-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">View By Class</a>
            <div class="dropdown-menu" aria-labelledby="my-dropdown">
              @if (count(clazzs()))
                  @foreach (clazzs() as $clazz)
                  <a class="dropdown-item" href="{{ route('students.viewbyclass',['class' => $clazz->id]) }}">{{$clazz->name}}</a>
                  @endforeach
              @endif
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

@if (count($registrations))
  <div class="col-xl-12 stretch-card grid-margin table-card">
    <div class="card">
      <div class="card-body m-1">

        <div class="table-responsive">
          <table class="table table-hover table-bordered table-striped" id="studentsByClassTable">
            <thead>
              <tr>
                <th>Reg No</th>
                <th>Name</th>
                <th>Gender</th>
                <th>Class</th>
                <th>Section</th>
                <th class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($registrations as $registration)
                  <tr class="">
                    <td><a href="{{ route('students.profile', ['id' => $registration->student->id]) }}" style="text-decoration: none;"><small>{{ $registration->student->regno ?? $registration->student->id }}</small></a></td>
                    <td>
                      <img src="{{ asset(($student->photo) ?? asset(config('defaults.avator'))) }}" class="mx1 rounded-circle border border-primary" alt="image" /> 
                      <a href="{{ route('students.profile', ['id' => $registration->student->id]) }}" style="text-decoration: none;" class="pl-5"><span class="ml-4">{{ $registration->student->surname." ".$registration->student->other_names }}</span></a> 
                    </td>
                    <td><small class="text-capitalize">{{ $registration->student->gender }}</small></td>
                    <td><small class="font-weight-bold text-capitalize">{{ $registration->clazz->name }}</small></td>
                    <td><small class="font-weight-bold text-capitalize">{{ $registration->residence }}</small></td>
                    <td class="text-center">
                      <a href="{{ route('students.delete', ['id' => $registration->student->id]) }}" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="{{ '#confirmStudentDeleteModal'.$registration->student->id }}" style="font-size:10px;">Delete</a>

                      @include('includes.modals.confirm_student_deletion_modal', [
                        'student_id' => $registration->student->id,
                        'student_names' => $registration->student->fullname
                      ])

                    </td>
                  </tr>
                @endforeach
            </tbody>
          </table>
        </div>

        

      </div>
    </div>
  </div>
  <div class="col-lg-12 my-2">
    lin
  </div>
@else
  <div class="col-lg-12">
    <div class="card shadow-sm">
      <div class="card-body font-weight-light">
        <h3 class="font-weight-light py-3">There are no students registered for this term......</h3>
        <a href="" class="btn btn-link btn-fw">Last Term Students</a>
        <a href="" class="btn btn-link btn-fw">Add Student</a>
      </div>
    </div>
  </div>
@endif
  
</div>


@endsection
