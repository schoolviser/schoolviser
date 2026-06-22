@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))


@section('pageheader', 'Depreciation Schedule')
@section('pageheaderDescription', 'Asset Register')

@section('pageheader-controls')

<div class="d-inline px-2">|</div>
<a class="font-12 font-weight-bold" href="{{ route('assets.add') }}">Add Asset</a>

@endsection

@section('content')

<div class="row">
  <div class="col-lg-12">
    @include('dashboard.includes.alerts.deleted')
    @include('dashboard.includes.alerts.created')
  </div>

  <div class="col-lg-12">
    <div class="alert alert-danger font-14 p-2 rounded-2" role="alert">
      This asset is obsolute
      <a href="" class="border border-primary px-2 rounded-2 float-end">Dispose Off</a> 
    </div>
  </div>
  <!-- Asset Photo -->
  <div class="col-lg-2">
    <div class="card rounded-3 bg-light">
      <div class="card-body p-0"><img src="{{asset($asset->photo ?? config('defaults.avator'))}}" alt="" class="img-fluid rounded-3 asset-imageholder"></div>
    </div>
    <form action="{{ route('assets.update.photo', ['id' => $asset->id]) }}" method="POST" enctype="multipart/form-data" class="m-2">
      @csrf
      <label for="choosePhoto" class="custom-file-upload text-small">
        Choose Photo
      </label>
      <input type="file" id="choosePhoto" name="photo" class="render-image-on-input-file-change d-none" data-imgholder=".asset-imageholder" />
      <input type="submit" class="btn btn-sm btn-white border-light " id="avatorChangeBtn" value="upload" />
      <small class="text-danger">{{ $errors->first('photo') }}</small>
    </form>
  </div>
  
  <div class="col-lg-8">
    @if (count($asset->depreciationSchedules))
        <div class="table-responsive">
          <table class="table table-hover table-striped table-bordered">
            <thead>
              <th>SN</th>
              <th>Opening Book Value</th>
              <th>Depreciation Expense</th>
              <th>Accumulated Depreciation</th>
              <th>Closing Book Value</th>
            </thead>
            <tbody>
              @foreach ($asset->depreciationSchedules as $schedule)
                  <tr>
                    <td>{{ $schedule->year }}</td>
                    <td>{{ number_format($schedule->opening_book_value, 2) }}</td>
                    <td>{{ number_format($schedule->depreciation_expense, 2) }}</td>
                    <td>{{ number_format($schedule->accumulated_depreciation_expense, 2) }}</td>
                    <td>
                      <small class="text-small">UGX</small>
                      <span class="{{ ($loop->last) ? 'bg-light font-14 text-danger border-danger px-2 border rounded-3' : '' }}">{{ number_format($schedule->closing_book_value, 2) }}</span>
                    </td>
                    <td>{{ $schedule->year }}</td>
                  </tr>
              @endforeach
            </tbody>
          </table>
        </div>
    @else
        
    @endif
  </div>
</div>


@endsection
