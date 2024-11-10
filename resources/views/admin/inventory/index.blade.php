@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))

@section('pageheader', 'Inventory Overview')
@section('pageheaderDescription', 'Avoid Stockouts and Overstocking')

@section('pageheader-controls')
<a href="" data-bs-toggle="modal" data-bs-target="#createInventoryItemModal" class="px-2 py-1 rounded-4 font-12 border border-primary text-primary">New Item</a>
<a href="{{ route('staff.trash') }}" class="px-2 py-1 rounded-4 font-12 border border-primary text-primary">Trash</a>
@endsection

    
@section('content')

<div class="row mt-3">

 <div class="col-12 col-sm-6 col-lg-3 mb-lg-4 mb-3">
  <div class="card border border-primary rounded-3">
    <div class="card-body p-3 d-flex">
      <div class="py-3 px-2 ">
        <a href="">
          <i class="mdi mdi-account-bo">UGX</i>
        </a>
      </div>
     <div class="px-3">
      <small class="mb-0 fw-light fs-5"><i>Inventory</i></small>
      <h1 class="mb-0 font-20 fw-bold py-3">{{ number_format(309089768, 2) }}</h1>
     </div>
    </div>
  </div>
</div>


<div class="col-12 col-sm-6 col-lg-3 mb-lg-4 mb-3">
 <div class="card border border-primary rounded-3">
   <div class="card-body p-3 d-flex">
     <div class="py-3 px-2 ">
       <a href="">
         <i class="mdi mdi-account-bo">UGX</i>
       </a>
     </div>
    <div class="px-3">
     <h1 class="mb-0 font-20 fw-bold">{{ number_format(309089768, 2) }}</h1>
     <small class="mb-0 fw-light fs-5"><i>Stock Out</i></small>
    </div>
   </div>
 </div>
</div>

<div class="col-12 col-sm-6 col-lg-3 mb-lg-4 mb-3">
 <div class="card border border-primary rounded-3">
   <div class="card-body p-3 d-flex">
     <div class="py-3 px-2 ">
       <a href="">
         <i class="mdi mdi-account-bo"></i>
       </a>
     </div>
    <div class="px-3">
     <h1 class="mb-0 font-20 fw-bold">{{ 3 }}</h1>
     <small class="mb-0 fw-light fs-5"><i>Product Requests</i></small>
    </div>
   </div>
 </div>
</div>

<div class="col-12 col-sm-6 col-lg-3 mb-lg-4 mb-3">
 <div class="card border border-primary rounded-3">
   <div class="card-body p-3 d-flex">
     <div class="py-3 px-2 ">
       <a href="">
         <i class="mdi mdi-account-bo"></i>
       </a>
     </div>
    <div class="px-3">
     <h1 class="mb-0 font-20 fw-bold">{{ 3 }}</h1>
     <small class="mb-0 fw-light fs-5"><i>Purchase Orders</i></small>
    </div>
   </div>
 </div>
</div>

<div class="col-6 col-lg-6 mb-3">
 <div class="card border border-primary rounded-3">
  <div class="card-header bg-white">
   <h5 class="card-title mb-0 fw-light fst-italic">Recent Stock Outs</h5>
  </div>
   <div class="card-body p-3 d-flex">
     
   </div>
 </div>
</div>

</div>

@endsection
