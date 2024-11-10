
@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))


@section('pageheader', 'Your Notifications')

@section('pageheader-controls')
<div class="d-inline px-2"></div>
@endsection
    

@section('content')
<div class="row">

  <div class="col-lg-12">
    @include('dashboard.includes.alerts.updated')
  </div>

  <div class="col-lg-12">
    <div
      class="table-responsive"
    >
      <table
        class="table table-hover table- table-bordered"
      >
        <tbody>
          @foreach ($notifications as $notification)
              <tr class="bg-info py-4">
                <td>{{ $notification->data['message'] }} - {{ $notification->created_at->diffForHumans() }}</td>
              </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    
    
  </div>

  <ul>
    
</ul>


</div>

@endsection
