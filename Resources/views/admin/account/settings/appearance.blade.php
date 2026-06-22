
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

  <form class="col-lg-7" method="POST" action="{{ route('account.settings.appearance.update') }}">
    @csrf
   <div class="card rounded-3">
    <div class="card-header"><h6 class="card-title mb-0 font-14">Navigation Style</h6></div>
    <div class="card-body row px-2 py-3">
      
  
      <div class="col-lg-6">
       <div class="form-check form-check-inline">
        <label for="vertical" class="form-check-label text-muted font-14">
         <span class="bg-light px-3 py-1 rounded-4">Vertical Menu Navigation</span>
         <img src="{{ asset('images/3.jpg') }}" alt="" class="img-fluid w-100 rounded-3 mt-2" />
        </label>
        <input id="vertical" class="form-check-input" type="checkbox" name="dashboard_view_layout" value="dashboard.layouts.master" {{ (setting('dashboard_view_layout',auth()->user()) == 'dashboard.layouts.master') ? 'checked' : '' }} />
       </div>
      </div>
  
      <div class="col-lg-6">
       <div class="form-check form-check-inline">
        <label for="horizontal" class="form-check-label text-muted font-14">
         <span class="bg-light px-3 py-1 rounded-4">Horizontal Menu Navigation </span>
         <img src="{{ asset('images/3.jpg') }}" alt="" class="img-fluid w-100 rounded-3 mt-2" />
        </label>
        <input id="horizontal" class="form-check-input" type="checkbox" name="dashboard_view_layout" value="dashboard.layouts.horizontal" {{ (setting('dashboard_view_layout',auth()->user()) == 'dashboard.layouts.horizontal') ? 'checked' : '' }} />
       </div>
      </div>
  
  
     </div>
   </div>

   <div class="py-3">
    <button type="submit" class="btn btn-primary font-12 w-100 rounded-4">Update Appearance Settings</button>
   </div>
  </form>

</div>
@endsection
