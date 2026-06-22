@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))


@section('pageheader', 'Fixed Asset Accounts')
@section('pageheaderDescription', 'Your fixed asset accounts in the Chart Of Accounts')

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

  <div class="col-lg-7">
    <div class="table-responsive">
      <table class="table table-hover table-striped table-bordered">
        <thead>
          <th>SN</th>
        </thead>
        <tbody>
          @foreach ($fixedAssetAccounts as $account)
              <tr>
                <td>{{$loop->index + 1}}</td>
                <td>{{ $account->account->name }}</td>
                <td>
                  <a href="{{ route('settings.fixed.asset.accounts.destroy', ['id' => $account->id]) }}" class="text-danger font-12 link">Delete</a>
                </td>
              </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <div class="col-lg-5">
    @if (count($coas) > 0)
    <div>
      <h6 class="text-uppercase text-muted font-12 py-2">Asset Accounts</h6>
    </div>
    <div class="table-responsive">
      <table class="table table-hover table-bordered table-striped">
        <thead>
          <th>SN</th>
        </thead>
        <tbody>
          @foreach ($coas as $coa)
              <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $coa->name }}</td>
                <td>{{ $coa->subtype }}</td>
                <td>
                  <a href="" class="font-12 link" onclick="event.preventDefault(); document.getElementById('storeFixedAssetAccountForm').submit();">Add</a>
                  <form id="storeFixedAssetAccountForm" action="{{ route('settings.fixed.asset.accounts.store') }}" method="POST" class="d-none">
                    <input type="text" name="account_id" value="{{$coa->id}}">
                    @csrf
                  </form>
                </td>
              </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    @else
        hello
    @endif
  </div>
  
</div>


@endsection
