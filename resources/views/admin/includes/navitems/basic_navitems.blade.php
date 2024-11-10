<li><a class="" href="{{ route('accounting.overview') }}">Overview</a></li>

@if (role_has_permission(auth()->user()->role_id, $accountingPermissions::CAN_VIEW_CHART_OF_ACCOUNTS))
<li><a href="{{ route('accounting.coas') }}">Chart Of Accounts</a></li>
@endif

<li><a href="{{ route('accounting.expenses') }}">Expense Payments</a></li>
<li><a href="{{route('accounting.expenses.record')}}">Record Expense Payments</a></li>

@if (role_has_permission(auth()->user()->role_id, $accountingPermissions::CAN_VIEW_BILLS))
<li><a class="" href="{{ route('accounting.bills') }}">Unpaid Bills</a></li>
@endif

<li><a class="nav-link" href="{{ route('accounting.bills.create') }}">Record Bills</a></li>


@if (role_has_permission(auth()->user()->role_id, $accountingPermissions::CAN_VIEW_BILLS))
<li class="">
 <a class="" href="{{ route('accounting.vendors') }}">Vendors</a>
</li>
@endif

<li class="nav-item">
 <a class="nav-link" href="{{ route('accounting.banks') }}">Banks</a>
 <a class="nav-link" href="{{ route('accounting.cash.book') }}">Cash Books</a>
</li>

<li><a href="{{ route('accounting.resports') }}">Financial Reports</a></li>