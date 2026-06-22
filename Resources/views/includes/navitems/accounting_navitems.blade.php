
@if (role_has_permission(auth()->user()->role_id, $accountingPermissions::CAN_ACCESS_ACCOUNTING_OVERVIEW))

<li class="nav-item">
 <a class="nav-link" href="{{ route('accounting.overview') }}">Overview</a>
 @if (role_has_permission(auth()->user()->role_id, $accountingPermissions::CAN_VIEW_CHART_OF_ACCOUNTS))
 <a class="nav-link" href="{{ route('accounting.coas') }}">Chart Of Accounts</a>
 @endif

</li>
<hr class="my-2" />
@endif

<li class="nav-item text-muted text-uppercase menu-item">
  Revenue & Income
</li>
<li class="nav-item">
 <a class="nav-link" href="{{ route('accounting.fee.payment.transactions') }}">Fee Payment Transactions</a>
 <a class="nav-link" href="{{ route('accounting.incomes') }}">Other Income</a>

</li>

<hr class="my-2" />

<li class="nav-item text-muted text-uppercase menu-title">
  Expenses & Bills
</li>

@if (role_has_permission(auth()->user()->role_id, $accountingPermissions::CAN_VIEW_EXPENSES))
<li class="nav-item">
 <a class="nav-link" href="{{ route('accounting.expenses') }}">Expense Payments</a>
</li>
@endif

@if (role_has_permission(auth()->user()->role_id, $accountingPermissions::CAN_RECORD_EXPENSES))
<li class="nav-item">
 <a class="nav-link" href="{{ route('accounting.expenses.record') }}">Record Expense Payments</a>
</li>
<li class="nav-item">
  <a class="nav-link" href="{{ route('accounting.bills') }}">Unpaid Bills</a>
 </li>
<li class="nav-item">
 <a class="nav-link" href="{{ route('accounting.bills.create') }}">Record Bills</a>
</li>
@endif

 @if (role_has_permission(auth()->user()->role_id, $accountingPermissions::CAN_VIEW_BILLS))
 <li class="nav-item">
  <a class="nav-link" href="{{ route('accounting.vendors') }}">Vendors</a>
 </li>
 @endif

 <hr class="my-2" />

 <li class="nav-item text-muted text-uppercase menu-title">
  Cash & Banking
</li>
<li class="nav-item">
  <a class="nav-link" href="{{ route('accounting.banks') }}">Banks</a>
  <a class="nav-link" href="{{ route('accounting.cash.book') }}">Cash Books</a>
 </li>

<hr class="my-2" />

<!-- Budgeting Links -->
 <li class="nav-item text-muted text-uppercase menu-title">
  budgeting
</li>



<li class="nav-item">
 <a class="nav-link" href="{{ route('accounting.budgeting') }}">Budgeting Dashboard</a>
</li>

<li class="nav-item">
 <a class="nav-link" href="{{ route('accounting.budgeting.expense.projections') }}">Expense Projections</a>
</li>

<hr class="my-2" w-50 />


