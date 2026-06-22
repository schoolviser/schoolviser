@extends('dashboard.layouts.master')

@section('pageheader', 'Reports')
@section('pageheaderDescription', 'Generate your company reports')


@section('content')

<div class="row">
    <div class="col-lg-3">
      <div class="col-lg-12 mb-3">
        <h6 class="mb-1 py-2" style="border-bottom: 1px solid #cfcfcf;" >
          <span style="" class="px-2 py-1">Accounting</span></h6>
      </div>

      <div class="col-lg-6">
        <div class="list-unstyled">
          <li><a href="{{ route('reports.accounts.receivables') }}" class="text-small link rounded-1">Accounts Receivable</a></li>
        </div>
      </div>
    </div>


</div>
@endsection
