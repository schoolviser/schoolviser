
@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))


@section('pageheader', 'Fees Settings')
@section('pageheaderDescription', 'A place to configure all your fees collection configurations.')

@section('where-am-i')
<a href="{{route('dashboard')}}" class="font-10 bg-light py-1 px-2 rounded-4 my-1 fw-light text-dark">Dashboard</a>
<a href="" class="font-10 bg-light py-1 px-2 rounded-4 my-1 fw-bold">></a>
<a href="{{route('settings')}}" class="font-10 bg-light py-1 px-2 rounded-4 my-1">Settings</a>
<a href="" class="font-10 bg-light py-1 px-2 rounded-4 my-1 fw-bold">></a>
<a href="{{route('settings')}}" class="font-10 bg-light py-1 px-2 rounded-4 my-1">Fees Collection</a>
@endsection
    

@section('content')

<div class="row mt-4">
 
  <div class="col-lg-9">

  </div>

  <div class="col-lg-3">
    <div class="card rounded-4">
      <div class="card-body ">
        <div class="list-unstyled">
          <li class="mb-1"><a href="{{ route('settings.fees.categories') }}" class="text-small bg-light rounded-3 px-2 py-1 fw-bold">Fees Categories</a></li>
          <li class="mb-1"><a href="{{ route('settings.general') }}" class="text-small bg-light rounded-3 px-2 py-1">School Info</a></li>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection
