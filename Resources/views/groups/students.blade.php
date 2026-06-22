@extends('layouts.master')
@section('content')

<div class="row mb-4">
 <div class="col-lg-12">
  <div class="card">
   <div class="card-body">
    <h4>{{ $group->name }}</h4>
   </div>
  </div>
 </div>
</div>

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
                <th>Student Name</th>
                <th>Class</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($students as $student)
              <tr>
                <td>{{ $student->surname.''.$student->other_names }}</td>
                <td>{{ $student->registrations[0]->clazz_id }}</td>
                <td>20-04-2023</td>
                <td >
                  <a href="" class="btn btn-sm btn-danger" style="font-size:10px;">Remove Student</a>
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
