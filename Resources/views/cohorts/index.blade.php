@extends(config('delxero.dashboard_layout', 'schoolviser::layouts.main_layout'))

@section('module-page-heading', 'Cohorts')

@section('hello')
    @php
        $term = term();
    @endphp
    {{ $term->academicYear?->name.' '.$term->name }}
@endsection

@section('module-page-actions')
    <a href="{{ route('managecourses.cohorts.create') }}" class="btn btn-sm btn-light">Add Cohort</a>
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
    ]
]" />
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle table-row-dashed fs-6 gy-5" id="cohortsTable">
                <thead>
                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                        <th>ID</th>
                        <th>Name</th>
                        <th>Short Code</th>
                        <th>Course</th>
                        <th>Academic Year</th>
                        <th>Starts On</th>
                        <th>Ends On</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cohorts as $cohort)
                        <tr>
                            <td>{{ $cohort->id }}</td>
                            <td class="text-capitalize">{{ $cohort->name }}</td>
                            <td>{{ $cohort->short_code }}</td>
                            <td>{{ $cohort->course?->name }}</td>
                            <td>{{ $cohort->academicYear?->name }}</td>
                            <td>{{ $cohort->starts_on }}</td>
                            <td>{{ $cohort->ends_on }}</td>
                            <td>
                                <a href="{{ route('managecourses.cohorts.show', $cohort->id) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('managecourses.cohorts.edit', $cohort->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <a href="{{ route('managecourses.cohorts.destroy', $cohort->id) }}" class="btn btn-sm btn-danger"
                                   onclick="return confirm('Are you sure you want to delete this cohort?')">Delete</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">No cohorts found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        {{ $cohorts->links() }} <!-- pagination -->
    </div>
</div>
@endsection