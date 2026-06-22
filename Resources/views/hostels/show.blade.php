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
    <h3 class="page-title pt-1 font-weight-bold">Hostel Profile</h3>
  </div>
</div>


<div class="row">

@if (count($students))
  <div class="col-xl-12 stretch-card grid-margin">
    <div class="card">
      <div class="card-body py-3">
        <h4 class="card-title mb-0">Hostel Member Students</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover table-striped text-dark custom-table">
            <thead>
              <tr>
                <th>Name</th>
                <th>Class</th>
                <th>added On</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
               @foreach ($students as $student)
                   <tr class="text-capitalize">
                    <td><a href="{{ route('students.profile', ['id' => $student->id]) }}">{{ $student->full_name }}</a></td>
                    <td>{{ $student->currentRegistration->clazz->name }}</td>
                    <td>
                      <a href="{{ route('hostels.remove.student', ['id' => $hostel->id, 'student_id' => $student->id]) }}" class="btn btn-danger btn-sm">Remove</a>
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
    {{ $students->links() }}
  </div>
@else
  
@endif
  
</div>


@endsection
