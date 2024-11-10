<div class="{{ $htmlClasses }}">
  <div class="card rounded-3">
    <div class="card-body row p-3">
      <div class="col-lg-1">
        <img src="{{ ($registration->student->photo) ? asset($registration->student->photo) : asset('images/avator.png') }}" alt="" class="img-fluid rounded-circle p-0">
      </div>
      <div class="col-lg-10 py-2 d-flex">
        <h4 class="mb-2 fs-3 fw-bold">{{ $registration->student->first_name.' '.$registration->student->last_name }}</h4>
        
      </div>
      <div class="col-lg-11 offset-lg-1">
        <div class="font-12 text-" style="font-weight: 600;">
          <small class="text-capitalize text-primary">{{ $registration->student->gender }}</small>
          <span class="px-1">|</span>
          <small class="text-capitalize text-success">{{ $registration->new_or_continuing }}</small>
          <span class="px-1">|</span>
          <small class="text-capitalize text-danger">{{ $registration->clazz->name }}</small>
          <span class="px-1">|</span>
          <small class="text-capitalize text-dark">{{ $registration->residence }}</small>
        </div>
      </div>
    </div>
  </div>
</div>