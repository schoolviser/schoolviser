<div class="horizontal-menu">

 <nav class="navbar navbar-expand-lg navbar-light top-navbar">
   <div class="container">
     <div>
       <a class="navbar-brand brand-logo" data-bs-toggle="offcanvas" data-bs-target="#accountingNavigation" href="{{ route('dashboard') }}">
         <img src="{{ asset('images/logo.svg') }}" alt="logo" />
       </a>
     </div>

     <div class="mt-2 current-sessions current-term">
       <span class="bg- font-13 py-1 px-3 rounded-5 fw-bold fst-italic border border-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ term()->start_date.' ~ '.term()->end_date.' : '.term()->next_term_start_date }}">{{ 'Term '.term()->term.', '.term()->year }}</span>
       @if (period())
       <span class="bg- font-13 py-1 px-3 rounded-5 fw-bold fst-italic border border-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ period()->start_date.' ~ '.period()->end_date }}">{{ 'Accounting Period '.period()->name }}</span>
       @else
           
       @endif
     </div>
     

     <ul class="navbar-nav navbar-nav-right">

       <!-- User Messages -->
       <li class="nav-item dropdown ml-5" style="margin-left: 20px;">
         <a class="nav-link" id="messageDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
           <i class="mdi mdi-email-outline"></i>
         </a>
         <div class="dropdown-menu dropdown-menu-end navbar-dropdown preview-list" aria-labelledby="messageDropdown">
           <h6 class="p-3 mb-0 font-weight-semibold">Messages</h6>
           <div class="dropdown-divider"></div>
           <a class="dropdown-item preview-item">
             <div class="preview-thumbnail">
               <img src="images/faces/face1.jpg" alt="image" class="profile-pic">
             </div>
             <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
               <h6 class="preview-subject ellipsis mb-1 font-weight-normal">Mark send you a message</h6>
               <p class="text-gray mb-0"> 1 Minutes ago </p>
             </div>
           </a>
           <div class="dropdown-divider"></div>
           <a class="dropdown-item preview-item">
             <div class="preview-thumbnail">
               <img src="images/faces/face6.jpg" alt="image" class="profile-pic">
             </div>
             <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
               <h6 class="preview-subject ellipsis mb-1 font-weight-normal">Cregh send you a message</h6>
               <p class="text-gray mb-0"> 15 Minutes ago </p>
             </div>
           </a>
           <div class="dropdown-divider"></div>
           <a class="dropdown-item preview-item">
             <div class="preview-thumbnail">
               <img src="images/faces/face7.jpg" alt="image" class="profile-pic">
             </div>
             <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
               <h6 class="preview-subject ellipsis mb-1 font-weight-normal">Profile picture updated</h6>
               <p class="text-gray mb-0"> 18 Minutes ago </p>
             </div>
           </a>
           <div class="dropdown-divider"></div>
           <h6 class="p-3 mb-0 text-center text-primary font-13">4 new messages</h6>
         </div>
       </li>

       <!-- User notifications-->
       <li class="nav-item dropdown">
         <a class="nav-link" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
           <small
             class="badge bg-danger p-1"
             >1</small
           >
           
           <i class="mdi mdi-bell-outline"></i>
         </a>
         <div class="dropdown-menu dropdown-menu-end navbar-dropdown preview-list border border-primary" aria-labelledby="notificationDropdown">
           <h6 class="px-3 py-3 font-weight-semibold mb-0">Notifications</h6>
           <div class="dropdown-divider"></div>
           <a class="dropdown-item preview-item">
             <div class="preview-thumbnail">
               <div class="preview-icon bg-success">
                 <i class="mdi mdi-calendar"></i>
               </div>
             </div>
             <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
               <h6 class="preview-subject font-weight-normal mb-0">New order recieved</h6>
               <p class="text-gray ellipsis mb-0"> 45 sec ago </p>
             </div>
           </a>
           <div class="dropdown-divider"></div>
           <a class="dropdown-item preview-item">
             <div class="preview-thumbnail">
               <div class="preview-icon bg-warning">
                 <i class="mdi mdi-settings"></i>
               </div>
             </div>
             <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
               <h6 class="preview-subject font-weight-normal mb-0">Server limit reached</h6>
               <p class="text-gray ellipsis mb-0"> 55 sec ago </p>
             </div>
           </a>
           <div class="dropdown-divider"></div>
           <a class="dropdown-item preview-item">
             <div class="preview-thumbnail">
               <div class="preview-icon bg-info">
                 <i class="mdi mdi-link-variant"></i>
               </div>
             </div>
             <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
               <h6 class="preview-subject font-weight-normal mb-0">Kevin karvelle</h6>
               <p class="text-gray ellipsis mb-0"> 11:09 PM </p>
             </div>
           </a>
           <div class="dropdown-divider"></div>
           <h6 class="p-3 font-13 mb-0 text-primary text-center">View all notifications</h6>
         </div>
       </li>
       <li class="nav-item">
         <a href="" class="nav-link" data-bs-toggle="offcanvas" data-bs-target="#advancedFeatures">
           <i class="mdi mdi-microsoft"></i>
         </a>
       </li>


       <li class="nav-item">
         <a class="nav-link cursor-pointer" data-bs-toggle="offcanvas" data-bs-target="#userOffCanvas" aria-controls="accountQuickLinksOffCanvas">
           <img src="{{ asset(auth()->user()->avator ?? 'images/avator.png') }}" alt="" class="rounded-circle" style="width: 35px;">
           <div class="nav-profile-text text-capitalize fw-bold px-3">{{ auth()->user()->name }} </div>
         </a>
       </li>
     </ul>

     
     <button class="navbar-toggler" data-target="#my-nav" data-toggle="collapse" aria-controls="my-nav" aria-expanded="false" aria-label="Toggle navigation">
       <span class="navbar-toggler-icon"></span>
     </button>
   </div>
 </nav>


</div>


@include('admin.includes.offcanvas.user')



<div
 class="offcanvas offcanvas-start rounded-end-4 offcanvas-menu"
 data-bs-backdrop="static"
 tabindex="-1"
 id="accountingNavigation"
 aria-labelledby="staticBackdropLabel"
>
 <div class="offcanvas-header">
  <h5 class="offcanvas-title" id="staticBackdropLabel">
   Accounting Navigation
  </h5>
  <button
   type="button"
   class="btn-close"
   data-bs-dismiss="offcanvas"
   aria-label="Close"
  ></button>
 </div>
 <div class="offcanvas-body ">
  <ul class="bg-primary">
   @include('admin.includes.navitems.accounting_navitems')
   @include('admin.includes.navitems.accounting_reports_navitems')
  </ul>
 </div>
</div>

