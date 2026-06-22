@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))

@section('pageheader', 'Accounting Period Settings')
@section('pageheaderDescription', 'Set the parameters for this accounting period')


@section('pageheader-controls')
<a href="" data-bs-toggle="modal" data-bs-target="#createAccountingPeriodModal" class="px-2 py-1 rounded-4 bg-light font-12 border border-primary fw-bold text-primary">New Period</a>
@endsection

@section('where-am-i')
<a href="{{route('dashboard')}}" class="font-10 bg-light py-1 px-2 rounded-4 my-1 fw-light text-dark">Dashboard</a>
<a href="" class="font-10 bg-light py-1 px-2 rounded-4 my-1 fw-bold">></a>
<a href="{{route('settings')}}" class="font-10 bg-light py-1 px-2 rounded-4 my-1">Settings</a>
<a href="" class="font-10 bg-light py-1 px-2 rounded-4 my-1 fw-bold">></a>
<a href="" class="font-10 bg-light py-1 px-2 rounded-4 my-1">Accounting</a>
<a href="" class="font-10 bg-light py-1 px-2 rounded-4 my-1 fw-bold">></a>
<a href="" class="font-10 bg-light py-1 px-2 rounded-4 my-1 fw-bold">Fiscal Years</a>
@endsection

@section('content')

<div class="row mt-3">

  <div class="col-lg-12">
    @include('dashboard.includes.alerts.created')
    @include('dashboard.includes.alerts.deleted')
    @include('dashboard.includes.alerts.updated')
  </div>

  <div class="offset-lg- col-lg-6">
   <form class="card form" method="POST" action="{{ route('settings.accounting.period.settings.store', ['id' => $period->id]) }}">
    @csrf
    <div class="card-body row">

      <div class="col-lg-12">
       <div class="form-check">
        <input class="form-check-input" type="checkbox" value="1" name="use_cash_accounting" id="cashAccounting" {{ (array_key_exists('use_cash_accounting', $period->options) && $period->options['use_cash_accounting'] == 1) ? 'checked' : '' }} />
        <label class="form-check-label" for="cashAccounting">
         Use Cash Accounting Method.<br />
         <small class="text-muted">
          Cash accounting is an accounting method where payment receipts are recorded during the period in which they are received, and expenses are recorded in the period in which they are actually paid
         </small>
        </label>
       </div>
      </div>

      <div class="colg-lg-12"><hr /></div>

      <div class="col-lg-12">
       <button class="btn btn-md rounded-4 w-100 btn-primary" type="submit">Update</button>
      </div>

    </div>
   </form>
  </div>
</div>

@endsection
