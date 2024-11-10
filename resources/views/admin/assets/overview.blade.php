@extends('dashboard.layouts.horizontal')


@section('title', 'Assets Overview')

@section('pageheader', 'Manage Assets')
@section('pageheaderDescription', 'Manage your fixed assets')

@section('pageheader-controls')
<a href="{{ route('assets.add') }}" class="px-2 py-1 rounded-4  font-12 border border-primary text-primary">Add Asset</a>
<a href="{{ route('assets.import') }}" class="px-2 py-1 rounded-4  font-12 border border-primary text-primary">Import Assets</a>
<a href="{{ route('assets.add') }}" class="px-2 py-1 rounded-4  font-12 border border-primary text-primary">Export Assets</a>
@endsection

@section('where-am-i')
<a href="{{route('dashboard')}}" class="font-10 py-1 px-2 rounded-4 my-1 fw-light text-dark">Dashboard</a>
<a href="" class="font-10 py-1 px-2 rounded-4 my-1 fw-bold">></a>
<a href="{{route('assets')}}" class="font-10 py-1 px-2 rounded-4 my-1">Assets</a>
@endsection

@section('requiredJs')
<script src="{{ asset('chart.js/Chart.min.js') }}" defer></script>

<script src="{{ asset('js/assets-charts.js') }}" defer></script>
@endsection

@section('content')

<div class="row mt-4">
  <div class="col-lg-12">
    <div
      class="table-responsive"
    >
      <table
        class="table table-hover table-striped table-bordered"
      >
        <thead>
          <th>Category</th>
          <th>Items</th>
          <th>Current Value</th>
          <th></th>
        </thead>
        <tbody>
         @foreach ($assets as $asset)
         <tr>
          <td>{{$asset->name}}</td>
          <td>{{ number_format($asset->assets_count, 1) }}</td>
          <td>{{ number_format(($asset->currentAssetSummary) ? $asset->currentAssetSummary->amount : 0, 2) }}</td>
        </tr>
         @endforeach
        </tbody>
      </table>
    </div>
    
  </div>
</div>

@endsection
