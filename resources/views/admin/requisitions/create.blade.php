@extends('layouts.master')

@section('pageheader', 'Make Requisition')

@section('pageheader-controls')
<a href="{{ route('requisitions.purchase.create') }}" class="d-inline text-small text-muted cursor-pointer font-weight-bold text-primary">Make Purchase Requisition</a>
<div class="d-inline px-2">|</div>
<a href="{{ route('requisitions') }}" class="d-inline text-small text-muted cursor-pointer font-weight-bold text-primary">My Requisitions</a>
@endsection

@section('content')
<form action="" class="row">

 <div class="col-lg-7">
  <div class="card">
   <div class="card-body p-3 row">

    <div class="col-lg-6">
     <label for="requisitionNumber" class="text-muted font-12">Requisition Number</label>
     <input type="text" name="requisition_number" value="{{old('requisition_number')}}" placeholder="Requisition Number" class="form-control" id="requisitionNumber" />
     <small class="text-danger font-12">{{ $errors->first('requisition_number') }}</small>
    </div>

    <div class="col-lg-6">
     <label for="financialYear" class="text-muted font-12">Financial Year</label>
     <input type="text" name="financial_year" placeholder="Financial Year" value="{{ old('financial_year') ?? '2023/2024' }}" class="form-control" readonly>
    </div>

    <div class="col-lg-6">
     <label for="department" class="font-12 text-muted">Department</label>
     <select name="department" id="" class="form-control">
      <option value="1">Science & Technology</option>
      <option value="1">Physics</option>
     </select>
     <small class="text-danger font-12">{{ $errors->first('department') }}</small>
    </div>

    <div class="col-lg-6">
     <label for="financialYear" class="text-muted font-12">Requisition Type</label>
     <input type="text" name="type" placeholder="Financial Year" value="Purchase Requisition" class="form-control" readonly>
    </div>

    <div class="col-lg-12 py-2">
     <div class="form-check form-check-inline">
      <input id="my-input" class="form-check-input" type="checkbox" name="send_for_approval" value="true">
      <label for="my-input" class="form-check-label font-12 ">Send For Approval</label>
     </div>
    </div>

   </div>
  </div>
 </div>

 <div class="col-lg-5">
  <div class="card mb-2">
   <div class="card-body py-2 px-3">
    <h6>Add Requisition Items</h6>
   </div>
  </div>
  <div class="card">
   <div class="card-body p-3 row">

    <div class="col-lg-6">
     <label for="itemName" class="text-muted font-12">Item Name</label>
     <input type="text" name="name" value="{{old('name')}}" placeholder="Item Name" class="form-control" id="itemName" />
     <small class="text-danger font-12">{{ $errors->first('name') }}</small>
    </div>

    <div class="col-lg-3">
     <label for="quantity" class="text-muted font-12">Quantity</label>
     <input type="text" name="quantity" placeholder="0" value="{{ old('quantity') }}" class="form-control" />
    </div>


    <div class="col-lg-3">
     <label for="rate" class="text-muted font-12">Rate</label>
     <input type="text" name="rate" placeholder="Unit Cost" value="0" class="form-control" />
    </div>

   </div>
  </div>
 </div>

 <div class="col-lg-12 py-2 text-end">
  <button type="submit" class="btn btn-md btn-primary">Save Requisition</button>
 </div>
</form>
@endsection
