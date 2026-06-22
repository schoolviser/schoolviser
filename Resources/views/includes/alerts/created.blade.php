<div class="col-lg-12">
 @if (session('created'))
 <div class="alert alert-success alert-dismissible fade show" role="alert">
  <button
    type="button"
    class="btn-close"
    data-bs-dismiss="alert"
    aria-label="Close"
  ></button>
  {{session('created')}}
  @if (session('action'))
  <small class="text-small"><a href="{{ session('action')->url }}">{{ session('action')->label }}</a></small>
  @endif
</div>
     
 @endif
</div>