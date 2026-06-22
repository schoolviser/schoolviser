@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))


@section('pageheader', 'Requisitions')
@section('pageheaderDescription', 'My Requisitions')

@section('pageheader-controls')

<div class="d-inline px-2">|</div>

<a href="{{ route('account.make.requisitions') }}" class="d-inline font-12 cursor-pointer font-weight-bold text-primary">Make Requisition</a>


@endsection

@section('content')
<div class="row mt-4">

 <div class="col-lg-12 mb-4">
  <div class="row">

   <div class="col-lg-2">
    <div class="card rounded-5 border-success">
     <div class="card-body">
      <h3 style="font-weight: 700;">3</h3>
      <h6 class="text-muted">Requisitions</h6>
     </div>
    </div>
   </div>

   <div class="col-lg-2">
    <div class="card rounded-5 py-0 border-danger">
     <div class="card-body">
      <h3>30</h3>
      <h6 class="text-muted">Pending</h6>
     </div>
    </div>
   </div>

   <div class="col-lg-2">
    <div class="card rounded-5 py-0 border-primary">
     <div class="card-body">
      <h3>30</h3>
      <h6 class="text-muted">Approved</h6>
     </div>
    </div>
   </div>

  </div>
 </div>

 <div class="col-lg-12">
  <div class="table-responsive rounded-4">
   <table class="table table-striped table-hover table-bordered">
    <thead>
     <th>SN</th>
     <th>Description</th>
     <th>Date</th>
     <th>Status</th>
     <th>Amount</th>
     <th></th>
    </thead>
    <tbody>
     @foreach ($requisitions as $requisition)
         <tr>
          <td>{{ $loop->index + 1 }}</td>
          <td>{{ $requisition->description }}</td>
          <td>{{ $requisition->date }}</td>
          <td>{{ $requisition->date }}</td>
          <td>{{ number_format($requisition->items->sum('amount') , 2)}}</td>
         </tr>
     @endforeach
    </tbody>
   </table>
  </div>
 </div>

</div>
@endsection
