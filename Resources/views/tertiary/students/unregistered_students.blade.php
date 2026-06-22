@extends(config('delxero.dashboard_layout', 'schoolviser::layouts.main_layout'))

@section('module-page-heading', 'Students Information')

@section('hello')
    @php
        $term = term();
    @endphp
    {{ $term->academicYear?->name.' '.$term->name }}
@endsection

@section('module-page-actions')
<a href="{{route('tertiary.students.create')}}" class="btn btn-sm btn-light">Add Student</a>

@endsection

@section('module-breadcrumbs')
<x-ui.breadcrumb :items="[
    [
        'label' => 'Manage Students',
        'url' => route('tertiary.students.index')
    ],
    [
        'label' => 'Students Information',
        'url' => route('tertiary.students.index')
    ],
    [
        'label' => 'Unregisered Students',
        'url' => route('tertiary.students.index')
    ]
    
]" />
@endsection

@section('content')

<x-alert-success />
<x-alert-errors />
<x-alert-warning />

<div class="card">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table align-middle table-row-dashed table-hover table-row-gray-400 gy-5">
        <thead class="">
         <th>Personal Details</th>
         <th>Academic Info.</th>
         <th>Previous Registration</th>
         <th></th>
        </thead>
        <tbody class="fs-6 fw-semibold text-gray-600">
          @foreach ($students as $student)
              <tr>
                <td class="text-capitalize">
                  <span><b>Full Names: </b> <a href="{{ route('tertiary.students.show', ['id' => $student->id]) }}">{{ $student->first_name.' '.$student->last_name }}</a></span><br />
                  <span><b>Gender: </b>{{ $student->gender }}</span><br />
                  <span><b>Nationality: </b>{{ $student->nationality }}</span><br />
                  <span><b>Nin: </b>{{ $student->nin }}</span><br />
                </td>
                <td class="text-capitalize">
                  <span><b>Reg No: </b>{{ $student->regno }}</span><br />
                  <span><b>Access Number: </b>{{ $student->access_number }}</span><br />
                  <span><b>Course: </b>{{ optional($student->course)->name }}</span><br />
                  <span><b>Set: </b>{{ optional($student->courseGroup)->name }}</span><br />
                </td>

                <td class="text-capitalize">
                  @foreach ($student->intakeRegistrations as $registration)
                    <div class="bg-light p-1">
                      <span>
                        <b>Intake: </b>
                        {{ $registration?->term?->term ? termLabel($registration?->term?->term) : 'No term label' }}
                        {{ $registration?->term?->academicYear?->name }}
                      </span><br />
                      <span><b>Residence: </b>{{ $registration->residence }}</span><br />
                      <span><b>Entry: </b>{{ $registration->new_or_continuing }}</span><br />
                      <span><b>Semester: </b>{{ $registration->semester }}</span><br />
                      <span><b>Year: </b>{{ $registration->year }}</span><br />
                    </div>
                  @endforeach
                </td>
                
                <td>
                  <a
                    class="btn btn-success btn-sm"
                    data-bs-toggle="offcanvas"
                    data-bs-target="{{ '#enrollStudent'.$student->id }}"
                    aria-controls="Id2"
                  >
                    Enroll
                  </a>
                  <a href="" class="btn btn-"></a>
                  
                  <div
                    class="offcanvas offcanvas-start"
                    data-bs-backdrop="static"
                    tabindex="-1"
                    id="{{ 'enrollStudent'.$student->id }}"
                    aria-labelledby="staticBackdropLabel"
                  >
                    <div class="offcanvas-header">
                      <h5 class="offcanvas-title" id="staticBackdropLabel">
                        Enroll Student
                      </h5>
                      <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="offcanvas"
                        aria-label="Close"
                      ></button>
                    </div>
                    <div class="offcanvas-body">
                      <form class=" row" action="{{ route('tertiary.students.enroll', ['student_id' => $student->id]) }}" method="POST">
                        @csrf
                        <div class="col-lg-12">
                          <span class=""><b>Full Names: </b> {{ $student->first_name.' '.$student->last_name }}</span>
                        </div>
                       

                        @php
                            $terms = active_terms();
                        @endphp
                        <div class="col-lg-12">
                            <label for="">Intake</label>
                            <select name="term" id="" class="form-control">
                                @foreach ($terms as $term)
                                  <option value="{{$term->id}}">{{ termLabel($term->term) }}</option>
                                @endforeach
                            </select>
                            <small class="text-danger p-1">{{ $errors->first('term') }}</small>
                        </div>

                         <div class="col-lg-12">
                            <label for="">Semester</label>
                            <select name="semester" id="" class="form-control">
                                <option value="1">Semester 1</option>
                                <option value="2">Semester 2</option>
                            </select>
                        </div>
  
                        <div class="col-lg-12">
                            <label for="">Year</label>
                            <select name="year" id="" class="form-control">
                                <option value="1">Year 1</option>
                                <option value="2">Year 2</option>
                                <option value="3">Year 3</option>
                                <option value="4">Year 4</option>
                                <option value="5">Year 5</option>
                            </select>
                        </div>

                        <div class="col-lg-12">
                            <label class="text-muted text-small">New Or Continuing</label>
                            <select name="new_or_continuing" id="" class="form-control">
                                <option value="new" >New</option>
                                <option value="continuing" selected>Continuing</option>
                            </select>
                            <small class="text-danger text-muted p-1">{{ $errors->first('new_or_continuing') }}</small>
                        </div>


                        <div class="col-lg-12 my-5">
                          <button class="btn btn-dark btn-md w-100">Enroll {{ $student->first_name }}</button>
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

    <div class="card-footer">
      {{ $students->links() }}
    </div>
    
  </div>
</div>
@endsection
