@extends(config('delxero.layouts.dashboard.layout', 'layouts.dashboard.light_header_layout'))

@section('title', 'Students Information')
@section('module-page-heading', 'Students Information')

@section('hello')
    @php
        $term = term();
    @endphp
    {{ $term->academicYear?->name.' '.$term->name }}
@endsection

@section('module-page-actions')
<a href="{{route('tertiary.students.create')}}" class="btn btn-sm btn-light">Add Student</a>
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

    @if (count($students))

        <div class="col-xl-12">
            <div class="card">
                
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle table-row-dashed table-row-gray-400 fs-6 gy-5" id="studentsTables">
                            <thead>
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th></th>
                                <th>Personal Information</th>
                                <th>Acdemic Information</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($students as $student)
                            <tr class="">
                                <td style="width: 5%;" class="py-lg-3">
                                    <img src="{{ asset($student->photo ?? 'images/avator.png') }}" class="img-fluid" alt="">
                                </td>

                                <td class="text-capitalize">
                                    <span>
                                        <b>Full Names: </b>
                                        <a href="{{ route('tertiary.students.show', ['id' => $student->uuid ?? $student->id]) }}" style="text-decoration: none;" class="pl-5"><span >{{ $student->first_name.' '.$student->last_name }}</span></a>
                                    </span><br />
                                    <span><b>Gender: </b>{{ $student->gender }}</span><br />
                                    <span><b>Nationality: </b>{{ $student->nationality }}</span><br />
                                    <span><b>Nin: </b>{{ $student->nin }}</span><br />
                                </td>

                                <td class="text-capitalize">
                                    <span><b>Reg No: </b>{{ $student->regno }}</span><br />
                                    <span><b>Access No: </b>{{ $student->access_number }}</span><br />
                                    <span><b>Course: </b>{{ optional($student->course)->name }}</span><br />
                                    <span><b>Set: </b>{{ optional($student->courseGroup)->name }}</span><br />
                                    <span><b>Year: </b>{{  $student->registration->year }}</span>
                                    <span><b>Semester: </b>{{  $student->registration->semester }}</span><br />
                                    <span><b>residence: </b>{{  $student->registration->residence }}</span><br />
                                    <span><b>Entry: </b>{{  $student->registration->new_or_continuing }}</span><br />
                                </td>

                                <td class="text-center">
                                <a href="{{ route('tertiary.students.show', ['id' => $student->uuid ?? $student->id]) }}" class="btn btn-sm btn-primary dev"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('tertiary.students.delete', ['id' => $student->registration->id]) }}" class="btn btn-sm btn-danger" "><i class="bi bi-trash"></i></a>

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
