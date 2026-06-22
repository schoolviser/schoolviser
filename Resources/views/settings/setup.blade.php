@extends(config('delxero.dashboard_layout', 'schoolviser::layouts.main_layout'))

@section('module-page-heading', 'Settings')

@section('hello')
    @php
        $term = term();
    @endphp
    {{ $term?->academicYear?->name.' '.$term?->name }}
@endsection

@section('module-page-actions')
@endsection

@section('module-breadcrumbs')
<x-ui.breadcrumb :items="[
    [
        'label' => 'Settings',
        'url' => route('settings.index')
    ],
    [
        'label' => 'Schoolviser Setup',
        'url' => route('settings.index')
    ]
    
]" />
@endsection


@section('content')

<x-alert-success />

<form action="{{route('schoolviser.setup')}}" method="POST">
    @csrf
    <div class="table-responsive">
        <table class="table table-hover align-middle table-row-dashed table-row-gray-400 fs-6 gy-5">
            <thead>
                <th>Description</th>
                <th>Setting</th>
            </thead>
            <tbody>
                <tr>
                    <td>School Type</td>
                    <td>
                        <select name="school_type" id="" class="form-control">
                            @foreach (['tertiary', 'primary', 'secondary'] as $item)
                                <option value="{{ $item }}" {{ ($item == $school_type) ? 'selected' : '' }}>{{$item}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr aria-colspan="2">
                    <button type="submit">Save</button>
                </tr>
            </tbody>
        </table>
    </div>
</form>
@endsection
