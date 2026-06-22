<div class="col-lg-12">
 @if (session('restored'))
     <div
      class="alert alert-primary alert-dismissible fade show"
      role="alert"
     >
      <button
        type="button"
        class="btn-close"
        data-bs-dismiss="alert"
        aria-label="Close"
      ></button>
     
      {{ session('restored') }}
     </div>
     
 @endif
</div>