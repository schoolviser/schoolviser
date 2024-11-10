@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))

@section('pageheader', 'Library')
@section('pageheaderDescription', 'Manage Your Library Items')

@section('pageheader-controls')

@endsection

 @section('content')
     <div class="row">

      <div class="col-12 col-sm-6 col-lg-3 mb-lg-4 mb-3">
        <div class="card rounded-3 border border-primary">
          <div class="card-body p-3 d-flex">
            <i class="mdi mdi-account py-3 px-2" style=""></i>
           <div class="px-3">
            <h1 class="mb-0 font-20 fw-bold">Books</h1>
            <small class="mb-0 fw-light fs-5"><i>3000</i></small>
           </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-sm-6 col-lg-3 mb-lg-4 mb-3">
        <div class="card rounded-3 border border-primary">
          <div class="card-body p-3 d-flex">
            <i class="mdi mdi-account py-3 px-2" style=""></i>
           <div class="px-3">
            <h1 class="mb-0 font-20 fw-bold">Authors</h1>
            <small class="mb-0 fw-light fs-5"><i>4000</i></small>
           </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-sm-6 col-lg-3 mb-lg-4 mb-3">
        <div class="card rounded-3 border border-primary">
          <div class="card-body p-3 d-flex">
            <i class="mdi mdi-account py-3 px-2" style=""></i>
           <div class="px-3">
            <h1 class="mb-0 font-20 fw-bold">Checkouts</h1>
            <small class="mb-0 fw-light fs-5"><i>20</i></small>
           </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-sm-6 col-lg-3 mb-lg-4 mb-3">
        <div class="card rounded-3 border border-primary">
          <div class="card-body p-3 d-flex">
            <i class="mdi mdi-account py-3 px-2" style=""></i>
           <div class="px-3">
            <h1 class="mb-0 font-20 fw-bold text-danger">Overdue</h1>
            <small class="mb-0 fw-light fs-5"><i>20</i></small>
           </div>
          </div>
        </div>
      </div>

     </div>
 @endsection