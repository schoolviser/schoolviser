@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))


@section('pageheader', 'Unregistered Old Students')
@section('pageheaderDescription', 'Register Student')


@section('content')

@php
    $clazzs = clazzs();
@endphp

<div class="row my-3">
  <div class="col-lg-12">
    @include('dashboard.includes.alerts.created')
  </div>
  <div class="col-lg-12">
    <span class="px-3 py-1 bg-white fw-light fst-italic font-14 border border-primary rounded-5">Register student for this term</span>
    <span class="px-3 py-1 bg-white fw-light font-14 border fst-italic border-primary rounded-5">{{ 'Term '.term()->term.', '.term()->year }}</span>
  </div>
</div>
@if (count($previousUnregisteredStudents))
  <div class="col-xl-12">
    <div class="table-responsive">
      <table class="table table-hover table-bordered table-striped" id="studentsTables">
        <thead>
          <tr>
            <th></th>
            <th>Reg No</th>
            <th>Name</th>
            <th>Gender</th>
            <th>Class</th>
            <th>Section</th>
            <th>New Or Old</th>
            <th class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($previousUnregisteredStudents as $student)
              <tr class="">
                <td style="width: 5%;">{{ $loop->index + 1 }}</td>
                <td><a href="{{ route('students.profile', ['id' => $student->id]) }}" style="text-decoration: none;"><small class="font-12 bg-warning px-2 py-1 rounded-4 fw-bold text-dark">{{ $student->regno ?? $student->id }}</small></a></td>
                <td>
                  <a href="{{ route('students.profile', ['id' => $student->id]) }}" style="text-decoration: none;" class="pl-5"><span class="font-14 bg-light py-1 px-3 rounded-4 fst-italic text-dark">{{ $student->first_name." ".$student->last_name }}</span></a> 
                </td>
                <td><small class="text-capitalize">{{ $student->gender }}</small></td>
                <td><span class="font-12 bg-warning px-2 py-1 rounded-4 fw-200 text-dark text-capitalize fst-italic">{{ $student->previousTermlyRegistration->clazz->abbr }}</span></td>
                <td><span class="font-12 bg-warning px-2 py-1 rounded-4 fw-200 text-dark text-capitalize fst-italic">{{ $student->previousTermlyRegistration->residence }}</span></td>
                <td><span class="font-12 bg-warning px-2 py-1 rounded-4 fw-200 text-dark text-capitalize fst-italic">{{ $student->previousTermlyRegistration->new_or_continuing }}</span></td>
                <td class="text-center">
                  <a href="" class="btn btn-md btn-white px-3 rounded-4 text-success border border-success" data-bs-toggle="modal" data-bs-target="{{ '#registerOldStudentModal'.$student->id }}" style="font-size:10px;">Register</a>

                  <!-- Register old student modal -->
                  <div class="modal fade" id="{{ 'registerOldStudentModal'.$student->previousTermlyRegistration->student->id }}"
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
                      <form class="modal-content" action="{{ route('students.registration.register.old.process', ['id' => $student->id]) }}" method="POST">
                        @csrf
                        <div class="modal-header">
                          <h5 class="modal-title font-14 fst-italic" id="modalTitleId">
                            Register {{ $student->first_name }}
                          </h5>
                          <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                          ></button>
                        </div>
                        <div class="modal-body row">
                          <div class="col-lg-12 my-1">
                            <select name="clazz" id="" class="form-control">
                              @foreach ($clazzs as $clazz)
                                  <option value="{{ $clazz->id }}" {{ ($student->previousTermlyRegistration->clazz_id == $clazz->id) ? 'selected' : '' }}>{{ $clazz->name }}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="col-lg-12 my-1">
                            <select name="residence" id="" class="form-control">
                              <option value="day" {{ ($student->previousTermlyRegistration->residence == 'day') ? 'selected' : '' }}>Day</option>
                              <option value="boarding" {{ ($student->previousTermlyRegistration->residence == 'boarding') ? 'selected' : '' }}>Boarding</option>
                            </select>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button
                            type="button"
                            class="btn btn-secondary rounded-5 px-3"
                            data-bs-dismiss="modal"
                          >
                            Close
                          </button>
                          <button type="submit" class="btn btn-primary rounded-5 px-3">Register</button>
                        </div>
                      </form>
                    </div>
                  </div>
                  

                </td>
              </tr>
            @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <div class="col-lg-12 my-2">
    {{ $previousUnregisteredStudents->links() }}
  </div>
@else
<div class="col-xl-12">
  <div class="table-responsive">
    <table class="table table-hover table-bordered table-striped" id="studentsTables">
      <thead>
        <tr>
          <th></th>
          <th>Reg No</th>
          <th>Name</th>
          <th>Gender</th>
          <th>Class</th>
          <th>Section</th>
          <th>New Or Old</th>
          <th class="text-center">Actions</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
  <div class="text-center p-5">
   <a href="{{ route('students.registration.register') }}">
    <img src="{{asset('icons/addnewitem.svg')}}" class="w-10" style="width: 10%;" alt="">
  </a>
  <h6 class="py-4 fw-light font-16 fst-italic">No old students to register....</h6>
  </div>
 </div>
@endif


@endsection
