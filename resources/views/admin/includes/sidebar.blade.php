<nav class="sidebar sidebar-offcanvas" id="sidebar">

  <ul class="nav">

    <li class="nav-item pt-3">
      <a class="nav-link d-block text-start" href="{{ route('dashboard') }}">
        <img class="sidebar-brand-logo" src="{{ asset('images/logo.svg') }}" alt="" />
        <img class="sidebar-brand-logomini" src="{{ asset('images/logo-mini.svg') }}" alt="" />
        <div class="small font-weight-bold pt-1 d-none">{{ option('school_name') }}</div>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="{{ route('dashboard') }}">
        <i class="mdi mdi-home menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>

    <!-- School -->
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#Requirements" aria-expanded="false" aria-controls="fees">
        <i class="mdi mdi-vector-difference-ba menu-icon"></i>
        <span class="menu-title">Requirements</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="Requirements">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a c
            <li class="nav-item">
              <a class="nav-link" href="">Collections</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('students.register') }}">View Requirements</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="">Requirement Items</a>
          </li>
        </ul>
      </div>
    </li>


    <!-- Students -->
    @inject('studentsPermissions', '\App\StudentPermissionRegistrar')

    @if (auth()->user()->hasPermissionViaSingleRole($studentsPermissions::CAN_MANAGE_STUDENTS_INFO))
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#students" aria-expanded="false" aria-controls="fees">
        <i class="mdi mdi-human menu-icon"></i>
        <span class="menu-title">Students</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="students">
        <ul class="nav flex-column sub-menu">
          @include('dashboard.includes.navitems.students')
        </ul>
      </div>
    </li>
    @endif

    <!-- Requirements -->
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#Requirements" aria-expanded="false" aria-controls="fees">
        <i class="mdi mdi-vector-difference-ba menu-icon"></i>
        <span class="menu-title">Requirements</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="Requirements">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a c
            <li class="nav-item">
              <a class="nav-link" href="">Collections</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('students.register') }}">View Requirements</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="">Requirement Items</a>
          </li>
        </ul>
      </div>
    </li>

    <!-- Fees Management -->
    @include('dashboard.includes.sidebarItems.employees')


    <li class="">
      <span class="nav-item-head">Accounting</span>
      </li>
      <!-- Accounts Management -->
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#accounts" aria-expanded="false" aria-controls="accounts">
          <i class=""></i>
          <span class="menu-title">Accounting</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="accounts">
          <ul class="nav flex-column sub-menu">
            @include('dashboard.includes.navitems.accounting_navitems')
          </ul>
        </div>
      </li>
    <!-- Payroll Management -->
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#payroll" aria-expanded="false" aria-controls="payroll">
        <i class="mdi mdi-cash-usd menu-icon"></i>
        <span class="menu-title">Payroll</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="payroll">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="">Overview</a>
          </li>
           <li class="nav-item">
            <a class="nav-link" href="">Create Payroll</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="">Payrolls</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="">Run Payroll</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="">Reports</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="">Payroll Settings</a>
          </li>
        </ul>
      </div>
    </li>

    <!-- Fees Management -->
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#fees" aria-expanded="false" aria-controls="fees">
        <i class="mdi mdi-wallet menu-icon"></i>
        <span class="menu-title">Fees</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="fees">
        <ul class="nav flex-column sub-menu">
          @include('dashboard.includes.navitems.fees_navitems')
        </ul>
      </div>
    </li>
    <!-- Expenses Management -->

    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#expenses" aria-expanded="false" aria-controls="expenses">
        <i class="mdi mdi-wallet menu-icon"></i>
        <span class="menu-title">Expenses</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="expenses">
        <ul class="nav flex-column sub-menu">
          @include('dashboard.includes.navitems.accounting_navitems')
        </ul>
      </div>
    </li>

     <!-- Asset Management -->
     <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#assets" aria-expanded="false" aria-controls="assets">
        <i class="mdi mdi-airplay menu-icon"></i>
        <span class="menu-title">Manage Assets</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="assets">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('assets') }}">View Asset Items</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="">Add Asset Item</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="">Asset Categories</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="">Asset Locations</a>
          </li>
        </ul>
      </div>
    </li>

     <!-- Stores & Inventory -->
     <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#inventory" aria-expanded="false" aria-controls="inventory">
        <i class="mdi mdi-store menu-icon"></i>
        <span class="menu-title">Stores & Inventory</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="inventory">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="">Stock In</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="">Stock Out</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="">Requisitions</a>
          </li>
        </ul>
      </div>
    </li>

     <!-- Users -->
     @inject('userControlPermissions', '\App\UserAccountControlPermissionRegistrar')

     @if (auth()->user()->hasPermissionViaSingleRole($userControlPermissions::USER_ACCOUNTS_CONTROL))
     <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#users" aria-expanded="false" aria-controls="inventory">
        <i class="mdi mdi-shield menu-icon"></i>
        <span class="menu-title">Manage Users</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="users">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('users') }}">View Users</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('users.create') }}">Add User</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('roles.permissions') }}">Roles & Permissions</a>
          </li>
        </ul>
      </div>
    </li>

     @endif

     <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#master" aria-expanded="false" aria-controls="inventory">
        <i class="mdi mdi-shield menu-icon"></i>
        <span class="menu-title">Master</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="master">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('roles.permissions') }}">Roles & Permissions</a>
          </li>
        </ul>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="{{ route('settings') }}">
        <i class="mdi mdi-settings menu-icon"></i>
        <span class="menu-title">Settings</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <i class="mdi mdi-logout menu-icon"></i>
          <span class="menu-title">{{ __('Logout') }}</span>
      </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
          @csrf
      </form>
    </li>


  </ul>
</nav>
