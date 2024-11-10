@extends('dashboard.layouts.master')

@section('pageheader', 'My Requisitions')
@section('pageheaderDescription', 'Manage School Requisitions')

@section('pageheader-controls')
<a href="{{ route('requisitions.purchase.create') }}" class="d-inline text-small text-muted cursor-pointer link rounded-1 text-primary">Record Requisition</a>
<div class="d-inline px-1">|</div>

<a href="{{ route('requisitions.purchase.create') }}" class="d-inline text-small text-muted cursor-pointer link rounded-1 text-primary">Make Purchase Requisition</a>
@endsection

@section('content')

<div class="row">
  <div class="col-lg-12">
    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <thead>
          <th>SN</th>
          <th>Req Number</th>
          <th>Date</th>
          <th>Department</th>
          <th>Requested By</th>
          <th>Expense</th>
          <th>Amount/Items</th>
          <th></th>
        </thead>
        <tbody>
          @foreach ($requisitions as $requisition)
          <tr class="bg-light">
            <td style="width: 5%;">{{ $loop->index + 1 }}</td>
            <td><a href="{{route('requisitions.show')}}">{{ $requisition->number }}</a></td>
            <td>{{ $requisition->date }}</td>
            <td>{{ ($requisition->department) ? $requisition->department->name : '' }}</td>
            <td>{{ $requisition->requester->first_name.' '.$requisition->requester->last_name }}</td>
            <td>{{ ($requisition->expenseCategory) ? $requisition->expenseCategory->name : 'No Expense Category' }}</td>
            <td>
              @if ($requisition->type == 'purchase')
                  {{ $requisition->requisitionItems()->sum('rate') }}
              @else
                  
              @endif
            </td>
            <td><a data-bs-target="{{ '#collapse'.$requisition->id }}" data-bs-toggle="collapse" class="text-muted font-12">Details</a></td>
            <td></td>
          </tr>
          <tr class="collapse" id="{{ 'collapse'.$requisition->id }}">
            <td colspan="6">
              @if ($requisition->type == 'purchase')
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <th>SN</th>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Rate</th>
                  </thead>
                  <tbody>
                    @foreach ($requisition->requisitionItems as $item)
                        <tr>
                          <td>{{ $loop->index + 1 }}</td>
                          <td>{{ $item->name }}</td>
                          <td>{{ $item->quantity }}</td>
                          <td>{{ number_format($item->rate, 2) }}</td>
                        </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              @else
                  
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="row">

</div>




@endsection
