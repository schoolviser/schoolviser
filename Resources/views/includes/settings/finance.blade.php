<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-lg-12 text-uppercase">
                <small class="mb-0 p-0 fw-bold">{{ 'Finance & Payments Settings' }}</small>
            </div>
        </div>
    </div>
    <div class="card-body">
      <ul class="list-unstyled">
        @usertype('master')<li><a href="{{route('site.settings.mtn.momo')}}" class=" link rounded-1">MTN Momo</a></li>@endusertype
      </ul>
    </div>
  </div>
