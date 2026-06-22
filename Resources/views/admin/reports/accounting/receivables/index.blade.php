@extends('dashboard.layouts.master')

@section('pageheader', 'Accounts Receivable Report')
@section('pageheaderDescription', 'Run Report')


@section('requiredJs')
<script src="{{ asset('chart.js/Chart.min.js') }}" defer></script>
<script src="{{ asset('js/reports.js') }}" defer></script>
@endsection


@section('content')

<div class="row">
    
  <div class="col-lg-6">
    <a class="font-12 text-muted" data-bs-target="#feesReceivableDoughnutChartCard" data-bs-toggle="collapse">Hide Chart</a>
    <div id="feesReceivableDoughnutChartCard" class="collapse">
      <div class="card rounded-3" >
        <div class="card-body ">
          <canvas id="feesReceivableDoughnutChart" class="" style="height: 100px;"></canvas>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-6 mb-2">
    <small class="text-small">As Of:</small>
    <form action="" class="row">
      <div class="col-lg-5">
        <input type="date" name="date" class="form-control" />
      </div>
      <div class="col-lg-3">
        <button type="submit" class="btn btn-primary rounded-0 btn-md w-100">Run Report</button>
      </div>
      <div class="col-lg-4">
        <button type="submit" class="btn btn-primary rounded-0 btn-md w-100">Run & Save Report</button>
      </div>
    </form>
  </div>
  
  <div class="col-lg-12 mt-4">
    <div class="table-responsive">
      <table class="table table-hover table-striped table-bordered">
        <thead>
          <th>SN</th>
          <th>Student Names</th>
          <th>Class</th>
          <th>Section</th>
          <th class="text-end">Amount Receivable</th>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>Liz Sagati</td>
            <td>S.2</td>
            <td>Day</td>
            <td class="text-end"><small class="text-small">UGX </small>{{ number_format(300000000, 2) }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <div class="col-lg-4 offset-lg-4">
    <div class="alert alert-primary p-5" role="alert">
      <h6>Choose date and run the report</h6>
    </div>
  </div>
  

</div>
@endsection
