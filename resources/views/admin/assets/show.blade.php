@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))

@section('pageheader', 'Asset Details')
@section('pageheaderDescription', 'Track your assets easily ...')

@section('pageheader-controls')
<a href="{{ route('assets.add') }}" class="px-2 py-1 rounded-4  font-12 border border-primary text-primary">Add Asset</a>
<a href="{{ route('assets.types') }}" class="px-2 py-1 rounded-4  font-12 border border-primary text-primary">Asset Types</a>
@endsection
    
@section('content')

@inject('AssetType', 'App\Models\Asset\AssetType')
@inject('Building', 'App\Models\Building')
@inject('employee', 'App\Models\Employee\Employee')

@inject('assetPermission', '\App\AssetPermissionRegistrar')

@php
    $assetTypes = $AssetType::all();
    $buildings = $Building::with(['rooms'])->get();
    $employees = $employee::all();
@endphp

<div class="row mt-4">

  <div class="col-lg-12">
    @include('dashboard.includes.alerts.updated')
    @include('dashboard.includes.alerts.created')

  </div>

  
  <!-- Asset Photo -->
  <div class="col-lg-4 order-lg-2">
    <div class="card border border-primary">
      <div class="card-body p-0"><img src="{{asset($asset->photo ?? config('defaults.avator'))}}" alt="" class="img-fluid w-100 asset-imageholder"></div>
    </div>
    <form action="{{ route('assets.update.photo', ['id' => $asset->id]) }}" method="POST" enctype="multipart/form-data" class="m-2">
      @csrf
      <label for="choosePhoto" class="custom-file-upload text-small border border-primary px-2 rounded-4 py-1">
        Choose Photo
      </label>
      <input type="file" id="choosePhoto" name="photo" class="render-image-on-input-file-change d-none" data-imgholder=".asset-imageholder" />
      <input type="submit" class="btn btn-sm btn-white border border-primary px-2 rounded-4" id="avatorChangeBtn" value="Upload" />
      <small class="text-danger">{{ $errors->first('photo') }}</small>
    </form>
  </div>

  <div class="col-lg-8">
    <div class="card mb-3 rounded-3 border border-danger">
      <div class="card-body row py-2 px-3">

        @if ($asset->type)
        <div class="col-lg-4 d-flex mb-3">
          <div class="pl-2">
            <span class="font-10 text-muted text-uppercase">Asset Type</span>
            <h5 class="mb-0 font-14 fst-italicbg-light p-1 rounded-3">{{ $asset->type->name }}</h5>
          </div>
        </div>
        @endif

        @if ($asset->name)
        <div class="col-lg-3 d-flex mb-3">
          <div class="pl-2">
            <span class="font-10 font-weight-bold text-muted text-uppercase">Asset Name</span>
            <h5 class="mb-0 font-14 fst-italic head-count bg-light py-1 px-2 rounded-3">{{ $asset->name }}</h5>
          </div>
        </div>
        @endif

        @if ($asset->tag)
        <div class="col-lg-3 d-flex mb-3">
          <div class="pl-2">
            <span class="font-10 font-weight-bold text-muted text-uppercase">Tag</span>
            <h5 class="mb-0 font-14 bg-light p-1 rounded-3">{{ $asset->tag }}</h5>
          </div>
        </div>
        @endif

      

        @if ($asset->serial_number)
        <div class="col-lg-3 d-flex mb-3">
          <div class="pl-2">
            <span class="font-10 font-weight-bold text-muted text-uppercase">Serial Number</span>
            <h5 class="mb-0 font-14 font-weight-semibold head-count bg-light py-1 px-3 fst-italic rounded-3">{{ $asset->serial_number }}</h5>
          </div>
        </div>
        @endif

        @if ($asset->manufacturer)
        <div class="col-lg-3 d-flex mb-3">
          <div class="pl-2">
            <span class="font-10 font-weight-bold text-muted text-uppercase">Manufacturer</span>
            <h5 class="mb-0 font-14 font-weight-semibold head-count bg-light py-1 px-3 fst-italic rounded-3">{{ $asset->manufacturer }}</h5>
          </div>
        </div>
        @endif

        @if ($asset->brand)
        <div class="col-lg-3 d-flex mb-3">
          <div class="pl-2">
            <span class="font-10 font-weight-bold text-muted text-uppercase">brand</span>
            <h5 class="mb-0 font-14 font-weight-semibold head-count bg-light py-1 px-3 fst-italic rounded-3">{{ $asset->brand }}</h5>
          </div>
        </div>
        @endif

        @if ($asset->model)
        <div class="col-lg-3 d-flex mb-3">
          <div class="pl-2">
            <span class="font-10 font-weight-bold text-muted text-uppercase">Model</span>
            <h5 class="mb-0 font-14 font-weight-semibold head-count bg-light py-1 px-3 fst-italic rounded-3">{{ $asset->model }}</h5>
          </div>
        </div>
        @endif

        @if ($asset->custodian)
        <div class="col-lg-3 d-flex mb-3">
          <div class="pl-2">
            <span class="font-10 font-weight-bold text-muted text-uppercase">Custodian</span><br />
            <small class="text-muted font-12 bg-light py-1 px-3 fst-italic rounded-3">{{ $asset->custodian->first_name.' '.$asset->custodian->last_name }}</small>
          </div>
        </div>
        @endif

        @if ($asset->location)
        <div class="col-lg-6 d-flex mb-3">
          <div class="pl-2">
            <span class="font-10 font-weight-bold text-muted text-uppercase">LOcation</span><br />
            <small class="text-muted font-12 bg-light py-1 px-3 fst-italic rounded-3">{{ $asset->location->name }}</small>
            <small class="text-muted font-12 bg-light py-1 px-3 fst-italic rounded-3">{{ $asset->location->building->name }}</small>
          </div>
        </div>
        @endif


        @if ($asset->description)
        <div class="col-lg-12 d-flex mb-3">
          <div class="pl-2">
            <span class="font-10 font-weight-bold text-muted text-uppercase">Description</span><br />
            <small class="text-muted font-12 bg-light py-1 px-3 fst-italic rounded-3">{{ $asset->description }}</small>
          </div>
        </div>
        @endif

        @if (role_has_permission(auth()->user()->role_id, $assetPermission::CAN_EDIT_ASSET_DETAILS))
        <div class="col-lg-12 py-2">
          <a class="btn btn-primary rounded-4" data-bs-toggle="modal" href="#editAssetDetailsModal" role="button">Edit Details</a>
        </div>
        @endif
        
        
      </div>
    </div>


    <!-- Asset Finance Details -->
    @if (role_has_permission(auth()->user()->role_id, $assetPermission::CAN_VIEW_ASSET_FINANCE_DETAILS))
    <div class="card  rounded-3 mb-3" >
      <div class="card-header">
      <a class="cursor-pointer px-3"  data-bs-target="#assetFinanceInfo" data-bs-toggle="collapse" aria-expanded="false" aria-controls="my-collapse">Finance (Accounting)</a>
      </div>
      <div  class=" row card-body py-2 px-3 collapsed" id="assetFinanceInfo">
        @if ($asset->purchase_date)
        <div class="col-lg-3 d-flex mb-3">
          <div class="pl-2">
            <span class="font-10 font-weight-bold text-muted text-uppercase">Purchase Date</span>
            <h5 class="mb-0 font-14 font-weight-semibold head-count bg-light p-1 rounded-3 mt-1">{{ $asset->purchase_date }}</h5>
          </div>
        </div>
        @endif

        @if ($asset->purchase_cost)
        <div class="col-lg-3 d-flex mb-3">
          <div class="pl-2">
            <span class="font-10 font-weight-bold text-muted text-uppercase">Purchase Cost</span>
            <h5 class="mb-0 font-14 font-weight-semibold head-count bg-light p-1 rounded-3 mt-1"><small>UGX</small>{{ number_format($asset->purchase_cost, 2) }}</h5>
          </div>
        </div>
        @endif



        @if ($asset->salvage_value)
        <div class="col-lg-3 d-flex mb-3">
          <div class="pl-2">
            <span class="font-10 font-weight-bold text-muted text-uppercase">Salvage Value</span>
            <h5 class="mb-0 font-14 font-weight-semibold head-count bg-light p-1 rounded-3 mt-1"><small>UGX</small>{{ number_format($asset->salvage_value, 2) }}</h5>
          </div>
        </div>
        @endif


        @if ($asset->depreciation_method)
        <div class="col-lg-3 d-flex mb-3">
          <div class="pl-2">
            <span class="font-10 font-weight-bold text-muted text-uppercase">Depreciation Method</span>
            <h5 class="mb-0 font-14 font-weight-semibold head-count bg-light p-1 rounded-3 mt-1">{{ $asset->depreciation_method_description }}</h5>
          </div>
        </div>
        @endif

        @if (role_has_permission(auth()->user()->role_id, $assetPermission::CAN_EDIT_ASSET_FINANCE_DETAILS))
        <div class="col-lg-12 py-2">
          <a class="btn btn-danger rounded-4" data-bs-toggle="modal" href="#editAssetFinanceDetailsModal" role="button">Edit Finance Details</a>
        </div>
        @endif
       

        
      </div> 
    </div>
    @endif


    <!-- Asset transaction history  checkin and check out details -->
    <div class="card  rounded-3 " >
      <div class="card-header">
      <a class="cursor-pointer px-3 font-12"  data-bs-target="#assetTransactions" data-bs-toggle="collapse" aria-expanded="false" aria-controls="my-collapse">Transaction History (CheckOuts & CheckIns)</a>
      </div>
      <div class=" row card-body collapsed p-0" id="assetTransactions">
        <div class="table-responsive rounded-3">
          <table class="table table-hover table-striped table-bordered">
            <thead>
              <th>SN</th>
              <th>Assigned To</th>
              <th>CheckOut Date</th>
              <th>CheckIn Due Date</th>
              <th>CheckIn</th>
              <th>CheckIn</th>
              <td></td>
            </thead>
            <tbody>
              @foreach ($asset->transactions as $transaction)
                  <tr>
                    <td>{{ $loop->index +1 }}</td>
                    <td>
                      <span class="font-12 bg-white px-3 py-1 border border-primary font-weight-bold rounded-5">{{ $transaction->employee->first_name.' '.$transaction->employee->last_name }}</span>
                    </td>
                    <td>
                      <span class="font-12">{{ $transaction->date }}</span>
                    </td>
                    <td>
                      <span class="font-12">{{ $transaction->due_date }}</span>
                    </td>
                    <td>
                      @if ($transaction->checkin)
                      <span class="font-12 bg-white px-2 py-1 text-center border border-primary fw-light rounded-5">{{ $transaction->checkin->date }}</span>
                      @else
                        <a href="" class="px-2 py-1 bg-white border border-primary rounded-5 font-12 text-primary" data-bs-toggle="modal" data-bs-target="{{ '#chekInModal'.$transaction->id }}">Checkin</a>
                        
                        <!-- Modal Body -->
                        <div class="modal fade" id="{{ 'chekInModal'.$transaction->id }}" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
                          role="dialog"
                          aria-labelledby="{{ 'chekInModal'.$transaction->id }}"
                          aria-hidden="true"
                        >
                          <div
                            class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm"
                            role="document"
                          >
                            <form class="modal-content" action="{{ route('assets.checkin', ['id' => $transaction->id]) }}" method="POST">
                              @csrf
                              <div class="modal-header">
                                <h5 class="modal-title" id="modalTitleId">
                                  Modal title
                                </h5>
                                <button
                                  type="button"
                                  class="btn-close"
                                  data-bs-dismiss="modal"
                                  aria-label="Close"
                                ></button>
                              </div>
                              <div class="modal-body">
                                <input type="date" name="date">
                              </div>
                              <div class="modal-footer">
                                <button
                                  type="button"
                                  class="btn btn-secondary"
                                  data-bs-dismiss="modal"
                                >
                                  Close
                                </button>
                                <button type="submit" class="btn btn-primary">Check In</button>
                              </div>
                            </form>
                          </div>
                        </div>
                        
                        <!-- Optional: Place to the bottom of scripts -->
                        <script>
                          const myModal = new bootstrap.Modal(
                            document.getElementById("modalId"),
                            options,
                          );
                        </script>
                        
                      @endif
                    </td>
                    <td>
                      <a href="" class="px-2 py-1 bg-white border border-danger rounded-5 font-12 text-danger">Delete</a>
                    </td>
                    <td>
                      hello
                    </td>
                  </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    
  </div>
</div>


<!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
<div class="modal fade" id="editAssetDetailsModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
    <form class="modal-content" method="POST" action="{{ route('assets.update', ['id' => $asset->id]) }}">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title font-14" id="modalTitleId">Edit Asset Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body row">

        <div class="col-lg-6">
          <label for="" class="mb-1 font-12 text-muted">Serial Number</label>
          <input type="text" name="serial_number" class="form-control" placeholder="Serial Number" value="{{ old('serial_number') ?? $asset->serial_number }}" />
          <small class="text-danger">{{ $errors->first('serial_number') }}</small>
        </div>

        <div class="col-lg-6">
          <label for="" class="mb-1 font-12 text-muted">Asset Name *</label>
          <input type="text" name="name" class="form-control" placeholder="Asset Name" value="{{ old('name') ?? $asset->name }}" required />
          <small class="text-danger">{{ $errors->first('name') }}</small>
        </div>

        <div class="col-lg-12">
          <label for="" class="mb-1 font-12 text-muted">Asset Description</label>
          <textarea name="description" id="" cols="4" rows="1" class="form-control">{{old('description') ??$asset->description }}</textarea>
          <small class="text-danger">{{ $errors->first('name') }}</small>
        </div>

        <div class="col-lg-6">
          <label for="manufacturer" class="mb-1 font-12 text-muted">Manufacturer</label>
          <input type="text" name="manufacturer" class="form-control" placeholder="Manufacturer" value="{{old('manufacturer') ?? $asset->manufacturer}}" />
          <small class="text-danger">{{ $errors->first('manufacturer') }}</small>
        </div>

        <div class="col-lg-6">
          <label for="" class="mb-1 font-12 text-muted">Asset Type</label>
          <select name="asset_type" id="" class="form-control">
            <option value="">Choose Asset Type</option>
            @if ($asset->assetType)
              @foreach ($assetTypes as $assetType)
                  <option value="{{$assetType->id}}" {{ ($asset->asset_type_id == $assetType->id) ? 'selected' : '' }}>{{ $assetType->name }}</option>
              @endforeach
            @else
              @foreach ($assetTypes as $assetType)
                  <option value="{{$assetType->id}}">{{ $assetType->name }}</option>
              @endforeach
            @endif
          </select>
          <small class="text-danger">{{ $errors->first('asset_type') }}</small>
        </div>

        <div class="col-lg-6">
          <label for="" class="font-12 text-muted mb-1">Location</label>
          <select name="location" id="" class="form-control">
            <option value="">Choose Asset Location</option>
            @foreach ($buildings as $building)
              @if ($building->rooms)
              <optgroup label="{{$building->name}}" class="p-2">
               @if ($asset->location)
                @foreach ($building->rooms as $room)
                <option value="{{ $room->id }}" {{ ($asset->location->id == $room->id) ? 'selected' : '' }}>{{$room->name}}</option>
                @endforeach
               @else
                @foreach ($building->rooms as $room)
                <option value="{{ $room->id }}">{{$room->name}}</option>
                @endforeach
               @endif
              </optgroup>
              @endif
            @endforeach
          </select>
        </div>

        <div class="col-lg-6">
          <label for="" class="font-12 text-muted mb-1">Custodian</label>
          <select name="custodian" id="" class="form-control">
            <option value="">Choose Custodian</option>
            @foreach ($employees as $employee)
            <option value="{{ $employee->id }}" {{ ($asset->custodian_id == $employee->id) ? 'selected' : '' }}>{{$employee->first_name.' '.$employee->last_name}}</option>
            @endforeach
          </select>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary px-3 rounded-4" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary px-3 rounded-4">Update</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Body -->
<!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
<div class="modal fade" id="editAssetFinanceDetailsModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
    <form class="modal-content" action="{{ route('assets.update.finance', ['id' => $asset->id]) }}" method="POST">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleId">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body row">

        <div class="col-lg-6">
          <label for="" class="font-12 text-muted mb-1">Purchase Date</label>
          <input type="date" name="purchase_date" placeholder="Purchase Date" value="{{ old('purchase_date') ?? $asset->purchase_date }}" class="form-control" />
          <small class="text-danger font-12">{{$errors->first('purchase_date')}}</small>         
        </div>

        <div class="col-lg-6">
          <label for="" class="mb-1 font-12 text-muted">Purchase Cost</label>
          <input type="text" name="purchase_cost" placeholder="Purchase Cost" class="form-control" value="{{old('purchase_cost') ?? $asset->purchase_cost}}" />
          <small class="text-danger"></small>
        </div>

        <div class="col-lg-6">
          <label for="salvage_value" class="mb-1 font-12 text-muted">Salvage Value (UGX)</label>
          <input type="text" name="salvage_value" class="form-control" value="{{old('salvage_value') ?? $asset->salvage_value}}" placeholder="Salvage Value" />
          <small class="text-danger font-12">{{ $errors->first('salvage_value') }}</small>
        </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger px-3 rounded-3" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary rounded-3 px-3">Update</button>
      </div>
    </form>
  </div>
</div>


<!-- Optional: Place to the bottom of scripts -->
<script>
  const myModal = new bootstrap.Modal(document.getElementById('modalId'), options)

</script>


@endsection
