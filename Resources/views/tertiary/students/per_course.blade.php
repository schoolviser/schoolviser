@extends(config('student.layout', 'student::layouts.master'))

@php
    $intakes = config('schoolviser.intakes')
@endphp

@section('module-page-heading', 'Current Students - '.$course->name)
@section('pageheaderDescription', 'Manage Students')

@section('requiredJs')
<script src="{{ asset('js/student-search.js') }}" defer></script>
@endsection

@section('module-links')

    <!-- Add New Student Button -->
    <a href="{{ route('students.create') }}" class="btn btn-primary btn-sm d-inline-flex align-items-center">
        <img src="{{ asset('images/person_add_24dp_F3F3F3_FILL0_wght400_GRAD0_opsz24.svg') }}" alt="">
        <span>Add New Student</span>
    </a>

    <!-- Search Student Button -->
    <a class="btn btn-primary btn-sm d-inline-flex align-items-center" type="button"
       data-bs-toggle="offcanvas" data-bs-target="#searchStudentOffcanvas">
        <img src="{{ asset('images/person_search_24dp_F3F3F3_FILL0_wght400_GRAD0_opsz24.svg') }}" alt="">
        <span>Search</span>
    </a>

@endsection


@section('where-am-i')

@endsection

@section('content')


<div class="row">


@if (count($students))
  <div class="col-xl-12">

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-12 text-uppercase">
                    <small class="mb-0 p-0 fw-bold">{{ 'Students Information '.term()->year.' '.$intakes[term()->term] }}</small>
                </div>
            </div>
        </div>
        <div class="card-body p-1">
            <div class="table-responsive">
                <table class="table table-hover table-boardered p-0 m-0 table-striped" id="studentsTables">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Reg No/Access No</th>
                        <th>Student</th>
                        <th>Course | Course Group</th>
                        <th>Year | Semester</th>
                        <th>Section</th>
                        <th>New Or Old</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($students as $student)
                    <tr class="">
                        <td style="width: 5%;" class="py-lg-3">
                            <img src="{{ asset($student->photo ?? 'images/avator.png') }}" class="img-fluid" alt="">
                        </td>

                         <td>
                            <a href="{{ route('students.show', ['id' => $student->id]) }}" style="text-decoration: none;" class="pl-5"><span class="font-14 bg-light py-1 px-3 rounded-4 fw- text-uppercase">{{ $student->regno ?? $student->id }}</span></a><br />
                            <small class="font-weight-bold text-capitalize font-14 bg-light py-1 px-3 rounded-4 text-uppercase">{{ $student->access_number }}</small>
                        </td>

                        <td>
                            <a href="{{ route('students.show', ['id' => $student->id]) }}" style="text-decoration: none;" class="pl-5"><span class="font-14 bg-light py-1 px-3 rounded-4 fw- text-uppercase">{{ $student->first_name." ".$student->last_name }}</span></a><br />
                            <small class="font-weight-bold text-capitalize font-14 bg-light py-1 px-3 rounded-4 fw- text-dark">{{ $student->gender }}</small>
                        </td>


                        <td>
                            <small class="font-weight-bold text-capitalize font-14 bg-light py-1 px-3 rounded-4 fw- text-dark">{{ $student->course->name }}</small><br />
                            @if ($student->courseGroup)
                            <small class="font-weight-bold text-capitalize font-14 bg-light py-1 px-3 rounded-4 fw- text-dark">{{ $student->courseGroup->name }}</small>
                            @endif
                        </td>

                         <td>
                            <small class="font-weight-bold text-capitalize font-14 bg-light py-1 px-3 rounded-4 fw- text-dark">Year {{ $student->registration->year }}</small><br />
                            <small class="font-weight-bold text-capitalize font-14 bg-light py-1 px-3 rounded-4 fw- text-dark">Sem {{ $student->registration->semester }}</small>
                        </td>


                        <td><small class="font-weight-bold text-capitalize">{{ $student->registration->residence }}</small></td>
                        <td><small class="font-weight-bold text-capitalize">{{ $student->registration->new_or_continuing }}</small></td>
                        <td class="text-center">
                        <a href="{{ route('students.edit', ['id' => $student->id]) }}" class="btn btn-sm btn-primary dev"><i class="fa fa-edit"></i></a>
                        <a href="{{ route('students.delete', ['id' => $student->registration->id]) }}" class="btn btn-sm btn-danger" "><i class="fa fa-trash"></i></a>

                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $students->links() }}
        </div>
    </div>

  </div>
  <div class="col-lg-12 my-2">
  </div>
@else
<div class="text-center p-5">
  <a href=""><img src="{{asset('icons/addnewitem.svg')}}" class="w-10" style="width: 15%;" alt=""></a>
 </div>
@endif

</div>


<!-- Search Students Offcanvas -->
@include('student::includes.offcanvas.tertiary_search_students')


@endsection
