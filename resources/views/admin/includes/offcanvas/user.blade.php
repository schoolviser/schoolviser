<div class="offcanvas offcanvas-end rounded-start-3 shadow-sm" data-bs-scroll="true" style="width: 270px;" tabindex="-1" id="userOffCanvas" aria-labelledby="offcanvasExampleLabel">
  <div class="offcanvas-header border-bottom border-light">
    <img src="{{ asset('images/avator.png') }}" alt="" style="width: 15%;" class="rounded-circle border border-light shadow-sm" />
    <h5 class="offcanvas-title text-start text-capitalize w-75 px-2" id="">
      <small class="font-16 fw-bold">{{ auth()->user()->name }} </small><br class="mb-0" />
      <small>{{ (auth()->user()->user_type) ? auth()->user()->usertype->first_name.' '.auth()->user()->usertype->last_name : '' }} </small>
    </h5>
    <button type="button" class="btn-close text-reset font-12" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body px-2 py-2">
    <ul class="list-group">

      <li class="list-group-item border-0">
        <a class="nav-link d-flex align-items-center" href="{{ route('account.profile') }}">
            <img src="{{ asset('images/account_circle_24dp_434343_FILL0_wght400_GRAD0_opsz24.svg') }}" alt="Settings Icon" style="width: 24px; height: 24px; margin-right: 4px;">
            <span class="menu-title fw-bold text-muted" style="font-size: 15px;">{{ __('Account Profile') }}</span>
        </a>
        <hr class="mb-0 mt-2" />
      </li>

      <li class="list-group-item border-0 mt-0">
        <a class="nav-link d-flex align-items-center" href="{{ route('account.notifications') }}">
            <img src="{{ asset('images/notifications_24dp_434343_FILL0_wght400_GRAD0_opsz24.svg') }}" alt="Settings Icon" style="width: 24px; height: 24px; margin-right: 4px;">
            <span class="menu-title fw-bold text-muted" style="font-size: 15px;">{{ __('Notifications') }}</span> <span id=""><span id="notificationsCounterHolder" class="p-1 m-2 bg-danger fw-bold text-white rounded-5">0</span></span>
            
        </a>
        <hr class="mb-0 mt-2" />

      </li>


      
      <li class="list-group-item border-0 ">
        <a class="nav-link d-flex align-items-center" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <img src="{{ asset('images/logout_24dp_434343_FILL0_wght400_GRAD0_opsz24.svg') }}" alt="Settings Icon" style="width: 24px; height: 24px; margin-right: 4px;">
            <span class="menu-title fw-bold text-muted" style="font-size: 15px;">{{ __('Logout') }}</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form> 
      </li>
    </ul>

    
    
  </div>
</div>