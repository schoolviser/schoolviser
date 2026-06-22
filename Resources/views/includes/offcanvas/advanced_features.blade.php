
<div
 class="offcanvas offcanvas-end w-50 rounded-start-4"
 tabindex="-1"
 id="advancedFeatures"
 aria-labelledby="Enable both scrolling & backdrop"
>
 <div class="offcanvas-header">
  <h5 class="offcanvas-title" id="Enable both scrolling & backdrop">
   Advanced Features
  </h5>
  <button
   type="button"
   class="btn-close"
   data-bs-dismiss="offcanvas"
   aria-label="Close"
  ></button>
 </div>
 <div class="offcanvas-body row">
  <div class="col-lg-6">
   <!-- User Features -->
    <ul class="list-group mb-3">
      <li class="list-group-item text-uppercase border-0 font-10"><h5 class="mb-0 fw-bold text-primary">Manage Users</h5></li>
      
      <li class="list-group-item border-0 mb-0 py-1">
        <a class="nav-link bg-light rounded-5 py-1 px-2" style="max-width: max-content;" href="{{ route('users') }}">
            <i class="mdi mdi-account menu-icon fw-bold font-16 py-2"></i>
            <span class="menu-title px-3 font-14 text-muted">{{ __('Manager Users') }}</span><br />
        </a>
      </li>
      <li class="list-group-item border-0 py-1">
        <a class="nav-link bg-light rounded-5 py-1 px-2 dev" style="max-width: max-content;" href="{{ route('account.settings') }}" >
            <i class="mdi mdi-lock menu-icon fw-bold font-16 py-2 "></i>
            <span class="menu-title px-3 font-14 text-muted">{{ __('Security & Permissions') }}</span>
        </a>
      </li>
      <li class="list-group-item border-0 py-1">
       <a class="nav-link bg-light rounded-5 py-1 px-2 dev" style="max-width: max-content;" href="{{ route('account.settings') }}" >
           <i class="mdi mdi-lock menu-icon fw-bold font-16 py-2 "></i>
           <span class="menu-title px-3 font-14 text-muted">{{ __('User Roles & Access Rights') }}</span>
       </a>
     </li>
    </ul>

    <ul class="list-group" >
       <li class="list-group-item text-uppercase font-10 border-0 mb-0"><h5 class="mb-0 fw-bold font-14 text-primary">School Pay</h5></li>
       
       <li class="list-group-item border-0 ">
         <a class="nav-link bg-light rounded-5 py-1 px-2 dev" style="max-width: max-content;" href="{{ route('account.profile') }}">
             <i class="mdi mdi-cash menu-icon fw-bold font-16 py-2"></i>
             <span class="menu-title px-3 font-14 text-muted">{{ __('School Pay Transactions') }}</span><br />
         </a>
       </li>

       <li class="list-group-item border-0">
         <a class="nav-link bg-light rounded-5 py-1 px-2 dev" style="max-width: max-content;" href="{{ route('account.settings') }}" >
             <i class="mdi mdi-import menu-icon fw-bold font-16 py-2 "></i>
             <span class="menu-title px-3 font-14 text-muted">{{ __('Import Payments') }}</span>
         </a>
       </li>

       <li class="list-group-item border-0">
        <a class="nav-link bg-light rounded-5 py-1 px-2 dev" style="max-width: max-content;" href="{{ route('account.settings') }}" >
            <i class="mdi mdi-settings menu-icon fw-bold font-16 py-2 "></i>
            <span class="menu-title px-3 font-14 text-muted">{{ __('SchoolPay Settings') }}</span>
        </a>
      </li>
      
    </ul>

  </div>

  <div class="col-lg-6">
   <!-- User Features -->
    <ul class="list-group mb-3">
      <li class="list-group-item text-uppercase border-0 font-10"><h5 class="mb-0 fw-bold text-primary">Import Manager</h5></li>
      
      <li class="list-group-item border-0 mb-0 py-1">
        <a class="nav-link bg-light rounded-5 py-1 px-2" style="max-width: max-content;" href="{{ route('users') }}">
            <i class="mdi mdi-account menu-icon fw-bold font-16 py-2"></i>
            <span class="menu-title px-3 font-14 text-muted">{{ __('Students') }}</span><br />
        </a>
      </li>
      <li class="list-group-item border-0 py-1">
        <a class="nav-link bg-light rounded-5 py-1 px-2 dev" style="max-width: max-content;" href="{{ route('account.settings') }}" >
            <i class="mdi mdi-lock menu-icon fw-bold font-16 py-2 "></i>
            <span class="menu-title px-3 font-14 text-muted">{{ __('Parents') }}</span>
        </a>
      </li>
      <li class="list-group-item border-0 py-1">
       <a class="nav-link bg-light rounded-5 py-1 px-2 dev" style="max-width: max-content;" href="{{ route('account.settings') }}" >
           <i class="mdi mdi-lock menu-icon fw-bold font-16 py-2 "></i>
           <span class="menu-title px-3 font-14 text-muted">{{ __('Teachers') }}</span>
       </a>
     </li>
    </ul>


  </div>

  <div class="col-lg-6">
   links

  </div>
  <div class="col-lg-6">
   
  </div>
  
  </div>
 </div>
</div>
