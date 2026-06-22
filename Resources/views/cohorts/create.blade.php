@extends(config('delxero.dashboard_layout', 'schoolviser::layouts.main_layout'))

@section('module-page-heading', 'Add Cohort')

@section('hello')
    @php
        $term = term();
    @endphp
    {{ $term->academicYear?->name.' '.$term->name }}
@endsection

@section('module-page-actions')
    <a href="{{ route('managecourses.cohorts.index') }}" class="btn btn-sm btn-light">Back to Cohorts</a>
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
        'label' => 'Add Cohort',
        'url' => route('managecourses.cohorts.create')
    ]
]" />
@endsection

@section('content')

<x-alert-success />
<x-alert-errors />


<div class="card">
    <div class="card-body">
        <form action="{{ route('managecourses.cohorts.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Cohort Name</label>
                <input type="text" name="name" id="name" class="form-control" required value="{{ old('name') }}">
                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label for="short_code" class="form-label">Short Code</label>
                <input type="text" name="short_code" id="short_code" class="form-control" value="{{ old('short_code') }}">
                @error('short_code') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                @error('description') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label for="course_id" class="form-label">Course</label>
                <select name="course_id" id="course_id" class="form-select">
                    <option value="">-- Select Course --</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" @selected(old('course_id') == $course->id)>
                            {{ $course->name }}
                        </option>
                    @endforeach
                </select>
                @error('course_id') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label for="academic_year_id" class="form-label">Academic Year</label>
                <select name="academic_year_id" id="academic_year_id" class="form-select">
                    <option value="">-- Select Academic Year --</option>
                    @foreach($academicYears as $year)
                        <option value="{{ $year->id }}" @selected(old('academic_year_id') == $year->id)>
                            {{ $year->name }}
                        </option>
                    @endforeach
                </select>
                @error('academic_year_id') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label for="starts_on" class="form-label">Starts On</label>
                <input type="date" name="starts_on" id="starts_on" class="form-control" value="{{ old('starts_on') }}">
                @error('starts_on') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label for="ends_on" class="form-label">Ends On</label>
                <input type="date" name="ends_on" id="ends_on" class="form-control" value="{{ old('ends_on') }}">
                @error('ends_on') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="active" id="active" class="form-check-input" value="1" @checked(old('active', true))>
                <label for="active" class="form-check-label">Active</label>
            </div>

            <button type="submit" class="btn btn-primary">Save Cohort</button>
        </form>
    </div>
</div>
@endsection