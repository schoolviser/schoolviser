@extends('layouts.blank_layout')

@section('content')
<div class="d-flex flex-column flex-lg-row flex-column-fluid p-lg-20">
    
    <div class="d-flex flex-column flex-column-fluid flex-center w-lg-50 p-10">

        <div class="d-flex justify-content-between flex-column-fluid flex-column w-100 mw-450px">
            <div class="">

                <form class="form w-100" id="" action="{{ route('manageacademicyears.store') }}" method="POST" class="">
                    @csrf
                    <div class="card-body">

                        <div class="text-start mb-10">
                            <h1 class="text-gray-900 mb-3 fs-3x" data-kt-translate="sign-in-title">Set Academic Year</h1>
                            <div class="text-gray-500 fw-semibold fs-6"  data-kt-translate="general-desc"></div>
                            <div class="my-2">
                                @include('partials.alerts.errors')
                            </div>
                        </div>

                        <div class="fv-row mb-8">
                            <label for="name">Year Label</label>
                            <input type="text" name="name" value="{{old('name')}}" class="form-control form-control-solid" placeholder="Name eg 2025/2026">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="fv-row mb-8">
                            <label for="startDate">Start Date</label>
                            <input type="date" class="form-control" name="start_date" value="{{old('start_date')}}" placeholder="Start Date" />
                            @error('start_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="fv-row mb-8">
                            <label for="endDate">End Date</label>
                            <input type="date" class="form-control" name="end_date" value="{{old('end_date')}}" placeholder="End Date" />
                            @error('end_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                        <div class="d-flex flex-stack">
                            <button type="submit" class="btn btn-primary w-100">Save Year</button>
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--begin::Body-->
                </form>

            </div>

            <!-- Footer //-->
            <div class="m-0">
            </div>
        </div>
    </div>

    <div class="d-lg-flex flex-lg-row-fluid">
        <div class="alert" role="alert">
            <h5 class="alert-heading">📅 Why Set the Academic Year?</h5>
            <p>
                Defining the academic year ensures that all student records, courses, and assessments are organized within the correct timeframe. 
                It helps administrators and teachers:
            </p>
            <ul>
                <li>Track enrollments and graduations accurately</li>
                <li>Align timetables, exams, and reports with the right year</li>
                <li>Separate historical data from current activities</li>
                <li>Maintain compliance with education standards for both secondary and tertiary institutions</li>
            </ul>
            <p class="mb-0">
                👉 Remember to set a new academic year at the start of every school cycle to keep your system structured and reliable.
            </p>
        </div>

    </div>
</div>
@endsection


