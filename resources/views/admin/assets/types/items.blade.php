@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))


@section('pageheader', Str::plural($asset_type->name))
@section('pageheaderDescription', 'Asset type items')

@section('pageheader-controls')
<a href="{{ route('assets.add') }}" class="px-3 py-1 rounded-5  font-12 border border-primary text-primary">Add Asset Type</a>
<a href="{{ route('assets.add') }}" class="px-2 py-1 rounded-4  font-12 border border-primary text-primary">Add Asset</a>
@inject('assetType', 'App\Models\Asset\AssetType')
<div class="btn-group">
  <button class="px-2 py-1 rounded-4  font-12 border border-primary text-primary"
    type="button"
    id="triggerId"
    data-bs-toggle="dropdown"
    aria-haspopup="true"
    aria-expanded="false"
  >
    Asset Types
  </button>
  <div class="dropdown-menu dropdown-menu-start" aria-labelledby="triggerId">
    @foreach ($assetType::all() as $type)
    <a class="dropdown-item fw-light font-12" href="{{ route('assets.types.items', ['id' => $type->id]) }}">{{ $type->name }}</a>
    @endforeach
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="#">After divider action</a>
  </div>
</div>

@endsection
@section('where-am-i')
<a href="{{route('dashboard')}}" class="font-10 py-1 px-2 rounded-4 my-1 fw-light text-dark">Dashboard</a>
<a href="" class="font-10 py-1 px-1 rounded-4 my-1 fw-bold">></a>
<a href="{{route('assets')}}" class="font-10 py-1 px-2 rounded-4 my-1">Assets</a>
<a href="" class="font-10 py-1 px-1 rounded-4 my-1 fw-bold">></a>
<a href="{{route('assets.types')}}" class="font-10 py-1 px-2 rounded-4 my-1">Asset Types</a>
<a href="" class="font-10 py-1 px-1 rounded-4 my-1 fw-bold">></a>
<a href="{{route('assets.types.items', ['id' => $asset_type->id])}}" class="font-10 py-1 px-2 rounded-4 my-1">{{ $asset_type->name }}</a>
@endsection

@section('content')

<div class="row mt-">
 <div class="col-lg-12">
  @include('dashboard.includes.alerts.deleted')
  @include('dashboard.includes.alerts.created')
</div>

@inject('employeeModel', '\App\Models\Employee\Employee')
@php
    $employees = $employeeModel::all();
@endphp

 @if (count($asset_type->items) > 0)
 <div class="col-xl-12">
  <div class="table-responsive border rounded-3 border-light">
    <table class="table table-hover table-striped table-bordered font">
      <thead>
        <thead class="text-capitalize fw-light">
          <th>SN</th>
          <th></th>
          <th>Serial Number</th>
          <th>Name</th>
          <th>Location</th>
          <th>Custodian</th>
          <th>Status</th>
          <th></th>
        </thead>
      </thead>
      <tbody>
         @foreach ($asset_type->items as $asset)
         <tr>
          <td>{{ $loop->index + 1 }}</td>
          <td><img src="{{ asset($asset->photo) }}" alt=""></td>
          <td>{{ $asset->serial_number }}</td>
          <td>
            <small class="px-2 py-1 font-12 mb-1 fw-bold">{{ $asset->name }}</small><br />
            @if ($asset->type)
            <small class="px-2 rounded-3 fw-light">{{ $asset->type->name }}</small>
            @endif
          </td>
          
          <td>
            <small class="bg-light rounded-3 px-2 py-1 font-12 mb-1 fw-bolder text-capitalize">{{ ($asset->location) ? $asset->location->name : 'Not specified' }}</small><br class="my-1" />
            <small class=" px-2  fw-light bg-light text-capitalize">{{ ($asset->location) ? $asset->location->building->name : 'Not specified' }}</small>
          </td>
          <td>
            @if ($asset->custodian)
            <small class="bg-light rounded-3 px-2 py-1 font-14 mb-1 fw-light fst-italic text-capitalize">{{ ($asset->custodian) ? $asset->custodian->first_name.' '.$asset->custodian->last_name : '' }}</small><br class="my-1" />
            @endif
          </td>
          @if ($asset->checked_out)
          <td>
            <span class="bg-liht rounded-3 px-2 border border-primary font-12">Checked Out</span>
            <span class="bg-liht rounded-3 px-2 border border-primary font-12">{{ $asset->transaction->date }}</span><br />
            <small class="bg-liht rounded-3 px-2 border border-primary font-12">{{ ($asset->transaction->employee) ? $asset->transaction->employee->first_name.' '.$asset->transaction->employee->last_name : '' }}</small><br />
            <small class="bg-warning border border-danger px-2 rounded-3 font-weight-bold">{{ 'Due: '.$asset->transaction->due_date }}</small>
          </td>
          @else
            <td>
              <span class="bg-light rounded-3 fst-italic font-12 border border-primary px-2">{{ 'Available' }}</span>
              <br />

              <a href="" class="border border-primary px-2 rounded-2 bg-primary text-white font-12" data-bs-toggle="modal" data-bs-target="{{ '#assetCheckoutModal'.$asset->id }}">Check Out</a>
              <div id="{{ 'assetCheckoutModal'.$asset->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <form class="modal-content" action="{{route('assets.checkout', ['id' => $asset->id])}}" method="POST">
                    @csrf
                    <div class="modal-header">
                      <h5 class="modal-title font-12" id="my-modal-title">Check Out Asset</h5>
                      <a class="close font-12 cursor-pointer" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">Close</span>
                      </a>
                    </div>
                    <div class="modal-body row">
                      <div class="col-lg-12">
                        <span class="border border-primary py-2 px-3 rounded-4">{{ $asset->serial_number }}</span>
                        <span class="border border-primary py-2 px-3 rounded-4 mx-1">{{ $asset->name }}</span>
                        <hr />
                      </div>
                      <div class="col-lg-12 my-2">
                        <label for="employee" class="font-12 text-muted mb-1">Check Out To</label>
                        <select name="employee" id="" class="form-control">
                          <option value="">Choose Employee</option>
                          @foreach ($employees as $employee)
                              <option value="{{ $employee->id }}" {{ (old('employee') == $employee->id) ? 'checked' : '' }}>{{ $employee->first_name.' '.$employee->last_name }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-lg-6 my-2">
                        <label for="check_out_date" class="font-12 mb-1 text-muted">Check Out Date</label>
                        <input type="date" name="check_out_date" class="date form-control" id="date" value="{{ old('check_out_date') }}" />
                        <small class="text-danger font-12">{{ $errors->first('check_out_date') }}</small>
                      </div>
                      <div class="col-lg-6 my-2">
                        <label for="dueDate" class="font-12 mb-1 text-muted">Due Date</label>
                        <input type="date" name="due_date" class="date form-control" id="dueDate" value="{{ old('due_date') }}" />
                        <small class="text-danger font-12">{{ $errors->first('due_date') }}</small>
                      </div>
                      <div class="col-lg-12 my-2">
                        <textarea name="note" id="" cols="5" rows="5" class="form-control">{{old('note')}}</textarea>
                      </div>
                    </div>
                    <div class="modal-footer text-uppercase">
                      <a class="btn btn-md btn-warning rounded-4 cursor-pointer w-25" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">Close</span>
                      </a>
                      <button type="submit" class="btn btn-primary btn-md rounded-4 w-25 text-uppercase font-12">Check Out</button>
                    </div>
                  </form>
                </div>
              </div>
            </td>
          @endif
          
          <td>
            <a href="{{route('assets.show', ['id' => $asset->id])}}" class="font-12 border border-primary px-2 py-1 rounded-4 text-primary">Show Details</a>
            <a href="{{route('assets.destroy', ['id' => $asset->id])}}" class="font-12 border border-danger text-danger px-2 py-1 rounded-4">Delete</a>
          </td>
         </tr>
         @endforeach
      </tbody>
    </table>
  </div>
 </div>
 @else
     <div class="col-lg-12 text-center py-5">
       <img src="{{ asset('icons/empty.png') }}" alt="" class="img-fluid">
       <h6 class="text-muted py-5">
         Nothing in the database ......!
       </h6>
     </div>
 @endif
</div>

@endsection
