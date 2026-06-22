@extends(config('student.layout', 'student::layouts.master'))


@section('module-page-heading', 'Students Profile')

@section('module-links')
    <a href="{{ route('students.study.history', ['id' => $student->id]) }}">Study History</a>
@endsection


@section('where-am-i')

@endsection


@section('content')

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

      <!-- Student Photo -->
      <div class="col-lg-2">
        <img src="{{ asset($student->photo ?? config('defaults.avator')) }}" class="img-fluid rounded-circle student-avator w-100" alt="image" />
        <form action="{{ route('students.update.photo', ['id' => $student->id]) }}" method="POST" enctype="multipart/form-data" class="m-2">
          @csrf
          <label for="choosePhoto" class="custom-file-upload text-small bg-light px-2 py-1 rounded-4 border border-primary">
            Choose Photo
          </label>
          <input type="file" id="choosePhoto" name="photo" class="render-image-on-input-file-change d-none" data-imgholder=".student-avator" />
          <input type="submit" class="btn btn-sm btn-white border-primary rounded-4 " id="avatorChangeBtn" value="upload" />
          <small class="text-danger">{{ $errors->first('photo') }}</small>
        </form>
      </div>

       <!-- Student personal info -->
      <div class="col-12 col-sm-8 col-lg-10">
         <!-- Student personal info -->
         <div class="card rounded-3 border-0">
          <div class="card-body row p-lg-3">
            <div class="col-12 col-sm-12 col-lg-12">
              <h2 class="text-primary fw-bold mb-0 fs-3 font-20">{{ $student->first_name." ".$student->last_name}}</h2>
              <small class="text-end text-small    ">
                @if ($student->nin)
                    {{ $student->nin }}
                @endif
              </small>
              <hr />
            </div>
            @if ($student->nin)
            <div class="col-12 col-sm-6 col-lg-3 d-flex mb-3">
              <div class="pl-2">
                <span class="font-10 font-weight-bold text-muted text-uppercase">nin</span>
                <h5 class="mb-0 font-14 font-weight-semibold head-count">{{ $student->nin }}</h5>
              </div>
            </div>
            @endif
            @if ($student->regno ?? $student->id)
            <div class="col-12 col-sm-6 col-lg-3 d-flex mb-3">
              <div class="pl-2">
                <span class="font-10 font-weight-bold text-muted text-uppercase">RegNo</span>
                <h5 class="mb-0 font-14 font-weight-semibold head-count">{{ $student->regno ?? $student->id }}</h5>
              </div>
            </div>
            @endif
            @if ($student->nationality)
            <div class="col-12 col-sm-6 col-lg-3 d-flex mb-3">
              <div class="pl-2">
                <span class="font-10 font-weight-semibold text-muted text-uppercase">Nationality</span>
                  <h5 class="mb-0 font-14 font-weight-semibold head-count text-capitalize"> {{ $student->nationality }}</h5>
              </div>
            </div>
            @endif

            @if ($student->phone)
              <div class="col-12 col-sm-6 col-lg-3 d-flex">
                <div class="pl-2">
                  <span class="font-10 font-weight-semibold text-muted text-uppercase">Phone</span>
                  <h5 class="mb-0 font-14 font-weight-semibold head-count"> {{ $student->phone }}</h5>
                </div>
              </div>
            @endif

            @if ($student->email)
            <div class="col-12 col-sm-6 col-lg-3 d-flex mb-3">
              <div class="pl-2">
                <span class="font-10 font-weight-semibold text-muted text-uppercase">Email</span>
                <h5 class="mb-0 font-14 font-weight-semibold head-count"> {{ $student->email }}</h5>
              </div>
            </div>
            @endif
            <div class="col-12 col-sm-6 col-lg-3 d-flex">
              <div class="pl-2">
                <span class="font-10 font-weight-bold text-muted text-uppercase">Date Of Birth</span>
                <h5 class="mb-0 font-14 font-weight-light head-count"> {{ $student->dob }}</h5>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3 d-flex">
              <div class="pl-2">
                <span class="font-10 font-weight-semibold text-muted text-uppercase">Gender</span>
                <h5 class="mb-0 font-14 font-weight-light head-count text-capitalize"> {{ $student->gender }}</h5>
              </div>
            </div>
            @if ($student->address)
            <div class="col-12 col-sm-6 col-lg-3 d-flex mb-3">
              <div class="pl-2">
                <span class="font-10 font-weight-semibold text-muted text-uppercase">Address</span>
                <h5 class="mb-0 font-16 font-weight-semibold head-count"> {{ $student->address }}</h5>
              </div>
            </div>
            @endif


          </div>
         </div>

         @if ($student->currentTermlyRegistration)
         <div class="card rounded-3 border border-primary mt-3">
          <div class="card-header">
            <small>{{ 'Term '.$student->currentTermlyRegistration->term->term.' | '.$student->currentTermlyRegistration->term->year }}</small>
          </div>
          <div class="card-body row p-2">
              <div class="col-12 col-sm-6 col-lg-3 d-flex mb-3">
                <div class="pl-2">
                  <span class="font-10 font-weight-semibold text-muted text-uppercase px-2">Class</span>
                  <h5 class="mb-0 font-12 px-2 py-1 bg-light rounded-4"> {{ $student->currentTermlyRegistration->clazz->name }}</h5>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-lg-3 d-flex mb-3">
                <div class="pl-2">
                  <span class="font-10 font-weight-semibold text-muted text-uppercase px-2">section</span>
                  <h5 class="mb-0 font-12 px-2 py-1 bg-light rounded-4 text-capitalize"> {{ $student->currentTermlyRegistration->residence }}</h5>
                </div>
              </div>
              @if ($student->currentTermlyRegistration->hostel_id)
              <div class="col-12 col-sm-6 col-lg-3 d-flex mb-3">
                <div class="pl-2">
                  <span class="font-10 font-weight-semibold text-muted px-2 text-uppercase">Hostel</span>
                  <h5 class="mb-0 font-12 px-2 py-1 bg-light rounded-4 text-capitalize"> {{ $student->currentTermlyRegistration->hostel->name }}</h5>
                </div>
              </div>
              @endif
              @if ($student->currentTermlyRegistration->new_or_continuing)
              <div class="col-12 col-sm-6 col-lg-3 d-flex mb-3">
                <div class="pl-2">
                  <span class="font-10 font-weight-semibold text-muted text-uppercase px-2">New Or Continuing</span>
                  <h5 class="mb-0 font-12 px-2 py-1 bg-light rounded-4 text-capitalize"> {{ $student->currentTermlyRegistration->new_or_continuing }}</h5>
                </div>
              </div>
              @endif
          </div>
         </div>
         @else
             
         @endif
        
      </div>

    </div>
  </div>


 

</div>


@if ($student->currentTermlyRegistration)
    <!-- Update Registration Details Modal -->
<div id="editStudentRegistrationInfoModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <form class="modal-content" action="" method="POSt">
      @csrf
      <div class="modal-header font-10">
        <h5 class="modal-title" class="" id="my-modal-title">Update Registration Details</h5>
        <button class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-6">
            <label for="year" class="font-10 text-muted">Year</label>
            <input type="text" name="year" class="form-control" value="{{ old('year') ?? $student->currentTermlyRegistration->term->year }}" readonly />
          </div>
          <div class="col-lg-6">
            <label for="term" class="font-10 text-muted">Term</label>
            <input type="text" name="term" class="form-control" value="{{ old('term') ?? $student->currentTermlyRegistration->term->term }}" readonly />
          </div>
          <div class="col-lg-12">
            <label for="class" class="font-10 text-muted">Class</label>
            <select name="clazz_id" id="clazzId" class="form-control">
              @foreach (clazzs() as $clazz)
               <option value="{{ $clazz->id }}" {{ ($student->currentTermlyRegistration->clazz_id == $clazz->id) ? 'selected' : '' }}>{{ $clazz->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-lg-12">
            <label for="class" class="font-10 text-muted">Residence</label>
            <select name="residence" id="clazzId" class="form-control">
               <option value="day" {{ ($student->currentTermlyRegistration->residence == 'day') ? 'selected' : '' }}>Day</option>
               <option value="boarding" {{ ($student->currentTermlyRegistration->residence == 'boarding') ? 'selected' : '' }}>Boarding</option>
            </select>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-sm btn-primary">Update</button>
      </div>
    </form>
  </div>
</div>

@endif

@endsection
