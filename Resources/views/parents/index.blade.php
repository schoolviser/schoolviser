@extends('layouts.master')
@section('content')


<div class="row">

 <div class="col-xl-12 stretch-card grid-margin">
   <div class="card">
     <div class="card-body pb-0 mb-0">
      
     </div>
     <div class="card-body">
       <div class="table-responsive">
         <table class="table table-hover custom-table table-striped">
           <thead>
             <tr>
               <th>Name</th>
               <th>Phone</th>
               <th>Address</th>
               <th>Students/Children</th>
               <th></th>
             </tr>
           </thead>
           <tbody>
            @for ($i = 0; $i < 5; $i++)
            <tr class="">
              <td class="py-3">Osapa James Omoding </td>
              <td><small>+2567 (742) 85504</small></td>
              <td>Pallisa, Uganda</td>
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
