@extends('layouts.master')

@section('pageheader', 'Requisitions Details')

@section('pageheader-controls')
<div class="d-inline px-2">|</div>
<a href="{{ route('students.trash') }}" class="d-inline text-small text-muted cursor-pointer font-weight-bold text-primary">Trash</a>
<div class="d-inline px-2">|</div>
<a href="{{ route('students.trash') }}" class="d-inline text-small text-muted cursor-pointer font-weight-bold text-primary">Suspended Students</a>
@endsection

@section('content')

<div class="row">

 <!-- Requester Details -->
  <div class="col-xl-12 mb-2">
    <div class="card p-0 bg-transparent">
      <div class="card-body row p-1">
        <div class="col-lg-1">
          <img src="{{ '' }}" alt="" class="img-fluid rounded-circle p-0">
        </div>
        <div class="col-lg-10 py-2">
          <h4 class="mb-0">{{ 'Stephen Okello OModing' }}</h4>
          <div class="font-12 text-muted">
            <small class="text-capitalize">{{ 'Head Teacher' }}</small>
            <span>|</span>
            <small>{{ 'Academics' }}</small>
            <span>|</span>
            <small class="text-capitalize">{{ 'date' }}</small>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Requisition Details -->
 <div class="col-lg-12 mb-2">
  <div class="card">
   <div class="card-body row p-3">

    <div class="col-lg-3 d-flex mb-3">
     <div class="pl-2">
       <span class="font-10 font-weight-bold text-uppercase">Requisition Number</span>
       <h5 class="mb-0 font-14 font-weight-semibold head-count">{{ '8634871 ' }}</h5>
     </div>
    </div>

    <div class="col-lg-3 d-flex mb-3">
     <div class="pl-2">
       <span class="font-10 font-weight-bold text-uppercase">Requisition Type</span>
       <h5 class="mb-0 font-14 font-weight-semibold head-count">{{ 'Purchase Requisition ' }}</h5>
     </div>
    </div>

    <div class="col-lg-3 d-flex mb-3">
     <div class="pl-2">
       <span class="font-10 font-weight-bold text-uppercase">Department</span>
       <h5 class="mb-0 font-14 font-weight-semibold head-count">{{ 'Academics' }}</h5>
     </div>
    </div>

    <div class="col-lg-3 d-flex mb-3">
     <div class="pl-2">
       <span class="font-10 font-weight-bold text-uppercase">Expense Category</span>
       <h5 class="mb-0 font-14 font-weight-semibold head-count">{{ 'Examination' }}</h5>
     </div>
    </div>
 
   </div>
  </div>
 </div>

 <!-- Requisition Items -->
 <div class="col-lg-12 mb-2">
  <div class="card">
   <div class="card-body p-1 px-3">
    <h4>Items</h4>
   </div>
  </div>
 </div>

  <div class="col-lg-12">
    <form class="table-responsive">
      <table class="table table-hover table-bordered table-striped">
        <thead>
         <th>SN</th>
          <th>Item Name</th>
          <th>Qty</th>
          <th>Rate</th>
          <th>Amount</th>
          <th>Adjusted Qty </th>
          <th>Adjusted Rate </th>
          <th>Amount</th>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>Dell Laptop</td>
            <td>2</td>
            <td><small>UGX</small>{{ number_format(2000000, 2) }}</td>
            <td><small>UGX</small>{{ number_format(4000000, 2) }}</td>
            <td>3</td>
            <td><small>UGX</small> {{ number_format(700000, 2) }}</td>
            <td><small>UGX</small> {{ number_format(700000, 2) }}</td>
          </tr>
          <tr style="font-weight: 800;">
           <td colspan="4"></td>
           <td><small>UGX</small>{{ number_format(2000000, 2) }}</td>
           <td colspan="2"></td>
           <td><small>UGX</small> {{ number_format(700000, 2) }}</td>
         </tr>
        </tbody>
      </table>
    </form>
  </div>
</div>

<div class="row">

</div>




@endsection
