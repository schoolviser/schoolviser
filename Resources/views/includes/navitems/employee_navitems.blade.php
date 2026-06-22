@if (role_has_permission(auth()->user()->role_id, $employeePermissions::ACCESS_EMPLOYEE_CONTROL_LINKS))
<li class="nav-item">
 <a class="nav-link w-auto" href="{{ route('staff') }}">Employees</a>
</li>
@endif

<li class="nav-item">
 <a class="nav-link w-auto" style="width: max-content;" href="{{ route('staff.add') }}">Add New Employee</a>
</li>
<li class="nav-item">
 <a class="nav-link" href="{{ route('staff.positions') }}">Employee Positions</a>
</li>

@if (role_has_permission(auth()->user()->role_id, $employeePermissions::CAN_IMPORT_EMPLOYEES))
<li class="nav-item">
 <a class="nav-link" href="{{ route('staff.import') }}">Import Employees</a>
</li>
@endif

<li class="nav-item">
 <a class="nav-link" href="{{ route('departments') }}">Departments</a>
</li>