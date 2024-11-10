@extends('dashboard.layouts.master')
@section('content')
<div class="page-header flex-wrap">

  <div class="header-right d-flex flex-wrap mt-2 mt-sm-0">
    <div class="d-flex align-items-center">
      <a href="#">
        <p class="m-0 pr-3">Application</p>
      </a>
      <a class="pl-3 mr-4" href="#">
        <p class="m-0 intake">July Intake 2023</p>
      </a>
    </div>
  </div>

 <div class="header-left">
   <span class="btn btn-primary bg-white text-success mb-2 mb-md-0 mr-2"> Application Completed </span>
   <span class="btn btn-primary text-danger bg-white mb-2 mb-md-0"> Payment Pending </span>
 </div>
 
</div>

<div class="row">
  <div class="col-xl-6">
    <div class="card stretch-card mb-3">
      <div class="card-body d-flex flex-wrap justify-content-between">
        <div class="row">
          <div class="nav-profile-image col-xl-2 order-1">
            <img src="{{ asset('images/faces/face1.jpg') }}" alt="profile" />
            <!--change to offline or busy as needed-->
          </div>
          <div class="col-xl-10">
            <h4 class=" icon-sm mb-1 font-weight-semibold">Stephen Okello Omoding</h4><br />
            <small>hello@gmail.com</small>
          </div>
          
        </div>
      </div>
    </div>
    
  </div>

  <div class="col-xl-6 grind-margin">
    <div class="card stretch-card mb-3">
      <div class="card-body d-flex flex-wrap justify-content-between">
        <div>
          <h4 class="font-weight-semibold mb-3 text-black"> Course </h4>
          <h6 class="text-muted">Certificate In Nursing | Diploma In Nursing</h6>
        </div>
      </div>
    </div>
  </div>
 
</div>

<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Education Background</h4>
        <p class="card-description"> Applicants <code> Education Background</code>
        </p>
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Qualification</th>
                <th>Institute</th>
                <th>Dates</th>
                <th>Doc</th>
              </tr>
            </thead>
            <tbody>
              @for ($i = 0; $i < 3; $i++)
              <tr>
                <td>Bachelors Degree</td>
                <td>Uganda Christian University</td>
                <td class="text-danger"> 18/02/23 - 20/04/30 <i class="mdi mdi-arrow-down"></i>
                </td>
                <td>
                  doc
                </td>
              </tr>
              <tr>
                <td>Uganda Certificate Of Education</td>
                <td>Pallisa Community Secondary School</td>
                <td class="text-danger"> 28.76% <i class="mdi mdi-arrow-down"></i>
                </td>
                <td>
                  doc
                </td>
              </tr>
              @endfor
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>


  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Employment History</h4>
        <p class="card-description"> Applicants <code> Employment History</code>
        </p>
        <div class="table-responsive">
          <table class="table table-hover">
            <thead class="font-weight-bold">
              <tr>
                <th>Designation</th>
                <th>Employer</th>
                <th>Date</th>
                <th>Doc</th>
              </tr>
            </thead>
            <tbody>
              @for ($i = 0; $i < 3; $i++)
              <tr>
                <td>IT Manager</td>
                <td>Alice Anume Memorial School Of Nursing & Midwifery</td>
                <td class="text-danger"> 18/02/23 - 20/04/30 <i class="mdi mdi-arrow-down"></i>
                </td>
                <td>
                  doc
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
