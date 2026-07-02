@extends(config('delxero.layouts.dashboard.layout', 'layouts.dashboard.light_header_layout'))

@section('title', 'Student Profile')
@section('module-page-heading', 'Student Profile')

@section('module-page-actions')

    @companyRoleHasPermission('can_register_student')
        <a href="{{route('tertiary.students.create')}}" class="btn btn-sm btn-light">Add Student</a>
    @endcompanyRoleHasPermission

<a href="{{route('tertiary.students.index')}}" class="btn btn-sm btn-light">View Students</a>
<a href="#" class="btn btn-sm btn-light" data-bs-toggle="offcanvas" data-bs-target="#searchStudentsOffcanvas" aria-controls="searchStudentsOffcanvas">
    <i class="bi bi-search"></i> Search Students
</a>
@endsection

@section('module-breadcrumbs')
    <x-ui.breadcrumb :items="[
        [
            'label' => 'Manage Students',
            'url' => route('tertiary.students.index')
        ],
        [
            'label' => 'Student Profile',
            'url' => route('tertiary.students.show', ['id' => $student->uuid])
        ],
        [
            'label' => $student->first_name.' '.$student->last_name,
            'url' => route('tertiary.students.show', ['id' => $student->id])
        ]
        
    ]" />
@endsection

@section('requiredJs')
<script src="{{ asset('modules/schoolviser/js/tertiary_students.js') }}" defer></script>
@endsection

@section('content')

<x-alert-errors />
<x-alert-success />

<div class="row">

  @if ($student->terminated())
    <div class="col-lg-12">
        <div class="alert alert-danger" role="alert">
        @switch($student->termination->type)
            @case('expelled')
                <small>This student was expelled on {{ $student->termination->created_at }}</small>
                <small><b>Reason:</b> {{ $student->termination->reason }}</small>
                @break
            @case(2)

                @break
            @default

        @endswitch
        </div>
    </div>
  @endif


  <div class="col-lg-12">
    <div class="row">

      <div class="col-12 col-lg-3  order-sm-1 order-lg-2 mb-3">
        <div class="card mb-xl-9">
            <div class="card-body p-0">
                <img src="{{ $student->photo ? asset('storage/'.$student->photo) : asset('media/avatars/blank.png') }}" class="img-fluid rounded student-avator w-100" alt="image" />
            </div>
            
            <div class="card-footer">
                <form action="{{ route('tertiary.students.updatePhoto', ['id' => $student->id]) }}" method="POST" enctype="multipart/form-data" class="m-2">
                    @csrf
                    <input type="file" id="choosePhoto" name="photo" class="render-image-on-input-file-change" data-imgholder=".student-avator" />
                    <input type="submit" class="btn btn-sm btn-dark w-100 " id="avatorChangeBtn" value="upload" />
                    <small class="text-danger">{{ $errors->first('photo') }}</small>
                </form>
            </div>
        </div>
      </div>

      <div class="col-12 col-md-9">

         <div class="row">

            <div class="col-lg-6">
                <!-- Student personal info -->
                <div class="card">

                    <div class="card-header">
                        <div class="card-title">
                            <h3>Personal Info</h3>
                        </div>
                        <div class="card-toolbar">
                            @companyRoleHasPermission('can_update_students_personal_info')
                                <a href="" data-bs-toggle="offcanvas" data-bs-target="#updateInfo" class="btn btn-sm btn-light-primary">Update Info</a>
                                @include('schoolviser::tertiary.students.partials.offcanvas._update_personal_info_offcanvas')
                            @endcompanyRoleHasPermission

                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="row">

                            <div class="col-12 col-sm-12 col-lg-12">
                                <h2 class="text-dark text-capitalize fw-bold m-0">{{ $student->first_name." ".$student->last_name}}</h2>
                                <small class="text-end font-20">
                                   
                                </small>
                                <hr />
                            </div>

                            <div class="col-lg-12">
                                <span class="text-capitalize"><b class="text-success">Gender: </b>{{ $student->gender }}</span><br />
                                <span><b>Nationality: </b>{{ $student->nationality }}</span><br />
                                <span><b>Nin: </b>{{ $student->nin }}</span><br />
                                <span><b>Phone: </b>{{ $student->phone }}</span><br />
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <!-- Academic info -->
                <div class="card">
                    <div class="card-header">
                       <div class="card-title">
                            <h4>Current Academi Info</h4>
                       </div>
                       <div class="card-toolbar">
                            @companyRoleHasPermission('can_update_students_registration_info')
                            <a href="" data-bs-toggle="offcanvas" data-bs-target="#updateReg" class="btn btn-sm btn-light">Update Reg Info</a>
                            @endcompanyRoleHasPermission
                       </div>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-12 col-sm-12 col-lg-12">
                                <small class="text-end font-20">
                                    @if ($student->course)
                                        {{ $student->course->name }}
                                    @endif

                                    @if ($student->courseGroup)
                                        {{ '| '.$student->courseGroup->name }}
                                    @endif
                                </small>
                                <hr />
                            </div>

                            <div class="col-lg-12">
                                <span><b>Reg No: </b>{{ $student->regno }}</span><br />
                                <span><b>Access Number: </b>{{ $student->access_number }}</span><br />
                                <span><b>Course: </b>{{ optional($student->course)->name }}</span><br />
                                <span><b>Set: </b>{{ optional($student->courseGroup)->name }}</span><br />
                                <span><b>Year: </b>{{ optional($student->currentIntakeRegistration)->year }}</span>
                                <span><b>Semester: </b>{{ optional($student->currentIntakeRegistration)->semester }}</span><br />
                            </div>


                        </div>
                    </div>
                </div>
            </div>
         </div>

         

         <!-- Registrations -->
         <div class="card rounded-3 mt-4">
            <div class="card-header">
                <div class="card-title">
                    <h3>Registrations</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle table-row-dashed fs-6 gy-5">
                        <thead>
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th>Academic Year</th>
                                <th>Intake</th>
                                <th>Year</th>
                                <th>Semester</th>
                                <th>new_or_continuing</th>
                                <th>registered_on</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($student->intakeRegistrations as $registration)
                             <tr style="color: {{ $registration->locked ? 'purple' : 'green' }}">
                                <td>{{ $registration->academicYear?->name }}</td>
                                <td>{{ termLabel($registration->term->term, $registration->term->name) }}</td>
                                <td>{{ 'Year '.$registration->year }}</td>
                                <td>{{ 'Sem '.$registration->semester }}</td>
                                <td>{{ $registration->new_or_continuing }}</td>
                                <td>{{ $registration->created_at }}</td>
                                <td>
                                    @if ($registration->isLocked())
                                        @companyRoleHasPermission('can_unlock_student_registration')
                                            <form action="{{ route('tertiary.intake.registrations.unlock', $registration->uuid) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-light" 
                                                        data-bs-toggle="tooltip" 
                                                        data-bs-placement="top" 
                                                        title="This registration is locked. Editing is disabled until unlocked.">
                                                    <i class="bi bi-lock"></i> UnLock Registration
                                                </button>
                                            </form>
                                        @endcompanyRoleHasPermission
                                    @else
                                        @companyRoleHasPermission('can_lock_student_registration')
                                            <form action="{{ route('tertiary.intake.registrations.lock', $registration->uuid) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-light"
                                                        data-bs-toggle="tooltip" 
                                                        data-bs-placement="top" 
                                                        title="Locking will disable editing for this registration.">
                                                    <i class="bi bi-unlock"></i> Lock Registration
                                                </button>
                                            </form>
                                        @endcompanyRoleHasPermission
                                    @endif


                                    <!-- view intake registrations details -->
                                    @companyRoleHasPermission('can_view_student_registrations')
                                        <a href="" class="btn btn-sm btn-light-success"><i class="bi bi-eye"></i></a>
                                    @endcompanyRoleHasPermission

                                </td>
                             </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
         </div>



      </div>

    </div>
  </div>

</div>






@if ($student->currentIntakeRegistration)
@include('schoolviser::tertiary.students.partials.offcanvas._update_reginfo_offcanvas')
@endif


<div
    class="offcanvas offcanvas-start"
    data-bs-scroll="true"
    tabindex="-1"
    id="registerStudent"
    aria-labelledby="Enable both scrolling & backdrop"
>
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="Enable both scrolling & backdrop">
            Register {{ $student->first_name.' '.$student->last_name }}
        </h5>
        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="offcanvas"
            aria-label="Close"
        ></button>
    </div>
    <div class="offcanvas-body">
        <form class=" row" action="{{ route('tertiary.students.enroll', ['student_id' => $student->id]) }}" method="POST">
            @csrf
            <div class="col-lg-12">
                <span class=""><b>Full Names: </b> {{ $student->first_name.' '.$student->last_name }}</span>
            </div>
            

            @php
                $terms = active_terms();
            @endphp
            <div class="col-lg-12">
                <label for="">Intake</label>
                <select name="term" id="" class="form-control">
                    @foreach ($terms as $term)
                        <option value="{{$term->id}}" {{ (term()->id == $term->id) ? 'selected' : '' }}>{{ $term->year }} {{ (term()->term == 2) ? '(Current)' : '' }}</option>
                    @endforeach
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
                <label class="text-muted text-small">New Or Continuing</label>
                <select name="new_or_continuing" id="" class="form-control">
                    <option value="new" >New</option>
                    <option value="continuing" selected>Continuing</option>
                </select>
                <small class="text-danger text-muted p-1">{{ $errors->first('new_or_continuing') }}</small>
            </div>


            <div class="col-lg-12 my-5">
                <button class="btn btn-dark btn-md w-100">Enroll {{ $student->first_name }}</button>
            </div>


        </form>
    </div>
</div>


@include('schoolviser::tertiary.students.partials.offcanvas._search_students_offcanvas')

@endsection



