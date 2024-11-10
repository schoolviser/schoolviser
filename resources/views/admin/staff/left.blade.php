@extends('layouts.master')

@section('pageheader', 'Staff that left school')

@section('requiredJs')
<script src="{{ asset('chart.js/Chart.min.js') }}" defer></script>
<script src="{{ asset('js/chart.js') }}" defer></script>
@endsection
    
@section('content')
<div class="row">
  <div class="col-12 grid-margin table-card">
    <div class="card">
      <div class="card-body m-1">
        @if (count($staff))
            <div class="table-responsive">
              <table class="table  table-hover table-bordered table-striped">
                <thead>
                  <th>Name</th>
                  <th>Position</th>
                  <th>Phone</th>
                  <th>Left On</th>
                  <th></th>
                </thead>
                <tbody>
                  @foreach ($staff as $member)
                    <tr>
                      <td>
                        <img src="{{ asset(($member->photo) ?? asset(config('defaults.avator'))) }}" class="mx1 rounded-circle border border-primary" alt="image" /> 
                        <a href="{{ route('staff.show', ['id' => $member->id]) }}" style="text-decoration: none;" class="pl-5"><span class="ml-4">{{ $member->full_name }}</span></a> 
                      </td>
                      <td>{{ ($member->position) ? $member->position->name : '' }}</td>
                      <td>{{ $member->primary_phone }}</td>
                      <td>{{ $member->left_on }}</td>
                      <td>
                       <a href="{{ route('staff.trash.restore', ['id' => $member->id]) }}" class="btn btn-sm btn-white">Restore</a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <div class="pagination-links my-2">
              {{ $staff->links() }}
            </div>
        @else
            
        @endif        
      </div>
    </div>
  </div>
</div>
@endsection
