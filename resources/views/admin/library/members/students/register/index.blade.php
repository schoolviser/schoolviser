@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))

@section('pageheader', 'Register Member')
@section('pageheaderDescription', 'Below is listing of current unregistered students to the library membership')

@section('pageheader-controls')

@endsection

 @section('content')
     <div class="row mt-3">

      <div class="col-lg-12">
        <div class="table-responsive">
          <table class="table table-hover table-striped table-bordered">
            <thead>
              <tr>
                <th style="width: 5%;">SN</th>
                <th>Names</th>
                <th>Gender</th>
                <th>Clazz</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($students as $student)
              <tr class="">
                <td>{{ $loop->index + 1 }}</td>
                <td>
                  <span>{{ $student->first_name }}</span>
                  <span>{{ $student->last_name }}</span>
                </td>
                <td>
                  <span>{{ $student->gender }}</span>
                </td>
                <td>
                  <span>{{ $student->currentTermlyRegistration->clazz->abbr }}</span>
                </td>
                <td>
                  <button class="btn btn-sm btn-primary rounded-5 px-3" data-bs-toggle="modal" data-bs-target="{{'#registerStudentModal'.$student->id}}">Register {{ $student->first_name }}</button>
                  <!-- Modal Body -->
                  <div class="modal fade" id="{{'registerStudentModal'.$student->id}}" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
                      <form class="modal-content" method="POST" action="{{ route('library.members.register.student.process', ['id' => $student->id]) }}">
                        @csrf
                        <div class="modal-header">
                          <h5 class="modal-title font-13" id="modalTitleId">
                            Register student to library membership
                          </h5>
                          <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                          ></button>
                        </div>
                        <div class="modal-body row">
                          <div class="col-lg-12 my-4">
                            <span class="bg-warning px-3 py-1 rounded-5 font-13 my-1">{{ $student->regno }}</span>
                            <span class="bg-warning px-3 py-1 rounded-5 font-13 my-1">{{ $student->first_name.' '.$student->last_name }}</span>
                            <span class="bg-warning px-3 py-1 rounded-5 font-13 my-5">{{ $student->currentTermlyRegistration->clazz->abbr }}</span>

                          </div>
                          <div class="col-lg-12 my-2">
                            <label for="" class="font-10 text-muted mb-1">Access Number</label>
                            <input type="text" name="access_number" class="form-control" placeholder="Access Number" value="{{ old('access_number') }}" />
                            <small class="text-danger font-10">{{ $errors->first('access_number') }}</small>
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

     </div>
 @endsection