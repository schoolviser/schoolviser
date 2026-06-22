@extends(config('delxero.dashboard_layout', 'schoolviser::layouts.main_layout'))

@section('module-page-heading', 'Settings')

@section('hello')
    @php
        $term = term();
    @endphp
    {{ $term?->academicYear?->name.' '.$term?->name }}
@endsection

@section('module-page-actions')
<a href="{{route('schoolviser.setup')}}" class="btn btn-sm btn-light">Schoolviser Setup</a>
@endsection

@section('module-breadcrumbs')
<x-ui.breadcrumb :items="[
    [
        'label' => 'Settings',
        'url' => route('settings.index')
    ]
    
]" />
@endsection


@section('content')
<div class="card">
                
    <div class="card-body row">
        
        <form class="col-lg-4" action="{{route('mkt.set')}}" method="POST">
            @csrf
            <div class="col-lg-12 mb-3">
                <label for="">Students User Profile</label>
                <select name="students_user_profile" id="" class="form-control">
                    <option value="">Choose Profile</option>
                    @foreach ($user_profiles as $userProfile)
                        <option value="{{ $userProfile->name }}" {{ ($settings->students_user_profile == $userProfile->name) ? 'selected' : '' }}>{{ $userProfile->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-lg-12">
                <button type="submit">Update</button>
            </div>
        </form>

    </div>
    <div class="card-footer">
    </div>
</div>
@endsection
