
@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))


@section('pageheader', 'Notification Settings')

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
    <div class="card rounded-3 border p-1">
      <div class="card-header">
        <h6 class="mb-0 fw-bold font-12">Default Notification Email</h6>
      </div>
      <form class="card-body p-2 px-3">
        <label for="" class="text-muted font-12">Provide email where you'd want notifications to be sent to .....!</label>
        <input type="email" class="form-control w-75 my-2" value="{{ old('notification_email') ?? setting('notification_email', auth()->user(), auth()->user()->email) }}" />
        <small class="text-danger">{{ $errors->first('notification_email') }}</small>
      </form>
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
