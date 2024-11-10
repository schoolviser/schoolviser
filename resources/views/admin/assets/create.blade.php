@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))

@section('pageheader', 'Add New Asset')

@section('pageheaderDescription', 'Manage Assets')

@section('content')
<form class="row" action="{{route('assets.store')}}" method="POST" enctype="multipart/form-data">
  @csrf

  <div class="col-lg-12">
    @include('dashboard.includes.alerts.created')
  </div>

  <div class="col-lg-3 my-2">
    <div class="card border-0 rounded-3">
      <div class="card-body row">
        
        <div class="col-lg-12 p-0">
          <img src="{{asset($asset->photo ?? config('defaults.avator'))}}" alt="" class="img-fluid rounded-3 w-100 asset-imageholder">
          <label for="choosePhoto" class="custom-file-upload text-small">
            Choose Photo
          </label>
          <input type="file" id="choosePhoto" name="photo" class="render-image-on-input-file-change d-none" data-imgholder=".asset-imageholder" />
          <small class="text-danger">{{ $errors->first('photo') }}</small>
        </div>

        

      </div>
    </div>
  </div>

  <div class="col-lg-6 my-2">
    <div class="card rounded-3 py-2">
      <div class="card-body row">
        
        <div class="col-lg-6">
          <label for="" class="mb-1 font-12 text-muted">Asset Name *</label>
          <input type="text" name="name" class="form-control" placeholder="Asset Name" value="{{ old('name') }}" required />
          <small class="text-danger">{{ $errors->first('name') }}</small>
        </div>

        <div class="col-lg-6">
          <label for="" class="mb-1 font-12 text-muted">Serial Number</label>
          <input type="text" name="serial_number" class="form-control" placeholder="Serial Number" value="{{ old('serial_number') }}" />
          <small class="text-danger">{{ $errors->first('serial_number') }}</small>
        </div>

        <div class="col-lg-12">
          <label for="" class="mb-1 font-12 text-muted">Asset Description</label>
          <textarea name="description" id="" cols="4" rows="1" class="form-control">{{old('description')}}</textarea>
          <small class="text-danger">{{ $errors->first('name') }}</small>
        </div>

        <div class="col-lg-6">
          <label for="manufacturer" class="mb-1 font-12 text-muted">Manufacturer</label>
          <input type="text" name="manufacturer" class="form-control" placeholder="Manufacturer" value="{{old('manufacturer')}}" />
          <small class="text-danger">{{ $errors->first('manufacturer') }}</small>
        </div>

        <div class="col-lg-6">
          <label for="manufacturer" class="mb-1 font-12 text-muted">Brand</label>
          <input type="text" name="brand" class="form-control" placeholder="Brand" value="{{old('brand')}}" />
          <small class="text-danger">{{ $errors->first('brand') }}</small>
        </div>

        <div class="col-lg-6">
          <label for="model" class="mb-1 font-12 text-muted">Model</label>
          <input type="text" name="model" class="form-control" placeholder="Model" value="{{old('model')}}" />
          <small class="text-danger">{{ $errors->first('model') }}</small>
        </div>

        <div class="col-lg-6">
          <label for="" class="mb-1 font-12 text-muted">Asset Type</label>
          <select name="asset_category" id="" class="form-control">
            <option value="">Choose Asset Category</option>
            @foreach ($asset_categories as $category)
                <option value="{{$category->id}}" {{ (old('asset_category') == $category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
            @endforeach
          </select>
          <small class="text-danger">{{ $errors->first('asset_category') }}</small>
        </div>

      </div>
    </div>
  </div>

  <div class="col-lg-3 my-2">
    <div class="card rounded-3 py-2">
      <div class="card-body row py-3">
        
        <div class="col-lg-12">
          <div class="form-check form-check-inline">
            <input id="my-input" class="form-check-input mt-2" type="checkbox" name="depreciable" value="1" {{ (old('depreciable') == 1) ? 'checked' : '' }}>
            <label for="my-input" class="form-check-label font-12 text-muted">Depreciable</label>
          </div>
        </div>

        <div class="my-1 col-lg-12"><hr /></div>

        <div class="col-lg-12">
          <label for="useful_life" class="mb-1 font-12 text-muted">Useful Life (Years)</label>
          <input type="text" name="useful_life" class="form-control" value="{{old('useful_life')}}" placeholder="Useful Life" />
          <small class="text-danger font-12">{{ $errors->first('useful_life') }}</small>
        </div>

        <div class="col-lg-12">
          <label for="salvage_value" class="mb-1 font-12 text-muted">Salvage Value (UGX)</label>
          <input type="text" name="salvage_value" class="form-control" value="{{old('salvage_value')}}" placeholder="Salvage Value" />
          <small class="text-danger font-12">{{ $errors->first('salvage_value') }}</small>
        </div>

        
        <div class="col-lg-12">
          <label for="useful_life" class="mb-1 font-12 text-muted">Depreciation Start Date</label>
          <input type="date" name="depreciation_start_date" class="form-control" value="{{old('depreciation_start_date')}}" placeholder="Depreciation Start Date" />
          <small class="text-danger font-12">{{ $errors->first('depreciation_start_date') }}</small>
        </div>

      </div>
    </div>
  </div>

  <div class="col-lg-3 offset-lg-3 my-2">
    <div class="card rounded-3 border-light">
      <div class="card-body row py-2">
        
        <div class="col-lg-12">
          <label for="" class="font-12 text-muted mb-1">Asset Status</label>
          <select name="asset_status" id="" class="form-control">
            <option value="">Choose Asset Status</option>
            @foreach ($assetStatus as $status)
                <option value="{{ $status->id }}">{{ $status->name }}</option>
            @endforeach
          </select>
          <small class="text-danger font-12">{{$errors->first('asset_status')}}</small>         
        </div>


      </div>
    </div>
  </div>

  <div class="col-lg-3 my-2">
    <div class="card rounded-3 border-light">
      <div class="card-body row py-2">
        
        <div class="col-lg-12">
          <label for="" class="font-12 text-muted mb-1">Purchase Date</label>
          <input type="date" name="purchase_date" placeholder="Purchase Date" value="{{ old('purchase_date') }}" class="form-control" />
          <small class="text-danger font-12">{{$errors->first('purchase_date')}}</small>         
        </div>

        <div class="col-lg-12">
          <label for="" class="mb-1 font-12 text-muted">Purchase Cost</label>
          <input type="text" name="purchase_cost" placeholder="Purchase Cost" class="form-control" value="{{old('purchase_cost')}}" />
          <small class="text-danger"></small>
        </div>

        <div class="col-lg-12"><hr></div>

        <div class="col-lg-12">
          <label for="" class="font-12 text-muted mb-1">Place In Service Date</label>
          <input type="date" name="place_in_service_date" value="{{ old('place_in_service_date') }}" class="form-control" />
        </div>

        <div class="col-lg-12">
          <label for="" class="font-12 text-muted mb-1">Location</label>
          <select name="location" id="" class="form-control">
            <option value="">Choose Asset Location</option>
            @foreach ($buildings as $building)
              @if ($building->rooms)
              <optgroup label="{{$building->name}}" class="p-2">
               @foreach ($building->rooms as $room)
               <option value="{{ $room->id }}">{{$room->name}}</option>
               @endforeach
              </optgroup>
              @endif
            @endforeach
          </select>
        </div>

      </div>
    </div>
  </div>

  <div class="col-lg-3 my-2">
    <div class="card rounded-3 border-light">
      <div class="card-body row py-2">

      </div>
    </div>
  </div>

  <div class="col-lg-12 my-5">
    <button type="submit" class="btn btn-md btn-primary w-100 rounded-4">Save</button>
  </div>
</form>
@endsection
