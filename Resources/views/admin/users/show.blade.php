@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))


@section('title', 'User Profile')

@section('pageheader', $user->first_name.' '.$user->last_name)
@section('pageheaderDescription', 'User Details')

@section('pageheader-controls')
<a class="font-12 font-weight-bold" href="{{ route('roles.permissions') }}">Roles & Permission</a>

<div class="d-inline px-2">|</div>
<a class="font-12 font-weight-bold" href="{{ route('users.create') }}">Add User</a>

@endsection

@section('content')
<div class="row mt-4">

      <!-- Student Photo -->
      <div class="col-lg-3">
        <div class="card rounded-3 border border-primary">
          <div class="card-header">
            <img src="{{ asset('images/avator.png') }}" class="img-fluid rounded-4 student-avator w-100" alt="image" />

          </div>
          <div class="card-body p-0">
              <form action="" method="POST" enctype="multipart/form-data" class="m-2">
                @csrf
                <label for="choosePhoto" class="custom-file-upload text-small text-muted border border-primary py-1 px-2 rounded-4">
                  Choose Photo
                </label>
                <input type="file" id="choosePhoto" name="photo" class="render-image-on-input-file-change d-none" data-imgholder=".student-avator" />
                <input type="submit" class="btn btn-sm btn-white border rounded-4 border-dark font-12" id="avatorChangeBtn" value="Upload" />
                <small class="text-danger"></small>
              </form>
          </div>
        </div>
      </div>

      <div class="col-lg-6">

        <!-- Employee personal info -->
        <div class="card rounded-4 border-primary mb-4">
          <div class="card-body row">
          
            <div class="col-sm-6 col-lg-12">
              <h2 class="text-primary fw-bold fs-4">{{ $user->usertype->first_name.' '.$user->usertype->last_name }}</h2>
              <small class="text-end fw-bold text-danger">
              </small>
              <hr />
            </div>
  
            @if ($user->name)
            <div class="col-lg-4 my-2">
              <div class="pl-2">
                <span class="font-10 text-muted text-uppercase mb-1">Username</span><br />
                <span class="mb-0 font-14 px-2 py-1 rounded-4 bg-light  fw-light fst-italic"> {{ $user->name }}</span>
                <a href="" class="font-12" data-bs-toggle="modal" data-bs-target="#editUsernameModal">Edit</a>

                
                <!-- Modal Body -->
                <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                <div class="modal fade" id="editUsernameModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"  role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-scrollable modal-sm" role="document">
                    <form class="modal-content " method="POST" action="{{ route('users.update.username', ['id' => $user->id]) }}">
                      @csrf
                      <div class="modal-header">
                        <h5 class="modal-title font-112" id="modalTitleId">
                          Edit Uusername of {{ $user->usertype->first_name }}
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
                          <input type="text" name="username" class="form-control" value="{{ $user->name }}" />
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-sm rounded-4 px-3">Update</button>
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
                

              </div>
            </div>
            @endif
            @if ($user->email)
            <div class="col-lg-8 my-2">
              <div class="pl-2">
                <span class="font-10 text-muted text-uppercase mb-1">Email</span><br />
                <span class="mb-0 font-14 px-2 py-1 rounded-4 bg-light  fw-light fst-italic"> {{ $user->email }}</span>
              </div>
            </div>
            @endif
            
            <div class="col-lg-4 my-2">
              <div class="pl-2">
                <span class="font-10 text-muted text-uppercase mb-1">Role</span><br />
                @if ($user->role)
                  <span class="mb-0 font-14 px-2 py-1 rounded-4 bg-light  fw-light fst-italic"> {{ $user->role->name }}</span>
                @else
                  <!-- Modal trigger button -->
                  <button type="button" class="btn btn-primary btn-sm rounded-4 px-2 font-12" data-bs-toggle="modal" data-bs-target="#modalId">
                    Assign role
                  </button>
                  
                  <!-- Modal Body -->
                  <!-- if you want to close by  clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                  <div class="modal fade" id="modalId" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
                    
                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm"  role="document" >
                      
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="modalTitleId">
                            Modal title
                          </h5>
                          <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                          ></button>
                        </div>
                        <div class="modal-body">Body</div>
                        <div class="modal-footer">
                          <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                          >
                            Close
                          </button>
                          <button type="button" class="btn btn-primary">Save</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <!-- Optional: Place to the bottom of scripts -->
                  <script>
                    const myModal = new bootstrap.Modal(
                      document.getElementById("modalId"),
                      options,
                    );
                  </script>
                  
                @endif
              </div>
            </div>
  
            
          </div>
        </div>

        <!-- Logins -->
        <div class="card rounded-4 border-primary">
          <div class="card-body row">
          
            <div class="col-sm-6 col-lg-12">
              <h4 class="font-16 fst-italic  fw-light">Authentication Logins</h4>
              <small class="text-end fw-bold text-danger">
              </small>
              <hr />
            </div>
  
            <div>
              hello
            </div>
  
            
          </div>
        </div>
        

      </div>

      <div class="col-lg-3">
        <button class="btn btn-primary btn-md rounded-4 w-100" data-bs-target="#my-collapse" data-bs-toggle="collapse" aria-expanded="false" aria-controls="my-collapse">Change Password</button>
        <small class="font-12 text-danger">{{ $errors->first('password') }}</small>
        <form id="my-collapse" class="collapse card rounded-4 my-3" action="{{ route('users.change.password', ['id' => $user->id]) }}" method="POST">
         @csrf
         <div class="card-body py-4 px-3">
          <label for="password" class="font-12">New Password</label>
          <input type="password" name="password" class="form-control mb-2" placeholder="New Password" />
          <input type="password" name="password_confirmation" class="form-control mb-2" placeholder="Confirm Password" />
          <small class="font-12 text-danger">{{ $errors->first('password') }}</small>
          <button type="submit" class="btn btn-md btn-danger rounded-4 w-100 my-3">Update</button>
         </div>
        </form>
      </div>

</div>

@endsection