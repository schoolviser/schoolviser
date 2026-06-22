@extends('dashboard.layouts.master')
@section('content')
<div class="page-header flex-wrap">
 <div class="header-left">
   <button class="btn btn-primary mb-2 mb-md-0 mr-2"> Create new document </button>
   <button class="btn btn-outline-primary bg-white mb-2 mb-md-0"> Import documents </button>
 </div>
 <div class="header-right d-flex flex-wrap mt-2 mt-sm-0">
   <div class="d-flex align-items-center">
     <a href="#">
       <p class="m-0 pr-3">Dashboard</p>
     </a>
     <a class="pl-3 mr-4" href="#">
       <p class="m-0">2023</p>
     </a>
   </div>
   <button type="button" class="btn btn-primary mt-2 mt-sm-0 btn-icon-text">
     <i class="mdi mdi-plus-circle"></i> Add Prodcut </button>
 </div>
</div>

<div class="row">


 <div class="col-xl-12 stretch-card grid-margin">
   <div class="card">
     <div class="card-body pb-0">
       <h4 class="card-title mb-">Intake Applications</h4>
     </div>
     <div class="card-body p-0">
       <div class="table-responsive">
         <table class="table custom-table text-dark">
           <thead>
             <tr>
               <th>Name</th>
               <th>Courses</th>
               <th>Status</th>
               <th>Payment Status</th>
               <th></th>
             </tr>
           </thead>
           <tbody>
            @for ($i = 0; $i < 5; $i++)
                
             <tr>
               <td>
                 <img src="/images/faces/face2.jpg" class="mr-2" alt="image" /> Stephen Okello Omoding </td>
               <td>
                <small>Diploma In Nursing</small>
                <small>Diploma In Nursing</small>
               </td>
               <td><small class="badge badge-success">Completed</small></td>
               <td><small class="badge badge-danger">Pending</small></td>
               <td>
                <a href="" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
               </td>
             </tr>
            @endfor

           </tbody>
         </table>
       </div>
       <a class="text-black font-13 d-block pt-2 pb-2 pb-lg-0 font-weight-bold pl-4" href="#">Show more</a>
     </div>
   </div>
 </div>
</div>

@endsection
