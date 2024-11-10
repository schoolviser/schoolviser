@extends('dashboard.layouts.master')
@section('content')
<div class="page-header">
  <h3 class="page-title">Available Courses</h3>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page"> Courses </li>
    </ol>
  </nav>
</div>

<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title"></h4>
        </p>
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Course</th>
                <th>First name</th>
                <th>Progress</th>
                <th>Amount</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @for ($i = 0; $i < 4; $i++)
              <tr>
                <td>Diploma In Nursing</td>
                <td>
                  <div class="progress">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 55%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </td>
                <td>$ 77.99</td>
                <td>May 15, 2015</td>
                <td>
                  <a href="" class="btn btn-sm btn-primary"><i class="mdi mdi-settings mdi-sm"></i></a>
                  <a href="" class="btn btn-sm btn-primary"><i class="mdi mdi-eye mdi-sm"></i></a>
                </td>
              </tr>
              @endfor
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection
