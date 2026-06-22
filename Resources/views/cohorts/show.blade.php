@extends(config('delxero.dashboard_layout', 'schoolviser::layouts.main_layout'))

@section('module-page-heading', 'Cohort Details')

@section('hello')
    @php
        $term = term();
    @endphp
    {{ $term->academicYear?->name.' '.$term->name }}
@endsection

@section('module-page-actions')
    <a href="{{ route('managecourses.cohorts.index') }}" class="btn btn-sm btn-light">Back to Cohorts</a>
    <a href="{{ route('managecourses.cohorts.edit', $cohort->id) }}" class="btn btn-sm btn-warning">Edit Cohort</a>
@endsection

@section('module-breadcrumbs')
<x-ui.breadcrumb :items="[
    [
        'label' => 'Settings',
        'url' => route('settings.index')
    ],
    [
        'label' => 'Cohorts',
        'url' => route('managecourses.cohorts.index')
    ],
    [
        'label' => $cohort->name,
        'url' => route('managecourses.cohorts.show', $cohort->id)
    ]
]" />
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="mb-4">Cohort Information</h5>
        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <td>{{ $cohort->id }}</td>
            </tr>
            <tr>
                <th>Name</th>
                <td>{{ $cohort->name }}</td>
            </tr>
            <tr>
                <th>Short Code</th>
                <td>{{ $cohort->short_code }}</td>
            </tr>
            <tr>
                <th>Description</th>
                <td>{{ $cohort->description }}</td>
            </tr>
            <tr>
                <th>Course</th>
                <td>{{ $cohort->course?->name }}</td>
            </tr>
            <tr>
                <th>Academic Year</th>
                <td>{{ $cohort->academicYear?->name }}</td>
            </tr>
            <tr>
                <th>Starts On</th>
                <td>{{ $cohort->starts_on }}</td>
            </tr>
            <tr>
                <th>Ends On</th>
                <td>{{ $cohort->ends_on }}</td>
            </tr>
            <tr>
                <th>Active</th>
                <td>{{ $cohort->active ? 'Yes' : 'No' }}</td>
            </tr>
        </table>

        <h5 class="mt-5 mb-3">Students in this Cohort</h5>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Assigned On</th>
                        <th>Removed On</th>
                        <th>Reason</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cohort->students as $student)
                        <tr>
                            <td>{{ $student->id }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->pivot->assigned_on }}</td>
                            <td>{{ $student->pivot->removed_on ?? '-' }}</td>
                            <td>{{ $student->pivot->reason ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No students assigned to this cohort.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection