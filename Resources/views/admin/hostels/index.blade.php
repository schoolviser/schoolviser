@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))

@section('pageheader', 'Manage Hostels')
@section('pageheaderDescription', 'Hostels')

@section('pageheader-controls')
<a class="px-3 py-1 rounded-4 font-12 border border-primary   text-primary" href="{{route('hostels.students')}}">Nanage Students In Hostels</a>
<a class="px-3 py-1 rounded-4 font-12 border border-primary   text-primary" href="" data-bs-toggle="modal" data-bs-target="#addNewHostelModal">Add new</a>

@endsection

@section('content')
    <div class="row">
      <div class="col-lg-12">
        <div class="table-responsive">
          <table class="table table-primary">
            <thead>
              <th>SN</th>
              <th>Hostel</th>
              <th>Buidling</th>
              <th>Rooms</th>
              <th>Students</th>
            </thead>
            <tbody>
             @foreach ($hostels as $hostel)
             <tr class="">
              <td scope="row">{{ $loop->index + 1 }}</td>
              <td>{{$hostel->name}}</td>
              <td>{{($hostel->building) ? $hostel->building->name : 'not linked'}}</td>
              <td>{{$hostel->rooms_count}}</td>
              <td>{{$hostel->termly_registrations_count}}</td>
            </tr>
             @endforeach
            </tbody>
          </table>
        </div>
        
      </div>
    </div>
    
    <!-- Modal Body -->
    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
    <div class="modal fade" id="addNewHostelModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalTitleId">Modal title</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Body
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save</button>
          </div>
        </div>
      </div>
    </div>
    
    
    <!-- Optional: Place to the bottom of scripts -->
    <script>
      const myModal = new bootstrap.Modal(document.getElementById('modalId'), options)
    
    </script>
@endsection