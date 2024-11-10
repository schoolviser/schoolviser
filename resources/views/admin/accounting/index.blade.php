@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))

@section('title', 'Accounting')
@section('pageheader', 'Accounting')
@php
    $welcome = [
      'Welcome to accounting, What would you love to do?',
      'Accounting Time',
      'Hi Liz, Its accounting time',
      'For peace and love'
    ];
@endphp
@section('pageheaderDescription', $welcome[random_int(0,3)])

@section('requiredJs')
<script src="{{ asset('js/accounting.js') }}" defer></script>
@endsection
    

@section('pageheader-controls')
<div class="btn-group">
  <button
    class="px-3 py-1 rounded-4 font-12 border border-primary text-primary bg-white fst-italic"
    type="button"
    id="triggerId"
    data-bs-toggle="dropdown"
    aria-haspopup="true"
    aria-expanded="false"
  >
    Create New
  </button>
  <div
    class="dropdown-menu dropdown-menu-start border border-primary shadow-sm"
    aria-labelledby="triggerId"
  >
    <a class="dropdown-item font-14" data-bs-toggle="modal" data-bs-target="#recordNewExpenseModal" href="#">New Expense</a>
    <a class="dropdown-item font-14" data-bs-toggle="modal" data-bs-target="#recordNewExpenseModal" href="#">New Bill</a>
    <a class="dropdown-item font-14" data-bs-toggle="modal" data-bs-target="#recordNewExpenseModal" href="#">Client</a>

    <h6 class="dropdown-header">Section header</h6>
    <a class="dropdown-item" href="#">Action</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="#">After divider action</a>
  </div>
</div>

@endsection


    
@section('content')
<section id="accounting"></section>
@endsection
