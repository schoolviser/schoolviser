
@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))


@section('pageheader', 'buildings')
@section('pageheaderDescription', 'Setup your buildings and building categories')

@section('pageheader-controls')

<a href="" data-bs-toggle="modal" data-bs-target="#addNewBuildingModal" class="px-3 py-1 rounded-4 font-12 border border-primary text-primary">New Building</a>
<a href="" data-bs-toggle="modal" data-bs-target="#addNewRoomModal" class="px-3 py-1 rounded-4 font-12 border border-primary text-primary">New Room</a>

@endsection

@section('where-am-i')
<a href="{{route('dashboard')}}" class="font-10 bg-light py-1 px-2 rounded-4 my-1 fw-light text-dark">Dashboard</a>
<a href="" class="font-10 bg-light py-1 px-2 rounded-4 my-1 fw-bold">></a>
<a href="{{route('accounting')}}" class="font-10 bg-light py-1 px-2 rounded-4 my-1 text-dark">Settings</a>
<a href="" class="font-10 bg-light py-1 px-2 rounded-4 my-1 fw-bold">></a>
<a href="{{route('accounting.expenses')}}" class="font-10 bg-light py-1 px-2 rounded-4 my-1">Buildings</a>
@endsection
    

@section('content')

<div class="row mt-4">
  <div class="col-lg-12">
    @include('dashboard.includes.alerts.deleted')
    @include('dashboard.includes.alerts.created')
  </div>

  <div class="col-lg-2">
    <div
      class="alert alert-primary font-12"
      role="alert"
    >
      <strong>Buidlings</strong> help you to specify location for your assets
    </div>
    
  </div>

  <div class="col-lg-7">
    <div class="table-responsive">
      <table class="table table-hover table-bordered">
        <thead>
          <tr>
            <th scope="">SN</th>
            <th scope="col">Buildings</th>
            <th scope="col">Rooms</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($buildings as $building)
              <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td><span class="bg-light p-2 rounded-5 border border-light">{{ $building->name }}</span></td>
                <td>
                  @if (count($building->rooms))
                      @foreach ($building->rooms as $room)
                          <div class="font-12 bg-light rounded-3 py-1 px-2 mb-1" style="width: auto;">
                            <div class="d-inline">{{ $room->name }}</div>
                            <div class=" d-inline float-end">
                              <a href="{{ route('rooms.destroy', ['id' => $room->id]) }}" class="font-10 text-danger px-2">Delete</a>
                              <a href="" class="font-10 text-primary px-2" data-bs-toggle="modal" data-bs-target="{{ '#editRoomModal'.$room->id }}">Edit</a>
                            </div>
                          </div>
                          <!-- Edit Room Modal -->
                          <div class="modal fade" id="{{ 'editRoomModal'.$room->id }}" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
                              <form class="modal-content" method="POST" action="{{ route('rooms.update', ['id' => $room->id]) }}">
                                @csrf
                                <div class="modal-header">
                                  <h5 class="modal-title font-12" id="modalTitleId">Edit Room Info</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body row">
                                  <div class="col-lg-12">
                                    <label for="name" class="font-12 text-muted">Room Name</label>
                                    <input type="text" name="name" id="name" value="{{ $room->name }}" class="form-control">
                                  </div>
                                  <div class="col-lg-12 ">
                                    <label for="roomType" class="font-12 text-muted">Room Type</label>
                                    <select name="room_type" id="roomType" class="form-control">
                                      <option value="default" {{ ($room->room_type == 'default') ? 'selected' : '' }}>Default</option>
                                      <option value="default" {{ ($room->room_type == 'office') ? 'selected' : '' }}>Office</option>
                                      <option value="default" {{ ($room->room_type == 'store') ? 'selected' : '' }}>Store</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary btn-sm rounded-4 px-3" data-bs-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-primary btn-sm px-3 rounded-4">Update</button>
                                </div>
                              </form>
                            </div>
                          </div>
                          
                          
                          <!-- Optional: Place to the bottom of scripts -->
                          <script>
                            const myModal = new bootstrap.Modal(document.getElementById('modalId'), options)
                          
                          </script>
                      @endforeach
                  @else
                      add rooms here
                  @endif
                </td>
                <td>
                  <a href="" class="btn btn-sm btn-danger font-12 rounded-4 px-2">Delete</a>
                  <a href="" class="btn btn-sm btn-primary font-12 rounded-4 px-2">Edit Building</a>
                </td>
              </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    
  </div>
  <div class="col-lg-3">
    <div class="row">

      <div class="col-lg-12 mb-2">
        <h6 class="mb-1 py-0" style="border-bottom: 1px solid #cfcfcf;" >
          <span style="background-color: #e9e1e1; font-weight: 500;" class="px-3 py-1 text-uppercase fw-bold font-12">School</span></h6>
      </div>

      <div class="col-lg-6">
        <div class="list-unstyled">
          <li><a href="{{ route('settings.general') }}" class="text-small link rounded-1">School Info</a></li>
          <li><a href="{{ route('settings.current.term') }}" class="text-small link rounded-1">Current Term</a></li>
          <li><a href="{{ route('buildings') }}" class="text-small link rounded-1">Buildings</a></li>
          <li><a href="{{ route('buildings') }}" class="text-small link rounded-1">Departments</a></li>
        </div>
      </div>


    </div>
  </div>
</div>


<!--  addNewBuildingModal-->
<div
  class="modal fade"
  id="addNewBuildingModal"
  tabindex="-1"
  data-bs-backdrop="static"
  data-bs-keyboard="false"
  
  role="dialog"
  aria-labelledby="modalTitleId"
  aria-hidden="true"
>
  <div
    class="modal-dialog modal-dialog-scrollable modal-sm"
    role="document"
  >
    <form class="modal-content" method="POST" action="{{route('buildings.store')}}">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title font-12" id="modalTitleId">
          Add New Building
        </h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body row">
        <div class="col-lg-12">
          <input type="text" name="name" class="form-control" placeholder="BUidling Name" value="{{old('name')}}"  />
          <small class="text-danger">{{ $errors->first('name') }}</small>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary w-100 rounded-5">Save</button>
      </div>
    </form>
  </div>
</div>


<!-- Modal Body -->
<!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
<div
  class="modal fade"
  id="addNewRoomModal"
  tabindex="-1"
  data-bs-backdrop="static"
  data-bs-keyboard="false"
  
  role="dialog"
  aria-labelledby="modalTitleId"
  aria-hidden="true"
>
  <div
    class="modal-dialog modal-dialog-scrollable  modal-sm"
    role="document"
  >
    <form class="modal-content" method="POST" action="{{route('rooms.store')}}">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title font-12" id="modalTitleId">
          Add New Room For Building
        </h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body row">
        <div class="col-lg-12 mb-1">
          <select name="building" id="" class="form-control">
            <option value="">Choose Buidling</option>
            @foreach ($buildings as $building)
                <option value="{{$building->id}}">{{ $building->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-lg-12">
          <input type="text" class="form-control" name="room_name" placeholder="Room Name" />
        </div>
      </div>
      <div class="modal-footer">
        
        <button type="submit" class="btn btn-primary w-100 rounded-5">Save</button>
      </div>
    </form>
  </div>
</div>

<!-- Optional: Place to the bottom of scripts -->
<script>
  const myModal = new bootstrap.Modal(
    document.getElementById("modalId"),
    options,
  );
</script>



@endsection
