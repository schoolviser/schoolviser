@extends(config('student.layout', 'student::layouts.master'))

@php
    $intakes = config('schoolviser.intakes')
@endphp

@section('module-page-heading', 'Students Information | '.$term->year.' '.$intakes[$term->term])
@section('module-page-description', 'Students Information | '.$term->year.' '.$intakes[$term->term])

@section('requiredJs')
<script src="{{ asset('js/student-search.js') }}" defer></script>
@endsection

@section('module-page-links')

    <a href="{{route('students.create')}}" class=" d-inline-flex align-items-center gap-1" type="button">
        <span class="">Add New Student</span>
    </a>

    <a class=" d-inline-flex align-items-center gap-1" type="button" data-bs-toggle="offcanvas" data-bs-target="#searchStudentOffcanvas">
        <i class="bi bi-search"></i>
        <span class="">Search</span>
    </a>

@endsection

@section('mobile-module-links')

    <a href="{{route('students.create')}}" class="dropdown-item d-inline-flex align-items-center gap-1" type="button">
        <img src="{{ asset('images/person_add_24dp_F3F3F3_FILL0_wght400_GRAD0_opsz24.svg') }}" class="" alt="">
        <span class="">Add New Student</span>
    </a>

    <div class="dropdown-divider"></div>

    <a class="dropdownitem- d-inline-flex align-items-center gap-1" type="button" data-bs-toggle="offcanvas" data-bs-target="#searchStudentOffcanvas">
        <img src="{{ asset('images/person_search_24dp_F3F3F3_FILL0_wght400_GRAD0_opsz24.svg') }}" class="" alt="">
        <span class="">Search</span>
    </a>

@endsection

@section('where-am-i')

@endsection

@section('content')


<div class="row">

    @if (count($students))

        @if (auth()->user()->getOption('students_listing_view_format', 'preference', 'table') == 'card')

            @foreach ($students as $student)
                <div class="col-lg-6 mb-3">
                    <div class="card">
                        <div class="card-body row">
                            <div class="col-2"><img src="{{ asset($student->photo ?? 'images/avator.png') }}" class="img-fluid rounded-circle" alt=""></div>
                            <div class="col-8">
                                <a href="{{ route('students.show', ['id' => $student->id]) }}" style="text-decoration: none;" class="pl-5"><span class="font-14 bg-light py-1 px-3 rounded-4 fw- text-uppercase">{{ $student->first_name." ".$student->last_name }}</span></a><br />
                                <small class="font-weight-bold text-capitalize font-14 bg-light py-1 px-3 rounded-4 fw- text-dark">{{ $student->gender }}</small>
                                <small class="font-weight-bold text-capitalize font-14 bg-light py-1 px-3 rounded-4 text-uppercase">{{ $student->access_number }}</small><br />

                                <small class="font-weight-bold text-capitalize font-14 bg-light py-1 px-3 rounded-4 fw- text-dark">{{ ($student->course) ? $student->course->name : '' }}</small>
                                @if ($student->courseGroup)
                                <small class="font-weight-bold text-capitalize font-14 bg-light py-1 px-3 rounded-4 fw- text-dark">{{ $student->courseGroup->name }}</small>
                                @endif
                                <br />

                                <small class="font-weight-bold text-capitalize font-14 bg-light py-1 px-3 rounded-4 fw- text-dark">Year {{ $student->registration->year }}</small>
                                <small class="font-weight-bold text-capitalize font-14 bg-light py-1 px-3 rounded-4 fw- text-dark">Sem {{ $student->registration->semester }}</small>
                            </div>
                            <div class="col-2 text-center">
                                <a href="{{ route('students.edit', ['id' => $student->id]) }}" class="btn btn-sm btn-primary dev m-1"><i class="fa fa-edit"></i></a>
                                <a href="{{ route('students.delete', ['id' => $student->registration->id]) }}" class="btn btn-sm btn-danger m-1"><i class="fa fa-trash"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="col-12">
                {{ $students->links() }}
            </div>

        @else
            <div class="col-xl-12">
                <div class="">
                    
                    <div class=" p-1">
                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed table-hover table-row-gray-400 gy-5" id="studentsTables">
                                <thead class="table-dark">
                                <tr>
                                    <th></th>
                                    <th>Personal Information</th>
                                    <th>Acdemic Information</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                                </thead>
                                <tbody class="fs-6 fw-semibold text-gray-600">
                                    @foreach ($students as $student)
                                        <tr class="">
                                            <td style="width: 5%;" class="py-lg-3">
                                                <img src="{{ asset($student->photo ?? 'images/avator.png') }}" class="img-fluid" alt="">
                                            </td>

                                            <td class="text-capitalize">
                                                <span>
                                                    <b>Full Names: </b>
                                                    <a href="{{ route('students.show', ['id' => $student->id]) }}" style="text-decoration: none;" class="pl-5"><span >{{ $student->first_name.' '.$student->last_name }}</span></a>
                                                </span><br />
                                                <span><b>Gender: </b>{{ $student->gender }}</span><br />
                                                <span><b>Nationality: </b>{{ $student->nationality }}</span><br />
                                                <span><b>Nin: </b>{{ $student->nin }}</span><br />
                                            </td>

                                            <td class="text-capitalize">
                                                <span><b>Reg No: </b>{{ $student->regno }}</span><br />
                                                <span><b>Access No: </b>{{ $student->access_number }}</span><br />
                                                <span><b>Course: </b>{{ optional($student->course)->name }}</span><br />
                                                <span><b>Set: </b>{{ optional($student->courseGroup)->name }}</span><br />
                                                <span><b>Year: </b>{{  $student->registration->year }}</span>
                                                <span><b>Semester: </b>{{  $student->registration->semester }}</span><br />
                                                <span><b>residence: </b>{{  $student->registration->residence }}</span><br />
                                                <span><b>Entry: </b>{{  $student->registration->new_or_continuing }}</span><br />
                                            </td>

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
        @endif





    @else
    <div class="text-center p-5">
    <a href=""><img src="{{asset('icons/addnewitem.svg')}}" class="w-10" style="width: 15%;" alt=""></a>
    </div>
    @endif

</div>

<!-- Search Students Offcanvas -->
@include('student::includes.offcanvas.tertiary_search_students')


@endsection
