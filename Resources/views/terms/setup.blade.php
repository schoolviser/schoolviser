@extends('layouts.blank_layout')

@section('content')
<div class="d-flex flex-column flex-lg-row flex-column-fluid p-lg-20">
    
    <div class="d-flex flex-column flex-column-fluid flex-center w-lg-50 p-10">

        <div class="d-flex justify-content-between flex-column-fluid flex-column w-100 mw-450px">
            <div class="">

                <form class="form w-100" id="" action="{{ route('manageterms.store') }}" method="POST" class="">
                    @csrf
                    <div class="card-body">

                        <div class="text-start mb-10">
                            <h1 class="text-gray-900 mb-3 fs-3x" data-kt-translate="sign-in-title">Set Current Term</h1>
                            <div class="text-gray-500 fw-semibold fs-6"  data-kt-translate="general-desc"></div>
                            <div class="my-2">
                                @include('partials.alerts.errors')
                            </div>
                        </div>

                        <div class="fv-row mb-8">
                            <label for="year">For Academic Year</label>
                            <input type="text" value="" class="form-control" placeholder="{{ $academicYear->name }}" readonly />
                            <input type="text" name="year_id" value="{{ $academicYear->id }}" class="form-control form-control-solid" placeholder="{{ $academicYear->name }}" hidden />
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="fv-row mb-8">
                            <label for="term">Select Term</label>
                            <select name="term" class="form-control text-danger rounded-0">
                                <option value="1" selected>{{ tenantTrans('schoolviser::terms.one') }}</option>
                                <option value="2">{{ tenantTrans('schoolviser::terms.two') }}</option>
                                <option value="3">{{ tenantTrans('three') }}</option>
                            </select>
                            @error('term')
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
                            <button type="submit" class="btn btn-primary w-100">Save Term</button>
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
            <h5 class="alert-heading">📖 Why Set the Term or Intake?</h5>
            <p>
                Each academic year is divided into <strong>terms</strong> or <strong>intakes</strong>. 
                Setting the correct term or intake ensures that:
            </p>
            <ul>
                <li>Students are registered under the right segment of the academic year</li>
                <li>Exams, timetables, and reports align with the correct period</li>
                <li>Course progression and attendance records remain accurate</li>
                <li>Both secondary and tertiary schools can manage multiple entry points smoothly</li>
            </ul>
            <p class="mb-0">
                👉 Always set the term or intake after defining the academic year, so your school’s records stay consistent and reliable.
            </p>
        </div>

    </div>
</div>
@endsection


