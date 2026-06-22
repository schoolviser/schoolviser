@extends(setting('dashboard_view_layout', auth()->user(), config('settings.dashboard_view_layout', 'dashboard.layouts.horizontal')))


@section('pageheader', 'Registered Students')
@section('pageheaderDescription', 'Register Student')

@section('content')

<div class="row my-3">
  <div class="col-lg-12">
    @include('dashboard.includes.alerts.created')
  </div>
  <div class="col-lg-12">
    <span class="px-3 py-1 bg-white fw-light fst-italic font-14 border border-primary rounded-5">Register student for this term</span>
    <span class="px-3 py-1 bg-white font-14 border fst-italic border-primary rounded-5">{{ 'Term '.term()->term.', '.term()->year }}</span>
  </div>
</div>
@if (count($currentRegistrations))
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
            <th>Registered On</th>
            <th class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($currentRegistrations as $registration)
              <tr class="">
                <td style="width: 5%;">{{ $loop->index + 1 }}</td>
                <td><a href="{{ route('students.profile', ['id' => $registration->student->id]) }}" style="text-decoration: none;"><small class="font-12 bg-warning px-2 py-1 rounded-4 fw-bold text-dark">{{ $registration->student->regno ?? $registration->student->id }}</small></a></td>
                <td>
                  <a href="{{ route('students.profile', ['id' => $registration->student->id]) }}" style="text-decoration: none;" class="pl-5"><span class="font-14 bg-light py-1 px-3 rounded-4 fst-italic text-dark">{{ $registration->student->first_name." ".$registration->student->last_name }}</span></a> 
                </td>
                <td><small class="text-capitalize">{{ $registration->student->gender }}</small></td>
                <td><span class="font-12 bg-warning px-2 py-1 rounded-4 fw-200 text-dark text-capitalize fst-italic">{{ $registration->clazz->abbr }}</span></td>
                <td><span class="font-12 bg-warning px-2 py-1 rounded-4 fw-200 text-dark text-capitalize fst-italic">{{ $registration->residence }}</span></td>
                <td><span class="font-12 bg-warning px-2 py-1 rounded-4 fw-200 text-dark text-capitalize fst-italic">{{ $registration->new_or_continuing }}</span></td>
                <td><span class="font-12 bg-warning px-2 py-1 rounded-4 fw-200 text-dark text-capitalize fst-italic">{{ $registration->created_at }}</span></td>
                <td class="text-center">
                  <a href="{{ route('students.delete', ['id' => $registration->student->id]) }}" class="btn btn-md btn-white px-3 rounded-4 text-danger border border-danger" data-bs-toggle="modal" data-bs-target="{{ '#confirmStudentDeleteModal'.$registration->student->id }}" style="font-size:10px;">Delete</a>

                  @include('dashboard.includes.modals.confirm_student_deletion_modal', [
                    'student_id' => $registration->student->id,
                    'student_names' => $registration->student->fullname
                  ])

                </td>
              </tr>
            @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <div class="col-lg-12 my-2">
    {{ $currentRegistrations->links() }}
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
  <a href="{{ route('students.registration.register') }}"><img src="{{asset('icons/addnewitem.svg')}}" class="w-10" style="width: 15%;" alt=""></a>
 </div>
</div>
@endif



@endsection
