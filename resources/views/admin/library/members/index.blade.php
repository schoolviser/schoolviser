@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))

@section('pageheader', 'Library Members')
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
                <th style="width: 5%;">...</th>
                <th>Names</th>
                <th>Accee Number</th>
                <th>Registered On</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($members as $member)
              <tr class="">
                <td>{{ $loop->index + 1 }}</td>
                <td class="">
                  <img src="{{ asset($member->member->photo) }}" alt="" class="img-fluid">
                </td>
                <td>
                  <span class="font-12 text-primary bg-light p-1 fw-bold">{{ $member->member->first_name.' '.$member->member->last_name }}</span>
                </td>
                <td>
                  <span class="font-12 text-primary bg-light p-1 fw-bold">{{ $member->access_number }}</span>
                </td>
                <td>
                  <span class="font-12 text-primary bg-light p-1 ">{{ $member->joined_on }}</span>
                </td>
                <td>R1C3</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        
      </div>

     </div>
 @endsection