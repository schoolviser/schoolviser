@extends('layouts.master')

@section('pageheader', 'Hostels')

@section('breadcrumb')
    @include('includes.breadcrumb', $breadcrumb = [
      'hostels' => route('hostels')
    ])
@endsection


@section('content')

<div class="page-header row d-none">
  <div class="col-lg-9">
    <h3 class="page-title pt-1 font-weight-bold">Hostels</h3>
  </div>
</div>


<div class="row">

@if (count($hostels))
  <div class="col-xl-12 stretch-card grid-margin">
    <div class="card">
      <div class="card-body py-3">
        <h4 class="card-title mb-0 d-none">Students</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover table-striped text-dark custom-table">
            <thead>
              <tr>
                <th>Name</th>
                <th>Gender</th>
                <th>Term students</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
               @foreach ($hostels as $hostel)
                   <tr class="text-capitalize">
                    <td><a href="{{ route('hostels.show', ['id' => $hostel->id]) }}">{{ $hostel->name }}</a></td>
                    <td>{{ $hostel->gender }}</td>
                    <td>{{ $hostel->rooms_count }}</td>
                    <td>{{ $hostel->terms_count }}</td>
                    <td>
                      <a href="{{ route('hostels.destroy', ['id' => $hostel->id]) }}" class="btn btn-danger btn-sm">delete</a>
                    </td>
                   </tr>
               @endforeach
            </tbody>
          </table>
        </div>
        <div class="py-3">
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-12 text-right">
    {{ $hostels->links() }}
  </div>
@else
  
@endif
  
</div>


@endsection
