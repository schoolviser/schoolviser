@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))


@section('pageheader', 'Assets Status')
@section('pageheaderDescription', 'Asset Status')


@section('pageheader-controls')
<a  data-bs-toggle="modal" data-bs-target="#AddAssetStatusModal" class="px-2 py-1 rounded-4  font-12 border border-primary text-primary">Add Asset Status</a>
@endsection

@section('where-am-i')
<a href="{{route('dashboard')}}" class="font-10 py-1 px-2 rounded-4 my-1 fw-light text-dark">Dashboard</a>
<a href="" class="font-10 py-1 px-2 rounded-4 my-1 fw-bold">></a>
<a href="{{route('assets')}}" class="font-10 py-1 px-2 rounded-4 my-1">Assets</a>
<a href="" class="font-10 py-1 px-2 rounded-4 my-1 fw-bold">></a>
<a href="{{route('assets')}}" class="font-10 py-1 px-2 rounded-4 my-1">Assets Status</a>
@endsection


@section('content')

<div class="row">
  <div class="col-lg-12">
    @include('dashboard.includes.alerts.created')
    @include('dashboard.includes.alerts.deleted')
   
  </div>

  <div class="col-lg-12">
    <div class="row">
      <div class="col-lg-4">
        <div class="alert alert-danger font-12" role="alert">
          Asset Status is used to describe the current availability of equipment and is part of the Asset profile.  Changes, additions, or deletions should not be made to this list without the approval of the Asset Manager as well as the System Administrator. 
        </div>
      </div>
      <div class="col-lg-8">
        @if (count($assetStatuses) > 0)
            <div class="table-responsive">
              <table class="table table-hover table-bordered table-striped">
                <thead>
                  <td>SN</td>
                  <td>Name</td>
                  <td>Flag</td>
                  <td>Description</td>
                </thead>
                <tbody>
                  @foreach ($assetStatuses as $status)
                      <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $status->name }}</td>
                        <td>{{ $status->flag }}</td>
                        <td><span>{{ $status->description }}</span></td>
                        <td>
                          <a href="{{ route('assets.status.destroy', ['id' => $status->id]) }}" class="text-danger font-12 link">Delete</a>
                        </td>
                      </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
        @else
            
        @endif
      </div>
    </div>
  </div>
 
</div>


<!-- Add Asset Status Modal -->
<div id="AddAssetStatusModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
  <div class="modal-dialog modal-md border border-primary rounded-5" role="document">
    <form class="modal-content" action="{{ route('assets.status.store') }}" method="POST">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title font-12" id="my-modal-title">Add New Asset Status</h5>
        
      </div>
      <div class="modal-body row">
        <div class="col-lg-6">
          <label for="name" class="font-12 mb-1 text-muted">Name</label>
          <input type="text" name="name" class="form-control" value="{{old('name')}}" placeholder="Status Name" />
          <small class="text-danger text-small">{{ $errors->first('name') }}</small>
        </div>
        <div class="col-lg-6">
          <label for="flag" class="font-12 mb-1 text-muted">Flag</label>
          <input type="text" name="flag" class="form-control" value="{{old('flag')}}" placeholder="Status Flag" />
          <small class="text-danger text-small">{{ $errors->first('flag') }}</small>
        </div>
        <div class="col-lg-12">
          <label for="description" class="font-12 mb-1 text-muted">Description</label>
          <textarea name="description" id="description" class="form-control" cols="5" rows="5">{{ old('description') }}</textarea>
          <small class="text-danger text-small">{{ $errors->first('description') }}</small>
        </div>
        <div class="col-lg-12 py-2">
          <div class="custom-control custom-checkbox">
            <input id="my-input" class="custom-control-input" type="checkbox" name="check_out" value="1">
            <label for="my-input" class="custom-control-label font-12 text-muted">Asset can be checked out in this status</label>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-md btn-danger rounded-4 w-25" data-bs-dismiss="modal" aria-label="Close">
          Cancel
        </button>
        <button type="submit" class="btn btn-md btn-primary rounded-4 w-25">Submit</button>
      </div>
    </form>
  </div>
</div>

@endsection
