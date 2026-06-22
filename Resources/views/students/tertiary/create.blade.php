@extends(config('student.layout', 'student::layouts.master'))


@section('module-page-heading', 'Add New Student')



@section('requiredJs')
<script src="{{ asset('js/student-search.js') }}" defer></script>

@endsection

@section('module-page-links')

<a href="{{route('students')}}" class="">View Students</a>

<a class=" d-inline-flex align-items-center gap-1" type="button" data-bs-toggle="offcanvas" data-bs-target="#searchStudentOffcanvas">
    <i class="bi bi-search"></i>
    <span class="">Search</span>
</a>


@endsection


@section('content')

<form class="" action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
  @csrf
    <div class="row">
        <div class="col-lg-12">
            @if (session('created'))
                <div
                    class="alert alert-success alert-dismissible fade show"
                    role="alert"
                >
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Close"
                    ></button>
                    <strong>Success</strong> {{ session('student')->first_name }} registered successfully, <a href="{{route('students.show', ['id' => session('student')->id])}}">view details</a>
                </div>

                <script>
                    var alertList = document.querySelectorAll(".alert");
                    alertList.forEach(function (alert) {
                        new bootstrap.Alert(alert);
                    });
                </script>

            @endif
        </div>

        <!-- Student Personal Info -->

        <div class="col-lg-8">
            <div class="card rounded-3">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-6 text-uppercase">
                            <small class="mb-0 p-0 fw-bold">{{ 'Personal Information' }}</small>
                        </div>
                        <div class="col-lg-6 text-end"><small>Action Icons</small></div>
                    </div>
                </div>
                <div class="card-body row">

                    <div class="col-lg-6">
                        <label class="">Surname </label>
                        <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" placeholder="Enter Surname" required />
                        <small class="text-danger p-2">{{ $errors->first('first_name') }}</small>
                    </div>

                    <div class="col-lg-6">
                        <label class="">Last Name</label>
                        <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}" placeholder="Last Name" required />
                        <small class="text-danger p-2">{{ $errors->first('last_name') }}</small>
                    </div>

                    <div class="col-lg-6">
                        <label class="">Gender *</label>
                        <select class="form-control" name="gender">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                        <small class="p-2 text-danger">{{ $errors->first('gender') }}</small>
                    </div>

                    <div class="col-lg-6">
                        <label class="">Date of Birth</label>
                        <input type="date" name="dob" class="form-control" value="{{ old('dob') }}" placeholder="dd/mm/yyyy" />
                        <small class="p-2 text-danger">{{ $errors->first('dob') }}</small>
                    </div>

                     <div class="col-lg-6">
                        <label class="col-sm-3 col-form-label">Country *</label>
                        <input type="text" name="country" value="{{ old('country') }}" placeholder="Country" class="form-control" />
                    </div>

                    <div class="col-lg-6">
                        <label class="col-sm-3 col-form-label">City/District</label>
                        <input type="text" name="city" value="{{ old('city') }}" placeholder="District" class="form-control" />
                    </div>

                    <div class="col-lg-6">
                        <label class="col-sm-3 col-form-label">Village</label>
                        <input type="text" name="village" value="{{ old('village') }}" placeholder="Village" class="form-control" />
                    </div>

                     <div class="col-lg-6">
                        <label class="col-sm-3 col-form-label">Phone</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Phone Number" class="form-control" />
                    </div>

                </div>

            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-12 text-uppercase">
                            <small class="mb-0 p-0 fw-bold">{{ 'Enrollment Information' }}</small>
                        </div>
                    </div>
                </div>
                <div class="card-body row">
                    <div class="col-lg-12">
                        <label for="admissionNumber" class="">Admission Number</label>
                        <input type="text" name="admission_number" id="admissionNumber" class="form-control" value="{{ old('admission_number') }}" placeholder="Admission Number" />
                        <small class="text-muted text-danger">{{ $errors->first('admission_number') }}</small>
                    </div>

                    <div class="col-lg-12">
                        <label for="regNo" class="text-muted text-small text-danger">RegNo</label>
                        <input type="text" name="regno" class="form-control" value="{{ old('regno') }}" placeholder="RegNo" />
                        <small class="text-muted text-danger">{{ $errors->first('regno') }}</small>
                    </div>

                    <div class="col-lg-12">
                        <label for="">Course</label>
                        <select name="course" id="" class="form-control">
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-lg-12">
                        <label class="year text-muted text-small">Academic Year</label>
                        <select name="year" id="year" class="form-control">
                            <option value="2025" selected>2025</option>
                            <option value="2023">2024</option>
                            <option value="2023">2023</option>
                            <option value="2023">2022</option>
                            <option value="2023">2021</option>
                            <option value="2023">2020</option>
                        </select>
                        <small class="text-danger text-small p-1">{{ $errors->first('year') }}</small>
                    </div>

                    <div class="col-lg-12">
                        <label class="text-muted text-small">Intake</label>

                        @php
                            $intakes = config('schoolviser.intakes', [])
                        @endphp

                        <select name="term" id="" class="form-control">
                            <option value="1" {{ (term()->term == 1) ? 'selected' : '' }}>{{ $intakes[1] }} {{ (term()->term == 1) ? 'Current' : '' }}</option>
                            <option value="2" {{ (term()->term == 2) ? 'selected' : '' }}>{{ $intakes[2] }} {{ (term()->term == 2) ? 'Current' : '' }}</option>
                        </select>
                        <small class="text-danger p-1">{{ $errors->first('term') }}</small>
                    </div>

                    <div class="col-lg-12">
                        <label for="">Semester</label>
                        <select name="semester" id="" class="form-control">
                            <option value="1">Semester 1</option>
                            <option value="2">Semester 2</option>
                        </select>
                    </div>

                    <div class="col-lg-12">
                        <label for="">Year</label>
                        <select name="year" id="" class="form-control">
                            <option value="1">Year 1</option>
                            <option value="2">Year 2</option>
                            <option value="3">Year 3</option>
                            <option value="4">Year 4</option>
                            <option value="5">Year 5</option>
                        </select>
                    </div>

                    <div class="col-lg-12">
                        <label for="courseGroup">Course Group</label>
                        <select name="course_group" id="" class="form-control">
                            @foreach ($courseGroups as $courseGroup)
                                <option value="{{ $courseGroup->id }}">{{ $courseGroup->name }}</option>
                            @endforeach
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

                    <div class="col-lg-12">
                        <label class="text-muted text-small">Entry Date</label>
                        <input type="date" name="entry_date" value="{{ old('entry_date') }}" class="form-control" />
                        <small class="text-danger text-muted p-1">{{ $errors->first('entry_date') }}</small>
                    </div>

                    <div class="form-group col-lg-12">
                        <label class="text-small text-muted">Residence</label>
                        <select name="residence" id="" class="form-control">
                            <option value="boarding" {{(old('residence') == 'boarding') ? 'selected' : ''}}>Boarding</option>
                            <option value="day" {{(old('residence') == 'day') ? 'selected' : ''}}>Day</option>
                        </select>
                    </div>

                    <div class="form-group col-lg-12">
                        <label class="text-muted text-small">Hostel</label>
                        <select name="hostel_id" id="" class="form-control">
                            <option value="">Hostel here</option>
                        </select>
                    </div>

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
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-12 text-uppercase">
                            <small class="mb-0 p-0 fw-bold">{{ 'Fees & Billing' }}</small>
                        </div>
                    </div>
                </div>
                <div class="card-body row">
                    <div class="col-lg-12">
                        <label class="col-sm-3 col-form-label">School Pay Code</label>
                        <input type="text" name="school_pay_code" value="{{ old('school_pay_code') }}" class="form-control" />
                    </div>
                    <div class="col-lg-12">
                        <label for="balanceCarriedForWard" class="text-muted text-small text-danger">Balance Carried Forward</label>
                        <input type="text" id="balanceCarriedForWard" name="balance_carried_forword" class="form-control" value="{{ old('balance_carried_forword') }}" placeholder="Balance Carried Forward" />
                        <small class="text-muted text-danger">{{ $errors->first('balance_carried_forword') }}</small>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-md btn-dark w-100 mt-3">Save</button>
        </div>
    </div>


</form>






<!-- Search Students Offcanvas -->
@include('student::includes.offcanvas.tertiary_search_students')

@endsection
