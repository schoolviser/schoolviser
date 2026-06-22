@extends('layouts.master')

@section('pageheader', 'Payrolls')

@section('pageheader-controls')
@endsection
    
@section('content')
<div class="row">
  <div class="col-12 grid-margin table-card">
    <div class="card">
      <div class="card-body m-1">
        @if (count($payrolls))
            <div class="table-responsive">
              <table class="table  table-hover table-bordered table-striped">
                <thead>
                  <th>Name</th>
                  <th>Members</th>
                  <th>Expense</th>
                  <th></th>
                </thead>
                <tbody>
                  <tr>
                    <td>July 2023</td>
                    <td>30</td>
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
        @else
            
        @endif        
      </div>
    </div>
  </div>
</div>
@endsection
