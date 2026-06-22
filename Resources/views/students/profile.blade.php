@extends(config('delxero.dashboard_layout', 'schoolviser::layouts.main_layout'))

@section('module-page-heading', 'Student Profile')

@section('module-page-actions')
<a href="{{route('students.index')}}" class="btn btn-sm btn-light">View Students</a>
@endsection

@section('hello')
    @php
        $term = term();
    @endphp
    {{ $term->academicYear?->name.' '.$term->name }}
@endsection

@section('module-breadcrumbs')
<x-ui.breadcrumb :items="[
    [
        'label' => 'Manage Students',
        'url' => route('students.index')
    ],
    [
        'label' => 'Student Profile',
        'url' => route('students.profile', ['id' => $student->id])
    ]
    
]" />
@endsection


@section('content')

<x-alert-success />
<x-alert-errors />

<div class="row">
  <!-- Student Photo -->
    <div class="col-12 col-lg-4 order-sm-1 order-lg-2 mb-3">
      <div class="card">
  
          <div class="card-body p-0">
              <img src="{{ asset('media/avatars/blank.png') }}" class="img-fluid rounde student-avator w-100" alt="image" />
          </div>
          <div class="card-footer">
              <form action="{{ route('students.update.photo', ['id' => $student->id]) }}" method="POST" enctype="multipart/form-data" class="m-2">
                  @csrf
                  <label for="choosePhoto" class="custom-file-upload text-small bg-light px-2 py-1 rounded-4 border border-primary">
                      Choose Photo
                  </label>
                  <input type="file" id="choosePhoto" name="photo" class="render-image-on-input-file-change d-none" data-imgholder=".student-avator" />
                  <input type="submit" class="btn btn-sm btn-dark " id="avatorChangeBtn" value="upload" />
                  <small class="text-danger">{{ $errors->first('photo') }}</small>
              </form>
          </div>
      </div>
    </div>

    <div class="col-12 col-md-8">

        <div class="row">

          <div class="col-lg-6">
              <!-- Student personal info -->
              <div class="card rounded-3">
                  <div class="card-header">
                    <h5 class="card-title">Personal Info</h5>
                    <div class="card-toolbar">
                        @companyRoleHasPermission('can_update_students_personal_info')
                      <a href="" data-bs-toggle="offcanvas" data-bs-target="{{ '#updateStudentPersonalInfoOffCanvas'.$student->id }}" class="text-primary btn btn-sm btn-light"><i class="bi bi-pencil"></i> Edit Info</a>
                        @endcompanyRoleHasPermission
                    </div>
                  </div>
                  <div class="card-body">
                      <div class="row">

                          <div class="col-12 col-sm-12 col-lg-12">
                              <h2 class="text-dark text-capitalize fw-bold m-0">
                                <span class="first-name-container">{{ $student->first_name}}</span>
                                <span class="last-name-container">{{ $student->last_name}}</span>
                              </h2>
                              <small class="text-end font-20">
                                  
                              </small>
                              <hr />
                          </div>

                          <div class="col-lg-12">
                              <span class="d-block mb-2 ">
                                  <b>Gender: </b><span class="gender-container text-capitalize">{{ $student->gender }}</span>
                              </span>

                              <span class="d-block mb-2 ">
                                  <b>Nationality: </b><span class="nationality-container text-capitalize">{{ $student->nationality }}</span>
                              </span>

                              <span class="d-block mb-2 ">
                                  <b>NIN: </b> <span class="nin-container">{{ $student->nin }}</span>
                              </span>

                              <span class="d-block mb-2">
                                  <b>DOB: </b><span class="dob-conatiner">{{ $student->date_of_birth }}</span>
                                  <span class="badge badge-light ms-2">{{ $student->age.' yrs' }}</span>
                              </span>
                          </div>

                      </div>
                  </div>
              </div>
          </div>

          @if($student->currentTermlyRegistration)
          <div class="col-lg-6">
              <!-- Academic info -->
              <div class="card rounded-3">
                  <div class="card-header">
                    <h5 class="card-title">Current Academic Info</h5>
                    <div class="card-toolbar">
                        @companyRoleHasPermission('can_update_students_registration_info')
                            <a href="" data-bs-toggle="offcanvas" data-bs-target="{{ '#updateStudentAcademicInfoOffCanvas'.$student->id }}" class="text-primary btn btn-sm btn-light"><i class="bi bi-pencil"></i> Edit Info</a>
                        @endcompanyRoleHasPermission
                    </div>
                  </div>
                  <div class="card-body">
                      <div class="row">

                          <div class="col-12 col-sm-12 col-lg-12">
                            <span class="text-uppercase" >class:</span>
                              <small class="text-end font-20 badge badge-primary">
                                  {{ $student?->currentTermlyRegistration?->clazz?->name}}
                              </small>
                              <hr />
                          </div>

                          <div class="col-lg-12">
                              <span><b>Reg No: </b>{{ $student->regno }}</span><br />
                              <span><b>Access Number: </b>{{ $student->access_number }}</span><br />
                          </div>


                      </div>
                  </div>
              </div>
          </div>
          @endif
        </div>

        

        <!-- Registrations -->
        <div class="card rounded-3 mt-4">
          <div class="card-header">
              <h5 class="card-title">Termly Registrations</h5>
          </div>
          <div class="card-body">
              <div class="table-responsive">
                  <table class="table table-hover align-middle table-row-dashed fs-6 gy-5">
                      <thead>
                          <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th>Academic Year</th>
                            <th>Term</th>
                            <th>Clazz</th>
                            <th>registered_on</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($student->termlyRegistrations as $registration)
                            <tr>
                              <td>{{ $registration->term?->academicYear?->name }}</td>
                              <td>{{ $registration->term?->name }}</td>
                              <td>{{ $registration?->clazz?->name }}</td>
                              <td>{{ $registration->created_at }}</td>
                              <td>
                                   @if ($registration->locked)
                                        @companyRoleHasPermission('can_unlock_student_registration')
                                            <form action="{{ route('students.unlock.registration', $registration->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-light">
                                                    <i class="bi bi-unlock"></i> UnLock Registration
                                                </button>
                                            </form>
                                        @endcompanyRoleHasPermission
                                    @else
                                        @companyRoleHasPermission('can_lock_student_registration')
                                            <form action="{{ route('students.lock.registration', $registration->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-light">
                                                    <i class="bi bi-lock"></i> Lock Registration
                                                </button>
                                            </form>
                                        @endcompanyRoleHasPermission
                                    @endif
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

@includeIf('schoolviser::students.partials.offcanvas._update_student_personal_info_offcanvas', ['student' => $student])

@if ($student->currentTermlyRegistration)
@includeIf('schoolviser::students.partials.offcanvas._update_student_academic_info_offcanvas', ['registration' => $student->currentTermlyRegistration])
 
@endif

@endsection




@section('scripts')
<script>
$(document).ready(function() {

    $('form[id^="updateStudentPersonalInfoForm"]').on('submit', function(e) {
        e.preventDefault();

        let form = $(this);
        let actionUrl = form.attr('action');
        let formData = form.serialize();
        let alertBox = form.closest('.offcanvas-body').find('.alert');
        let submitBtn = form.find('button[type="submit"]');
        let btnText = submitBtn.find('.btn-text');
        let spinner = submitBtn.find('.spinner-border');

        // Clear previous errors and alerts
        form.find('.error').text('');
        alertBox.addClass('d-none').text('');

        // Show spinner
        btnText.text('Updating...');
        spinner.removeClass('d-none');
        submitBtn.prop('disabled', true);

        $.ajax({
            url: actionUrl,
            type: 'POST',
            data: formData,
            success: function(response) {
                if(response.success) {
                    alertBox.removeClass('d-none alert-danger')
                            .addClass('alert-success')
                            .text(response.message);

                    // Update placeholders on page
                    // Assuming your placeholders have IDs like #first-name-container, #last-name-container, etc.
                    let updatedData = form.serializeArray();
                    $.each(updatedData, function(_, field) {
                        let container = $('.' + field.name.replace('_','-') + '-container');
                        if(container.length) {
                            container.text(field.value);
                        }
                    });

                    // Optionally close offcanvas after short delay
                    setTimeout(function() {
                        form.closest('.offcanvas').offcanvas('hide');
                    }, 1500);
                }
            },
            error: function(xhr) {
                if(xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        form.find('.error-' + key).text(value[0]);
                    });
                } else if(xhr.status === 403) {
                    alertBox.removeClass('d-none alert-success')
                            .addClass('alert-danger')
                            .text('Unauthorized action. You do not have permission.');
                } else if(xhr.status === 500) {
                    alertBox.removeClass('d-none alert-success')
                            .addClass('alert-danger')
                            .text('Server error occurred. Please try again later.');
                } else {
                    alertBox.removeClass('d-none alert-success')
                            .addClass('alert-danger')
                            .text('Something went wrong. Please try again.');
                }
            },
            complete: function() {
                // Reset button state
                btnText.text('Update Info');
                spinner.addClass('d-none');
                submitBtn.prop('disabled', false);
            }
        });
    });

    $('form[id^="updateStudentAcademicInfoForm"]').on('submit', function(e) {
        e.preventDefault();

        let form = $(this);
        let actionUrl = form.attr('action');
        let formData = form.serialize();
        let alertBox = form.closest('.offcanvas-body').find('.alert');
        let submitBtn = form.find('button[type="submit"]');
        let btnText = submitBtn.find('.btn-text');
        let spinner = submitBtn.find('.spinner-border');

        // Clear previous errors and alerts
        form.find('.error').text('');
        alertBox.addClass('d-none').text('');

        // Show spinner
        btnText.text('Updating...');
        spinner.removeClass('d-none');
        submitBtn.prop('disabled', true);

        $.ajax({
            url: actionUrl,
            type: 'POST',
            data: formData,
            success: function(response) {
                if(response.success) {
                    alertBox.removeClass('d-none alert-danger')
                            .addClass('alert-success')
                            .text(response.message);

                    // Update placeholders on page
                    // Assuming placeholders have classes like .clazz-id-container, .residence-container, .new-or-continuing-container
                    let updatedData = form.serializeArray();
                    $.each(updatedData, function(_, field) {
                        let container = $('.' + field.name.replace('_','-') + '-container');
                        if(container.length) {
                            container.text(field.value);
                        }
                    });

                    // Optionally close offcanvas after short delay
                    setTimeout(function() {
                        form.closest('.offcanvas').offcanvas('hide');
                    }, 1500);
                }
            },
            error: function(xhr) {
                if(xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        form.find('.error-' + key).text(value[0]);
                    });
                } else if(xhr.status === 403) {
                    let message = 'Unauthorized action. You do not have permission.';

                    // If your backend returns JSON with a "message" field
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    // If it’s plain text
                    else if (xhr.responseText) {
                        message = xhr.responseText;
                    }

                    alertBox.removeClass('d-none alert-success')
                            .addClass('alert-danger')
                            .text(message);

                } else if(xhr.status === 500) {
                    alertBox.removeClass('d-none alert-success')
                            .addClass('alert-danger')
                            .text('Server error occurred. Please try again later.');
                } else {
                    alertBox.removeClass('d-none alert-success')
                            .addClass('alert-danger')
                            .text('Something went wrong. Please try again.');
                }
            },
            complete: function() {
                // Reset button state
                btnText.text('Update Info');
                spinner.addClass('d-none');
                submitBtn.prop('disabled', false);
            }
        });
    });

});
</script>
@endsection