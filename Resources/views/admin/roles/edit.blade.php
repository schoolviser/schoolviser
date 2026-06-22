@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))

@section('pageheader', 'Update Role')
@section('pageheaderDescription', 'Roles & Permissions')

@section('pageheader-controls')
  <div class="d-inline px-2">|</div>
  <a class="font-12 font-weight-bold" data-bs-toggle="modal" data-bs-target="#createRole" href="{{ route('users.create') }}">Create Role</a>
@endsection
    
@section('content')

<div class="row">

 <div class="col-lg-12">
   @if (session('updated'))
       <div class="alert alert-success alert-dismissable border-success font-12" role="alert">
         <a class="btn-close px-4 font-14" data-bs-dismiss="alert" aria-label="Close">
           <span aria-hidden="true"></span>
         </a>
         <span class="mt-0">{{session('updated')}}</span>
       </div>
   @endif
 </div>

 <div class="col-lg-12">
  @if (session('created'))
      <div class="alert alert-success alert-dismissable" role="alert">
        <a class="btn-close px-4 font-14" data-bs-dismiss="alert" aria-label="Close">
          <span aria-hidden="true"></span>
        </a>
        <span class="mt-0">{{session('created')}}</span>
      </div>
  @endif
</div>

 <div class="col-lg-6">
  <div class="card">
   <form class="card-body row" method="POST" action="{{ route('roles.update', ['id' => $role->id]) }}">
    @csrf
    <div class="col-lg-12">
     <input type="text" name="name" value="{{ old('name') ?? $role->name }}" class="form-control">
    </div>
    <div class="col-lg-12 my-3">
     <button type="submit" class="btn btn-md btn-primary rounded-4 w-100">Update</button>
    </div>
   </form>
  </div>
 </div>

 @if (count($roles))
  <div class="col-lg-6">
   @if (session('deleted'))
       <div class="alert alert-danger border-danger alert-dismissable my-3 font-12" role="alert">
         <a class="btn-close px-4 font-14" data-bs-dismiss="alert" aria-label="Close">
           <span aria-hidden="true"></span>
         </a>
         <span class="mt-0">{{session('deleted')}}</span>
       </div>
   @endif
   <div class="table-responsive">
   <table class="table table-hover table-bordered table-striped">
     <thead>
       <th>SN</th>
       <th>Role</th>
       <th>Description</th>
         <th></th>
     </thead>
     <tbody>
         @foreach ($roles as $role)
         <tr>
           <td>{{ $loop->index + 1 }}</td>
           <td class="text-capitalize">{{ $role->name }}</td>
           <td>{{ $role->description }}</td>
           <td>
             <a href="{{ route('roles.destroy', ['id' => $role->id]) }}" class=" text-danger font-12 px-2">Delete</a>
             <a href="{{ route('roles.edit', ['id' => $role->id]) }}" class="font-12 text-muted px-2">Edit</a>
           </td>
         </tr>
         @endforeach
     </tbody>
   </table>
 </div>
  </div>
  <div class="col-lg-12 text-right">
  </div>
@else
  
@endif


 <!-- Create Role MOdal -->
 <div id="createRole" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form class="modal-content" method="POST" action="{{ route('roles.store') }}">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="my-modal-title">Create Role</h5>
        <button class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body row">
        <div class="col-lg-12">
          <input type="text" name="name" class="form-control" placeholder="Role" />
          <small class="text-danger">{{ $errors->first('name') }}</small>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-md btn-primary">Save</button>
      </div>
    </form>
  </div>
</div>
  
</div>


@endsection
