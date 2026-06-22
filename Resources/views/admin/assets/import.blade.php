@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))


@section('pageheader', 'Import Assets')
@section('pageheaderDescription', 'Import your Assets')

@section('pageheader-controls')
<a href="{{ route('assets.add') }}" class="px-2 py-1 rounded-4  font-12 border border-primary text-primary">Add Asset</a>
<a href="{{ route('assets.add') }}" class="px-2 py-1 rounded-4  font-12 border border-primary text-primary">Export Assets</a>
@endsection

@section('where-am-i')
<a href="{{route('dashboard')}}" class="font-10 py-1 px-2 rounded-4 my-1 fw-light text-dark">Dashboard</a>
<a href="" class="font-10 py-1 px-2 rounded-4 my-1 fw-bold">></a>
<a href="{{route('assets')}}" class="font-10 py-1 px-2 rounded-4 my-1">Assets</a>
<a href="" class="font-10 py-1 px-2 rounded-4 my-1 fw-bold">></a>
<a href="{{route('assets.import')}}" class="font-10 py-1 px-2 rounded-4 my-1">Import</a>
@endsection

@section('content')

<div class="row">
 @include('dashboard.includes.alerts.created')

 <div class="col-lg-4">
  <form action="{{ route('assets.import.store') }}" method="POST" class="py-4" enctype="multipart/form-data">
   @csrf
   <input type="file" name="file" id="" class="pb-3">
   <input type="submit" value="upload" class="btn btn-md w-75 btn-primary rounded-4 text-capitalize">
  </form>
 </div>

 <div class="col-lg-4 offset-lg-4">
  <div class="card rounded-2">
   <div class="card-header"><h6 class="card-title mb-0 font-14 fw-light">Download Template</h6></div>
   <div class="card-body">
    <a href="{{ route('assets.import.download.template') }}" class="btn btn-white border border-primary btn-md w-100 mb-3 rounded-4">Assets Import Template</a>
   </div>
  </div>
 </div>

</div>
@endsection
