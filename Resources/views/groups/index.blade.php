@extends('layouts.master')
@section('content')


<div class="row">
  <div class="col-xl-12 stretch-card grid-margin">
    <div class="card">
      <div class="card-body py-3">
        <h4 class="card-title mb-0"></h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped custom-table table-hover text-dark">
            <thead>
              <tr>
                <th>Group Name</th>
                <th>Students</th>
                <th>Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($groups as $group)
              <tr>
                <td>{{ $group->name }}</td>
                <td>{{ $group->students_count }}</td>
                <td>20-04-2023</td>
                <td >
                  <a href="{{ route('students.groups.students', ['id' => $group->id]) }}" class="btn btn-sm btn-primary" style="font-size:10px;">See Students</a>
                  <a href="{{ route('students.profile', ['7887']) }}" class="btn btn-sm btn-success" style="font-size:10px;">Edit Group</a>
                  <a href="" class="btn btn-sm btn-danger" style="font-size:10px;">Delete</a>
                </td>
              </tr>
              @endforeach
             
            </tbody>
          </table>
        </div>
        <div class="py-3">
          pagination comes here
        </div>
      </div>
    </div>
  </div>
</div>


@endsection
