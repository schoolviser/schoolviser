<div class="horizontal-menu">

 <nav class="navbar navbar-expand-lg navbar-light top-navbar">
   <div class="container">
     <div>
       <a class="navbar-brand brand-logo" href="{{ route('dashboard') }}">
         <img src="{{ asset('images/logo.svg') }}" alt="logo" />
       </a>
     </div>

     <div class="mt-2 current-sessions current-term">
       <span class="bg- font-13 py-1 px-3 rounded-5 fw-bold fst-italic border border-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ term()->start_date.' ~ '.term()->end_date.' : '.term()->next_term_start_date }}">{{ 'Term '.term()->term.', '.term()->year }}</span>
       <span class="bg- font-13 py-1 px-3 rounded-5 fw-bold fst-italic border border-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ period()->start_date.' ~ '.period()->end_date }}">{{ 'Accounting Period '.period()->name }}</span>
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
         <a class="nav-link cursor-pointer" data-bs-toggle="offcanvas" data-bs-target="#accountQuickLinksOffCanvas" aria-controls="accountQuickLinksOffCanvas">
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


<nav class="bottom-navbar">
  <div class="container">
    <ul class="nav page-navigation">
     <li class="nav-item">
       <a class="nav-link" href="{{ route('dashboard') }}" data-bs-toggle="offcanvas" data-bs-target="#menuOffCanvas">
         <i class="mdi mdi-windows menu-icon"></i>
       </a>
     </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard') }}">
          <i class="mdi mdi-compass-outline menu-icon"></i>
          <span class="menu-title">Home</span>
        </a>
      </li>

     @inject('accountingPermissions', '\App\AccountingPermissionRegistrar')
     @if (role_has_permission(auth()->user()->role_id, $accountingPermissions::CAN_MANAGE_ACCOUNTING))
     <li class="nav-item">
       <a href="#" class="nav-link">
         <i class="mdi mdi-book-open menu-icon"></i>
         <span class="menu-title">Accounting</span>
         <i class="menu-arrow"></i>
       </a>
       <div class="submenu">
         <ul class="submenu-item">
          @include('dashboard.includes.navitems.accounting_navitems',['accountingPermissions' => $accountingPermissions])
         </ul>
       </div>
     </li>
     @endif
      

     <!-- MANAGE EMPLOYEES -->
     @inject('employeePermissions', '\App\EmployeeControlPermissionRegistrar')
     @if (role_has_permission(auth()->user()->role_id, $employeePermissions::ACCESS_EMPLOYEE_CONTROL_LINKS))
     <li class="nav-item">
       <a href="#" class="nav-link">
         <i class="mdi mdi-book-open menu-icon"></i>
         <span class="menu-title">Employees</span>
         <i class="menu-arrow"></i>
       </a>
       <div class="submenu">
         <ul class="submenu-item">
         @include('dashboard.includes.navitems.employee_navitems', ['employeePermissions' => $employeePermissions])
         </ul>
       </div>
     </li>
     @endif

     

     @inject('assetPermissions', '\App\AssetPermissionRegistrar')
     @if (role_has_permission(auth()->user()->role_id, $assetPermissions::CAN_MANAGE_ASSETS))
     <li class="nav-item">
       <a href="#" class="nav-link">
         <i class="mdi mdi-book-open menu-icon"></i>
         <span class="menu-title">Assets</span>
         <i class="menu-arrow"></i>
       </a>
       <div class="submenu">
         <ul class="submenu-item">
           <li class="nav-item">
             <a class="nav-link" href="{{route('assets.overview')}}">Overview</a>
           </li>
          
          <li class="nav-item">
             <a class="nav-link" href="{{route('assets')}}">Asset Register</a>
           </li>
           <li class="nav-item">
             <a class="nav-link" href="{{route('assets.add')}}">Add New Asset</a>
           </li>
           <li class="nav-item">
             <a class="nav-link d-" href="{{route('assets')}}">Disposal Report</a>
           </li>
           @if (role_has_permission(auth()->user()->role_id, $assetPermissions::CAN_VIEW_ASSET_TYPES))
           <li class="nav-item">
             <a class="nav-link" href="{{route('assets.types')}}">Asset Types</a>
           </li>
           @endif
          
           <li class="nav-item">
             <a class="nav-link d-none" href="{{route('assets')}}">Asset Categories</a>
           </li>
           <li class="nav-item">
             <a class="nav-link d-" href="{{route('assets.import')}}">Import Your Assets</a>
           </li>
         </ul>
       </div>
     </li>
     @endif

     <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="mdi mdi-book-open menu-icon"></i>
        <span class="menu-title">Inventory</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="submenu">
        <ul class="submenu-item">
        @include('dashboard.includes.navitems.inventory_navitems', ['employeePermissions' => $employeePermissions])
        </ul>
      </div>
    </li>


     


      <li class="nav-item d-none">
       <a class="nav-link" href="{{ route('settings') }}">
         <i class="mdi mdi-settings menu-icon"></i>
         <span class="menu-title">Settings</span>
       </a>
     </li>
      
    </ul>
  </div>
</nav>
</div>

<!-- More Menus -->

<div class="offcanvas offcanvas-end " data-bs-scroll="true" style="width: 270px; margin-right: 5px;" tabindex="-1" id="menuOffCanvas" aria-labelledby="offcanvasExampleLabel">
 <div class="offcanvas-header border-bottom border-primary py-2 px-3">
   <h5 class="offcanvas-title font-12" id="offcanvasExampleLabel">More Links</h5>
   <button type="button" class="btn-close text-reset font-12" data-bs-dismiss="offcanvas" aria-label="Close"></button>
 </div>
 <div class="offcanvas-body">
   <div>
     <nav class="nav flex-column">
         <!-- Users -->
      @inject('userControlPermissions', '\App\UserPermissionRegistrar')
      @inject('permissions', '\App\SystemPermissionRegistrar')
      @inject('settings', '\App\SystemSettingsPermissionRegistrar')

     @if (role_has_permission(auth()->user()->role_id, $userControlPermissions::CAN_MANAGE_USERS))
      

       <li class="nav-item font-16">
         <a class="nav-link" href="{{route('users')}}">
             <i class="mdi mdi-account menu-icon fw-bold font-16 py-2"></i>
             <span class="menu-title px-3 font-14 text-muted">{{ __('View Users') }}</span>
         </a>
         <a class="nav-link" href="{{route('users.create')}}">
             <i class="mdi mdi-account menu-icon fw-bold font-16 py-2"></i>
             <span class="menu-title px-3 font-14 text-muted">{{ __('Add New User') }}</span>
         </a>
         @if (role_has_permission(auth()->user()->role_id, $permissions::CAN_MANAGE_SYSTEM_PERMISSIONS))
         <a class="nav-link" href="{{route('roles.permissions')}}">
             <i class="mdi mdi-account menu-icon fw-bold font-16 py-2"></i>
             <span class="menu-title px-3 font-14 text-muted">{{ __('Roles and Permissions') }}</span>
         </a>
         @endif
         
         <hr class="my-2" />
       </li>
     @endif

       @if (role_has_permission(auth()->user()->role_id, $settings::CAN_VIEW_SYSTEM_SETTINGS))
       <li class="nav-item font-16">
         <a class="nav-link" href="{{route('settings')}}">
             <i class="mdi mdi-settings menu-icon fw-bold font-16 py-2"></i>
             <span class="menu-title px-3 font-14 text-muted">{{ __('System Settings') }}</span>
         </a>
       </li>
       @endif
       
     </nav>
   </div>
   
 </div>
</div>
