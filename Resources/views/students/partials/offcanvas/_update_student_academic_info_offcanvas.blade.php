<div
    class="offcanvas offcanvas-start"
    data-bs-scroll="true"
    tabindex="-1"
    id="{{ 'updateStudentAcademicInfoOffCanvas'.$student->id }}"
    aria-labelledby="Enable both scrolling & backdrop"
>
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="Enable both scrolling & backdrop">
            Update Student Academic Info
        </h5>
        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="offcanvas"
            aria-label="Close"
        ></button>
    </div>

    <div class="offcanvas-body">
        
        <div class="alert alert-danger d-none" role="alert"></div>

        <form id="updateStudentAcademicInfoForm{{ $registration->id }}"
              action="{{ route('students.updateAcademicInfo', ['termly_registration_id' => $registration->id, 'student_id' => $student->uuid]) }}"
              method="POST" class="row">
            @csrf

            <input type="hidden" name="student_id" value="{{ $registration->student_id }}">
            <input type="hidden" name="term_id" value="{{ term()->id }}">

            <!-- Class -->
            <div class="col-lg-12 mb-3">
                <label for="clazzId" class="font-10 text-muted">Class</label>
                <select name="clazz_id" id="clazzId" class="form-control">
                    @foreach (clazzes() as $clazz)
                        <option value="{{ $clazz->id }}"
                            {{ $clazz->id == $registration->clazz_id ? 'selected' : '' }}
                            class="text-capitalize">
                            {{ $clazz->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Residence -->
            <div class="col-lg-12 mb-3">
                <label for="residence" class="font-10 text-muted">Residence</label>
                <select name="residence" id="residence" class="form-control">
                    <option value="boarding" {{ $registration->residence === 'boarding' ? 'selected' : '' }}>Boarding</option>
                    <option value="day" {{ $registration->residence === 'day' ? 'selected' : '' }}>Day</option>
                </select>
            </div>

            <!-- New or Continuing -->
            <div class="col-lg-12 mb-3">
                <label for="newOrContinuing" class="font-10 text-muted">Status</label>
                <select name="new_or_continuing" id="newOrContinuing" class="form-control">
                    <option value="new" {{ $registration->new_or_continuing === 'new' ? 'selected' : '' }}>New</option>
                    <option value="continuing" {{ $registration->new_or_continuing === 'continuing' ? 'selected' : '' }}>Continuing</option>
                </select>
            </div>

            <!-- Submit -->
            <div class="col-lg-12 mt-3">
                <button type="submit" class="btn btn-primary w-100">
                    <span class="btn-text">Update Info</span>
                    <span class="spinner-border spinner-border-sm d-none"></span>
                </button>
            </div>
        </form>
    </div>
</div>