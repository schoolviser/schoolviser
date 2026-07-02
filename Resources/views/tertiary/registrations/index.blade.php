@extends(config('delxero.layouts.dashboard.layout', 'layouts.dashboard.light_header_layout'))

@section('title', 'Intake Registtrations')
@section('module-page-heading', 'Intake Registtrations')

@section('hello')
    @php
        $term = term();
    @endphp
    {{ $term->academicYear?->name.' '.$term->name }}
@endsection

@section('module-page-actions')
<a href="{{route('tertiary.students.create')}}" class="btn btn-sm btn-light">Add Student</a>
<a href="{{route('tertiary.intake.registrations.index')}}" class="btn btn-sm btn-light">Registrations</a>
<a href="{{route('tertiary.students.unregistered')}}" class="btn btn-sm btn-light">Un Registered Students</a>
<a href="#" class="btn btn-sm btn-light" data-bs-toggle="offcanvas" data-bs-target="#searchStudentsOffcanvas" aria-controls="searchStudentsOffcanvas">
    <i class="bi bi-search"></i> Search Students
</a>
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
    ]
    
]" />
@endsection

@section('requiredJs')
<script src="{{ asset('modules/schoolviser/js/tertiary_students.js') }}" defer></script>
@endsection

@section('content')

<div class="row">

    @if (count($registrations))

        <div class="col-xl-12">
            <div class="card">

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle table-row-dashed table-row-gray-400 fs-6 gy-5" id="studentsTables">
                            <thead>
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th>
                                    <input type="checkbox" class="form-check-input" id="selectAllStudents" />
                                </th>
                                <th>*</th>
                                <th>Personal Information</th>
                                <th>Acdemic Information</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($registrations as $registration)
                                    <tr class="">
                                        <td>
                                            <input type="checkbox" class="student-checkbox form-check-input" value="{{ $registration->student->id }}">
                                        </td>
                                        <td style="width: 5%;" class="py-lg-3">
                                            <img src="{{ $registration->student->photo ? asset('storage/'.$registration->student->photo) : asset('media/avatars/blank.png') }}" class="img-fluid" alt="">
                                        </td>

                                        <td class="text-capitalize">
                                            <span>
                                                <b>Full Names: </b>
                                                <a href="{{ route('tertiary.students.show', ['id' => $registration->student->uuid ?? $registration->student->id]) }}" style="text-decoration: none;" class="pl-5"><span >{{ $registration->student->first_name.' '.$registration->student->last_name }}</span></a>
                                            </span><br />
                                            <span><b>Gender: </b>{{ $registration->student->gender }}</span><br />
                                            <span><b>Nationality: </b>{{ $registration->student->nationality }}</span><br />
                                            <span><b>Nin: </b>{{ $registration->student->nin }}</span><br />
                                        </td>

                                        <td class="text-capitalize">
                                            <span><b>Reg No: </b>{{ $registration->student->regno }}</span><br />
                                            <span><b>Access No: </b>{{ $registration->student->access_number }}</span><br />
                                            <span><b>Course: </b>{{ optional($registration->student->course)->name }}</span><br />
                                            <span><b>Set: </b>{{ optional($registration->student->courseGroup)->name }}</span><br />
                                            <span><b>Year: </b>{{  $registration->year }}</span>
                                            <span><b>Semester: </b>{{  $registration->semester }}</span><br />
                                            <span><b>residence: </b>{{  $registration->residence }}</span><br />
                                            <span><b>Entry: </b>{{  $registration->new_or_continuing }}</span><br />
                                        </td>

                                        <td>
                                            <a href=""><i class="bi bi-trash"></i> Delete</a>
                                            <a href=""><i class="bi bi-pencil"></i> Edit</a>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {{ $registrations->links() }}
                </div>
            </div>
        </div>

    @else
    <div class="text-center p-5">
    <a href=""><img src="{{asset('icons/addnewitem.svg')}}" class="w-10" style="width: 15%;" alt=""></a>
    </div>
    @endif

</div>

@include('schoolviser::tertiary.students.partials.offcanvas._search_students_offcanvas')

@endsection

