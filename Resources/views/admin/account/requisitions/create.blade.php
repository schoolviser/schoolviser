@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))


@section('pageheader', 'Make Requisitions')
@section('pageheaderDescription', 'My Requisitions')

@section('pageheader-controls')

<div class="d-inline px-2">|</div>

<a href="{{ route('account.make.requisitions') }}" class="d-inline font-12 cursor-pointer font-weight-bold text-primary"></a>


@endsection

@section('content')
<form class="row mt-4" method="POST" action="{{ route('account.make.requisitions.store') }}">
    @csrf

 <div class="col-lg-12 mb-2">
  <div class="card rounded-3">
   <div class="card-body row p-3">

    <div class="col-lg-6">
     <label for="date" class="font-12 text-muted mb-2">Description</label>
     <input type="text" name="description" class="form-control" placeholder="Description" value="{{ old('description') }}" />
     <small class="text-danger">{{ $errors->first('description') }}</small>
    </div>

    <div class="col-lg-3">
     <label for="date" class="font-12 text-muted mb-2">Date</label>
     <input type="date" name="date" class="form-control" placeholder="Date" value="{{ old('date') }}" />
     <small class="text-danger">{{ $errors->first('date') }}</small>
    </div>

    <div class="col-lg-3">
     <label for="department" class="font-12 text-muted mb-2">Department</label>
     <select name="department" id="" class="form-control">
      <option value="" selected>Choose Department</option>
      @foreach ($departments as $department)
      <option value="{{ $department->id }}">{{ $department->name }}</option>
      @endforeach
     </select>
     <small class="text-small text-danger">{{ $errors->first('department') }}</small>
    </div>

    <div class="col-lg-12 py-4">
     <div class="custom-control custom-checkbox">
      <input id="my-input" class="custom-control-input" type="checkbox" name="" value="true">
      <label for="my-input" class="custom-control-label text-small text-muted">Send For Approval</label>
     </div>
    </div>
    
   </div>
  </div>
 </div>

 @inject('unitOfMeasure', '\App\Models\UnitOfMeasure')
 @php
     $unitOfMeasures = $unitOfMeasure::all();
 @endphp

 <div class="col-lg-12 my-2">
  <div class="card">
   <div class="card-header">
    <h6 class="card-title mb-0 text-muted">Requisition Items</h6>
   </div>
   <div class="card-body table-responsive p-0">
   
    <table class="table table-striped table-bordered table-hover">
     <thead>
      <th>Item Name</th>
      <th>Quantity</th>
      <th>Unit Cost</th>
      <th>Unit Of Measure</th>
     </thead>
     <tbody>
      @for ($i = 0; $i < 10; $i++)
          <tr>
           <td><input type="text" name="items[{{$i}}][name]" class="form-control" placeholder="Item Name" /></td>
           <td><input type="text" name="items[{{$i}}][quantity]" class="form-control" placeholder="Quantity" /></td>
           <td><input type="text" name="items[{{$i}}][rate]" class="form-control" placeholder="Unit Cost" /></td>
           <td>
            <select name="items[{{$i}}][unit_of_measure]" id="" class="form-control">
             <option value="">Choose Unit Of Measure</option>
             @foreach ($unitOfMeasures as $measure)
                <option value="{{ $measure->abbr }}">{{ $measure->name }}</option>
             @endforeach
            </select>
           </td>
          </tr>
      @endfor
     </tbody>
    </table>


   </div>
  </div>
 </div>

 <div class="col-lg-12 py-3">
  <button type="submit" class="btn btn-md btn-primary rounded-5 w-100">Save</button>
 </div>

</form>
@endsection
