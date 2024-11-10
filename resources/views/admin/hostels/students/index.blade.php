@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))

@section('pageheader', 'Hostel Students')
@section('pageheaderDescription', 'Hostels')

@section('pageheader-controls')
<a class="px-3 py-1 rounded-4 font-12 border border-primary   text-primary" href="{{route('hostels.students')}}">Nanage Students In Hostels</a>
<a class="px-3 py-1 rounded-4 font-12 border border-primary   text-primary" href="" data-bs-toggle="modal" data-bs-target="#addNewHostelModal">Add new</a>

@endsection

@section('content')
    <div class="row">
      <div class="col-lg-12">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <th>SN</th>
              <th>Names</th>
              <th>Gender</th>
              <th>Clazz</th>
              <th>Hostel</th>
            </thead>
            <tbody>
             @foreach ($registrations as $registration)
             <tr class="">
              <td scope="row">{{ $loop->index + 1 }}</td>
              <td>{{$registration->student->first_name.' '.$registration->student->last_name}}</td>
              <td class="text-capitalize">{{$registration->student->gender}}</td>
              <td>{{$registration->clazz->abbr}}</td>
              <form action="{{ route('hostels.allocate', ['termly_registration_id' => $registration->id]) }}" method="POST" class="allocate-hostel-form">
                @csrf
                @if ($registration->student->gender == 'male')
                @if ($registration->hostel_id)
                <td>
                  <select name="hostel" id="" class="form-control allocate-hostel-select" data-bs-url="{{ 'hello' }}">
                    @foreach ($boysHostels as $hostel)
                      <option value="{{ $hostel->id }}" {{ ($hostel->id == $registration->hostel_id) ? 'selected' : ''}}>{{ $hostel->name }}</option>
                    @endforeach
                  </select>
                </td>
                @else
                <td>
                  <select name="hostel" id="" class="form-control allocate-hostel-select">
                    <option value="">Choose hostel</option>
                    @foreach ($boysHostels as $hostel)
                      <option value="{{ $hostel->id }}">{{ $hostel->name }}</option>
                    @endforeach
                  </select>
                </td>
                @endif
              @else
              @if ($registration->hostel_id)
                <td>
                  <select name="hostel" id="" class="form-control allocate-hostel-select">
                    @foreach ($girlsHostels as $hostel)
                      <option value="{{ $hostel->id }}" {{ ($hostel->id == $registration->hostel_id) ? 'selected' : ''}}>{{ $hostel->name }}</option>
                    @endforeach
                  </select>
                </td>
                @else
                <td>
                  <select name="hostel" id="" class="form-control allocate-hostel-select">
                    <option value="">Choose hostel</option>
                    @foreach ($girlsHostels as $hostel)
                      <option value="{{ $hostel->id }}">{{ $hostel->name }}</option>
                    @endforeach
                  </select>
                </td>
                @endif
              @endif
              </form>
            </tr>
             @endforeach
            </tbody>
          </table>
        </div>

        <div class="div py-3">
          {{$registrations->links()}}
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