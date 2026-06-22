<div class="col-lg-12">
  @if (session('updated'))
      <div
       class="alert alert-success alert-dismissible fade show"
       role="alert"
      >
       <button
         type="button"
         class="btn-close"
         data-bs-dismiss="alert"
         aria-label="Close"
       ></button>
      
       {{session('updated')}}
      </div>
      
  @endif
 </div>