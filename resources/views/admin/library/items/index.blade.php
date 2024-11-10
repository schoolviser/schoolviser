@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))

@section('pageheader', 'Library')
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
            <th>Title</th>
            <th>Item Type</th>
            <th>Copies</th>
            <th>ISBN</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($items as $item)
          <tr class="">
            <td>{{ $loop->index + 1 }}</td>
            <td class="">
              <img src="{{ asset($item->cover) }}" alt="" class="img-fluid">
            </td>
            <td>
              <span class="font-12 text-primary bg-light p-1 fw-bold">{{ $item->title }}</span>
            </td>
            <td>
              <span class="font-12 text-primary bg-light p-1 fw-bold">{{ $item->itemType->name }}</span>
            </td>
            <td>
              <span class="font-12 text-primary bg-light p-1 fw-bold">{{ $item->isbn ?? $item->issn }}</span>
            </td>
            <td>
              <span class="font-12 text-primary bg-light p-1 ">{{ $item->copies_count }}</span>
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