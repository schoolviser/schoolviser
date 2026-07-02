@extends(config('delxero.dashboard_layout', 'schoolviser::layouts.main_layout'))

@section('module-page-heading', 'Students')

@section('module-page-actions')
<a href="{{route('students.create')}}" class="btn btn-sm btn-light">Add Student</a>
<a href="{{route('students.unregistered')}}" class="btn btn-sm btn-light">Unregistered Students</a>
@endsection

@section('hello')
    {{ $term->academicYear?->name.' '.$term->name }}
@endsection

@section('module-breadcrumbs')
<x-ui.breadcrumb :items="[
    [
        'label' => 'Manage Students',
        'url' => route('students.index')
    ]
    
]" />
@endsection

@section('content')

<div class="card">

  @if (count($students))
    <div class="card-body">

      <div class="table-responsive">
        <table class="table table-hover align-middle table-row-dashed fs-6 gy-5" id="studentsTables">
          <thead>
            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
              <th>
                <input type="checkbox" class="form-check-input" id="selectAllStudents" />
              </th>
              <th>*</th>
              <th>ID</th>
              <th>Names</th>
              <th>Gender</th>
              <th>Clazz</th>
              <th>Stream</th>
              <th>Residence</th>
              <th>New Or Old</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
              @foreach ($students as $student)
                <tr class="">
                  <td>
                      <input type="checkbox" class="student-checkbox form-check-input" value="{{ $student->uuid }}">
                  </td>
                  <td style="width: 5%;" class="py-lg-3">
                      <img src="{{ $student->photo ? asset('storage/'.$student->photo) : asset('media/avatars/blank.png') }}" class="img-fluid" alt="">
                  </td>
                  <td><a href="{{ route('students.profile', ['id' => $student->uuid]) }}" style="text-decoration: none;"><small class="font-12 bg-light ">{{ $student->regno ?? $student->access_number }}</small></a></td>
                  <td>
                    <a href="{{ route('students.profile', ['id' => $student->uuid]) }}" style="text-decoration: none;" class="pl-5"><span class="font-14 bg-light py-1 px-3 rounded-4 fw- text-dark">{{ $student->first_name." ".$student->last_name }}</span></a>
                  </td>
                  <td><small class="text-capitalize">{{ $student->gender }}</small></td>
                  <td><small class="font-weight-bold text-capitalize">{{ $student->clazz->name }}</small></td>
                  <td><small class="font-weight-bold text-capitalize">{{ $student->stream->name }}</small></td>
                  <td><small class="font-weight-bold text-capitalize">{{ $student->registration->residence }}</small></td>
                  <td><small class="font-weight-bold text-capitalize">{{ $student->registration->new_or_continuing }}</small></td>
                  <td class="text-center">
                    <a href="{{ route('students.show', ['id' => $student->uuid]) }}" class="btn btn-sm btn-primary"><i class="bi bi-eye"></i></a>
                    <a href="{{ route('students.delete', ['id' => $student->id]) }}" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="{{ '#confirmStudentDeleteModal'.$student->id }}"><i class="bi bi-trash"></i></a>
                  </td>
                </tr>
              @endforeach
          </tbody>
        </table>
      </div>
      
    </div>
    <div class="card-footer">
      {{ $students->links() }}
    </div>
  @else
  <div class="text-center p-5">
    <a href=""><img src="{{asset('icons/addnewitem.svg')}}" class="w-10" style="width: 15%;" alt=""></a>
  </div>
  @endif
  
</div>


@endsection
