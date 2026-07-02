<div
    class="offcanvas offcanvas-start w-lg-50"
    data-bs-scroll="true"
    tabindex="-1"
    id="{{ 'updateStudentPersonalInfoOffCanvas'.$student->uuid }}"
    aria-labelledby="Enable both scrolling & backdrop"
>
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="Enable both scrolling & backdrop">
            Update Student Personal Info
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
        <form id="updateStudentPersonalInfoForm{{ $student->uuid }}" 
              action="{{ route('students.updatePersonalInfo', $student->uuid) }}" 
              method="POST" class="row">
            @csrf
            <div class="col-lg-6 mb-3">
                <label for="firstName">First Name</label>
                <input type="text" name="first_name" 
                       value="{{ old('first_name') ?? $student->first_name }}" 
                       class="form-control" />
                <small class="text-danger error-first_name error">
                    {{ $errors->first('first_name') }}
                </small>
            </div>

            <div class="col-lg-6 mb-3">
                <label for="lastName">Last Name</label>
                <input type="text" name="last_name" 
                       value="{{ old('last_name') ?? $student->last_name }}" 
                       class="form-control" />
                <small class="text-danger error-last_name error">
                    {{ $errors->first('last_name') }}
                </small>
            </div>

            <div class="col-lg-6 mb-3">
                <label for="gender">Gender</label>
                <select name="gender" class="form-control">
                    <option value="male" {{ $student->gender == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ $student->gender == 'female' ? 'selected' : '' }}>Female</option>
                </select>
                <small class="text-danger error-gender error">
                    {{ $errors->first('gender') }}
                </small>
            </div>

            <div class="col-lg-6 mb-3">
                <label for="dob">Date of Birth</label>
                <input type="date" name="dob" 
                       value="{{ old('dob') ?? $student->date_of_birth }}" 
                       class="form-control" />
                <small class="text-danger error-dob error">
                    {{ $errors->first('dob') }}
                </small>
            </div>

            <div class="col-lg-6 mb-3">
                <label for="country">Nationality</label>
                <input type="text" name="country" 
                       value="{{ old('country') ?? $student->nationality }}" 
                       class="form-control" />
                <small class="text-danger error-country error">
                    {{ $errors->first('country') }}
                </small>
            </div>

            <div class="col-lg-6 mb-3">
                <label for="city">City</label>
                <input type="text" name="city" 
                       value="{{ old('city') ?? $student->city }}" 
                       class="form-control" />
                <small class="text-danger error-city error">
                    {{ $errors->first('city') }}
                </small>
            </div>

            <div class="col-lg-6 mb-3">
                <label for="address">Address</label>
                <input type="text" name="address" 
                       value="{{ old('address') ?? $student->address }}" 
                       class="form-control" />
                <small class="text-danger error-address error">
                    {{ $errors->first('address') }}
                </small>
            </div>


            <div class="col-lg-6 mb-3">
                <label for="phone">Phone</label>
                <input type="text" name="phone" 
                       value="{{ old('phone') ?? $student->phone }}" 
                       class="form-control" />
                <small class="text-danger error-phone error">
                    {{ $errors->first('phone') }}
                </small>
            </div>

            <div class="col-lg-6 mb-3">
                <label for="nin">NIN</label>
                <input type="text" name="nin" 
                       value="{{ old('nin') ?? $student->nin }}" 
                       class="form-control" />
                <small class="text-danger error-nin error">
                    {{ $errors->first('nin') }}
                </small>
            </div>

            <div class="col-12 mt-3">
                <button type="submit" class="btn btn-primary w-100">
                    <span class="btn-text">Update Info</span>
                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                </button>
            </div>

        </form>
    </div>
</div>