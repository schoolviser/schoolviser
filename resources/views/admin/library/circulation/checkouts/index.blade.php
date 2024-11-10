@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))

@section('pageheader', 'Library Check Outs')
@section('pageheaderDescription', 'Manage Your Library Items')

@section('pageheader-controls')

@endsection

 @section('content')
     <div class="row">

      <div class="col-lg-12">
        <div class="table-responsive">
          <table class="table table-hover table-striped table-bordered">
            <thead>
              <tr>
                <th style="width: 5%;">SN</th>
                <th>Date</th>
                <th>Item</th>
                <th>Barcode</th>
                <th>Due Date</th>
                <th>Renewals</th>
                <th>Patron</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              
            </tbody>
          </table>
        </div>
        
      </div>

     </div>
 @endsection