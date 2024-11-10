@extends('layouts.master')
@section('content')
<div class="page-header">
  <h3 class="page-title">Parent Profile</h3>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('parents') }}">Parenets</a></li>
      <li class="breadcrumb-item active" aria-current="page"> Okello Steven Omoding</li>
    </ol>
  </nav>
</div>


<div class="row">

  <div class="col-xl-12 stretch-card grid-margin">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between flex-wrap">
          <div>
            <div class="card-title mb-0">...</div>
            <h3 class="font-weight-bold mb-0">Stephen Okello Omoding</h3>
          </div>

          <div>
            <div class="d-flex flex-wrap pt-2 pb-4 justify-content-between sales-header-right">
              <div class="d-flex mr-5">
                <button type="button" class="btn btn-social-icon btn-outline-sales">
                  <i class="mdi mdi-account-multiple-outline"></i>
                </button>
                <div class="pl-2">
                  <h4 class="mb-0 font-weight-semibold head-count"> 5</h4>
                  <span class="font-10 font-weight-semibold text-muted text-uppercase">Students</span>
                </div>
              </div>


              <div class="d-flex mr-3 mt-2 mt-sm-0">
                <button type="button" class="btn btn-social-icon btn-outline-sales profit">
                  <i class="mdi mdi-cash text-info"></i>
                </button>
                <div class="pl-2">
                  <h4 class="mb-0 font-weight-semibold head-count"> 2,804 </h4>
                  <span class="font-10 font-weight-semibold text-muted">TOTAL PROFIT</span>
                </div>
              </div>
            </div>
          </div>


        </div>

        <div class="text-muted">
          <hr />
          <span class="font-weight-bold">Address:</span> <span>Pallisa, Uganda</span>
          <span class="ml-3 font-weight-bold">Phone:</span> <small>+2567 (742) 85504</small>
          <span class="ml-3 font-weight-bold">Ocupation:</span> <small>IT Manager</small>
          <hr />
          <div class="text-right">
            <a href="" class="btn btn-sm btn-success">Edit Info</a>
            <a href="" class="btn btn-sm btn-danger">Delete</a>
          </div>
        </div>
        </p>
        
      </div>
    </div>
  </div>


 <div class="col-xl-12 stretch-card grid-margin">
   <div class="card">
     <div class="card-body pb-0 mb-0">
      <h4 class="card-title mb-0">Okello's Students</h4>
     </div>
     <div class="card-body pb-4">
       <div class="table-responsive">
         <table class="table table-hover table-striped text-dark">
           <thead>
             <tr>
               <th>RegNo</th>
               <th>Name</th>
               <th>Class</th>
               <th></th>
             </tr>
           </thead>
           <tbody>
            @for ($i = 0; $i < 5; $i++)
            <tr>
              <td>4563829 </td>
              <td><small>James Opio Peter Omoding</small></td>
              <td>S.1</td>
              <td>
                <span>10</span>
                <small class="font-weight-bold"><a href="">See Students</a></small>
              </td>
              <td>
                
                <small class="font-weight-bold"><a href="">Edit Info</a></small>
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
