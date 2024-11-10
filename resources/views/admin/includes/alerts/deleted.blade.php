<div class="col-lg-12">
 @if (session('deleted'))
 <div class="alert alert-danger alert-dismissible fade show" role="alert">
 <button
   type="button"
   class="btn-close"
   data-bs-dismiss="alert"
   aria-label="Close"
 ></button>
 {{ session('deleted') }}
</div>
 @endif
</div>