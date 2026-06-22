<!-- Update Personal Info Offcanvas -->
<div class="offcanvas offcanvas-start rounded-start-3" data-bs-backdrop="static" tabindex="-1" id="updateInfo" aria-labelledby="staticBackdropLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="staticBackdropLabel">
        Update Info
        </h5>
        <button
        type="button"
        class="btn-close"
        data-bs-dismiss="offcanvas"
        aria-label="Close"
        ></button>
    </div>
    <div class="offcanvas-body">
    <form action="{{ route('tertiary.students.updatePersonalInfo', ['id' => $student->id]) }}" method="POST" class="row">
    @csrf

    <div class="col-lg-6">
        <label for="firstName">First Name</label>
        <input type="text" name="first_name" value="{{ old('first_name') ?? $student->first_name }}" class="form-control">
        <small class="text-danger">{{ $errors->first('first_name') }}</small>
    </div>

    <div class="col-lg-6">
        <label for="lastName">Last Name</label>
        <input type="text" name="last_name" value="{{ old('last_name') ?? $student->last_name }}" class="form-control">
        <small class="text-danger">{{ $errors->first('last_name') }}</small>
    </div>

    <div class="col-lg-12">
        <label for="nin">NIN</label>
        <input type="text" name="nin" value="{{ old('nin') ?? $student->nin }}" class="form-control">
        <small class="text-danger">{{ $errors->first('nin') }}</small>
    </div>

    <div class="col-lg-6">
        <label for="lastName">DOB</label>
        <input type="date" name="dob" value="{{ old('dob') ?? $student->date_of_birth }}" class="form-control">
        <small class="text-danger">{{ $errors->first('dob') }}</small>
    </div>

    <div class="col-lg-6">
        <label for="lastName">Gender</label>
        <select name="gender" id="" class="form-control">
        <option value="male">Male</option>
        <option value="female">Female</option>
        </select>
        <small class="text-danger">{{ $errors->first('gender') }}</small>
    </div>

    <div class="col-lg-6">
            <label for="nin">Nationality</label>
            <input type="text" name="nationality" value="{{ old('nationality') ?? $student->nationality }}" placeholder="Nationality" class="form-control">
            <small class="text-danger">{{ $errors->first('nationality') }}</small>
    </div>

    <div class="col-lg-6">
            <label for="city">City</label>
            <input type="text" name="city" value="{{ old('city') ?? $student->city }}" class="form-control">
            <small
            class="text-danger">{{ $errors->first('city') }}</small>
    </div>

    <div class="col-lg-6">
            <label for="phone">Phone</label>
            <input type="text" name="phone" value="{{ old('phone') ?? $student->phone }}" placeholder="Phone Number" class="form-control">
            <small
            class="text-danger">{{ $errors->first('phone') }}</small>
    </div>

    <div class="col-lg-12 my-4">
        <button type="submit" class="btn btn-md btn-dark w-100">Update Details</button>
    </div>

    </form>
    </div>
</div>