@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))

@section('pageheader', 'Inventory Products')
@section('pageheaderDescription', 'My Dashboard')

@section('pageheader-controls')
<a href="" data-bs-toggle="modal" data-bs-target="#createInventoryItemModal" class="px-2 py-1 rounded-4 font-12 border border-primary text-primary">New Product</a>
<a href="{{ route('staff.trash') }}" class="px-2 py-1 rounded-4 font-12 border border-primary text-primary">Trash</a>
@endsection

    
@section('content')

<div class="row mt-4">
 <div class="col-lg-12">
  @include('dashboard.includes.alerts.created')
  @include('dashboard.includes.alerts.updated')
 </div>
 <div class="col-lg-12">
  <div class="table-responsive">
   
   <table  class="table table-bordered table-stripped" >
   
    <thead>
      <th>ID</th>
      <th>Code</th>
      <th>Item Name</th>
      <th>Unit Of Measure</th>
      <th></th>
    </thead>

    <tbody>
     @foreach ($inventoryItems as $item)
     <tr class="">
      <td>{{$loop->index + 1}}</td>
      <td>{{ $item->code }}</td>
      <td>{{ $item->name }}</td>
      <td>{{ ($item->unitOfMeasure) ? $item->unitOfMeasure->name : '' }}</td>
      <td>
       <a href="{{ route('inventory.items.delete', ['id' => $item->id]) }}" class="btn btn-md px-3 rounded-5 text-danger border-danger border">Delete</a>
      </td>
     </tr>
     @endforeach
    </tbody>

   </table>
  </div>
  
 </div>
</div>

<div class="modal fade" id="createInventoryItemModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
 
 <div
  class="modal-dialog modal-dialog-scrollable modal-sm"
  role="document"
 >
  <form class="modal-content" action="{{ route('inventory.items.store') }}" method="POST">
   @csrf
   <div class="modal-header">
    <h5 class="modal-title font-14" id="modalTitleId">
     Add New Product
    </h5>
    <button
     type="button"
     class="btn-close"
     data-bs-dismiss="modal"
     aria-label="Close"
    ></button>
   </div>
   <div class="modal-body row">
    <div class="col-lg-12">
     <input type="text" name="name" class="form-control" placeholder="Product Name" />
     <small class="text-danger">{{ $errors->first('name') }}</small>
    </div>
    <div class="col-lg-12 my-2">
      <input type="text" name="code" class="form-control" placeholder="Product Code" />
      <small class="text-danger">{{ $errors->first('code') }}</small>
     </div>
    <div class="col-lg-12 my-1">
     @inject('unitOfMeasures', 'App\Models\UnitOfMeasure')
     <select name="unit_of_measure" id="" class="form-control">
      <option value="" selected>Choose Unit Of Measure</option>
      @foreach ($unitOfMeasures::all() as $unit)
          <option value="{{ $unit->id }}">{{ $unit->name }}</option>
      @endforeach
     </select>
     <small class="text-danger">{{ $errors->first('unit_of_measure') }}</small>

    </div>
   </div>
   <div class="modal-footer">
    <button
     type="button"
     class="btn btn-danger btn-md rounded-4 w-25"
     data-bs-dismiss="modal"
    >
     Close
    </button>
    <button type="submit" class="btn btn-primary btn-md rounded-4 w-25">Save</button>
   </div>
  </form>
 </div>
</div>


@endsection
