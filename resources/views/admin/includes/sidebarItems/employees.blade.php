@inject('employeeControl', '\App\EmployeeControlPermissionRegistrar')
@if (auth()->user()->hasPermissionViaSingleRole($employeeControl::ACCESS_EMPLOYEE_CONTROL_LINKS))
<li class="nav-item">
  <a class="nav-link" data-bs-toggle="collapse" href="#staff" aria-expanded="false" aria-controls="fees">
    <i class="mdi mdi-account-multiple menu-icon"></i>
    <span class="menu-title">Manage Staff</span>
    <i class="menu-arrow"></i>
  </a>
  <div class="collapse" id="staff">
    <ul class="nav flex-column sub-menu">
      <li class="nav-item">
        <a class="nav-link" href="{{ route('staff') }}">View Staff</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('staff.add') }}">Add Staff</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('staff.positions') }}">Staff Positions</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="">Departments</a>
      </li>
    </ul>
  </div>
</li>
@endif