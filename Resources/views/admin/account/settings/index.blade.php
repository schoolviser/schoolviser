
@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))


@section('pageheader', 'Profile Settings')

@section('pageheader-controls')
<a href="{{ route('settings.general') }}" class="d-inline text-small text-muted cursor-pointer font-weight-bold text-primary">General Settings</a>
<div class="d-inline px-2"></div>
@endsection
    

@section('content')

<div class="row mt-3">

  <div class="col-lg-3">
   @include('dashboard.includes.cards.account_settings')
  </div>

  <div class="col-lg-6">
    <div class="card rounded-3">
      <div class="card-body"></div>
    </div>
  </div>

  <div class="col-lg-3">
    <div class="card rounded-3">
      <div class="card-body">
       
      </div>
    </div>
  </div>


</div>
@endsection
