@extends('layouts.master')

@section('pageheader', 'Payroll August 2023')

@section('pageheader-controls')
@endsection
    
@section('content')
<div class="row">
  <div class="col-12 grid-margin table-card">
    <div class="card">
      <div class="card-body m-1">
            <div class="table-responsive">
              <table class="table  table-hover table-bordered table-striped">
                <thead>
                  <th>Employee</th>
                  <th>Gross Pay</th>
                  <th>NSSF</th>
                  <th>Payee</th>
                  <th>Net Pay</th>
                </thead>
                <tbody>
                  <tr>
                    <td>Okello Stephen Omoding</td>
                    <td>UGX 20,000,000</td>
                    <td>UGX 20,000,000</td>
                    <td>UGX 20,000,000</td>
                    <td>UGX 20,000,000</td>
                    <td>
                      <a href="" class="text-small text-capitalize btn btn-sm btn-primary">view Payroll</a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="pagination-links my-2">
            </div>
             
      </div>
    </div>
  </div>
</div>
@endsection
