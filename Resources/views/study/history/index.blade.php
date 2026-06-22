@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))


@section('pageheader', 'Study History')



@section('content')


<div class="row">

  <!-- Student Details -->
  <div class="col-xl-12 mb-2">
    <div class="card p-0 bg-transparent">
      <div class="card-body row p-1">
        <div class="col-lg-1">
          <img src="{{ asset($student->photo) }}" alt="" class="img-fluid rounded-circle p-0">
        </div>
        <div class="col-lg-10 py-2">
          <h4 class="mb-0">{{ $student->surname.' '.$student->other_names }}</h4>
          <div class="font-12 text-muted">
            <small class="text-capitalize">{{ $student->gender }}</small>
            <span>|</span>
            <small>{{ '' }}</small>
            <span>|</span>
            <small class="text-capitalize">{{ '' }}</small>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="mt-2 col-lg-12 table-car">
    @if (count($termlyRegistrations))
      
    <div class="table-responsive ">
      <table class="table table-hover table-striped table-bordered">
        <thead>
          <th>Year</th>
          <th>Term</th>
          <th>Class</th>
          <th>Section</th>
          <th class="text-end">Fee Balance</th>
        </thead>
        <tbody>
          @foreach ($termlyRegistrations as $termlyRegistration)
              <tr>
                <td>{{ $termlyRegistration->year }}</td>
                <td>{{ $termlyRegistration->term }}</td>
                <td>{{ $termlyRegistration->clazz->abbr }}</td>
                <td class="text-capitalize" font-12>{{ $termlyRegistration->residence }} <br /><small class="text-primary">{{ ($termlyRegistration->residence == 'boarding') ? 'Hostel' : '' }}</small> <small>{{ ($termlyRegistration->hostel) ? $termlyRegistration->hostel->name : '' }}</small></td>
                <td class="text-end"><small>UGX </small>{{ ($termlyRegistration->previousBalance) ? number_format($termlyRegistration->previousBalance->amount, 2) : number_format(0, 2) }}</td>
              </tr>
          @endforeach
        </tbody>
      </table>
    </div>
      
    @endif
  </div>

</div>


@endsection
