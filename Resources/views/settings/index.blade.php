@extends(config('delxero.layouts.dashboard.layout', 'layouts.dashboard.light_header_layout'))

@section('title', 'Settings')
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
                
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle table-row-dashed fs-6 gy-5" id="studentsTables">
                <thead>
                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                    <th>Group</th>
                    <th>Settings</th>
                    <th>Related Settings</th>
                </tr>
                </thead>
                <tbody>
                    @hasRoleInCompany('Master')
                    <tr class="">
                        <td class="">
                            Manage Users
                        </td>

                        <td class="text-capitalize">
                            <a href="{{route('manageusers.index')}}">See Users</a><br />
                            <a href="{{route('manageusers.roles.index')}}">Roles & Permissions</a><br />
                            <a href="{{route('manageusers.audit.trail')}}">Audit Trail</a><br />
                        </td>

                        </td>
                    </tr>
                    @endhasRoleInCompany

                    <tr class="">
                        <td class="">
                            Academic Years & Terms
                        </td>

                        <td class="text-capitalize">
                            <a href="{{route('manageacademicyears.index')}}">Manage Academic Years</a><br />
                            <a href="{{route('manageterms.index')}}">Manage Terms</a><br />
                        </td>

                        </td>
                    </tr>

                    <!-- Manage Courses or classes -->
                    @tertiary
                        <tr class="">
                            <td class="">
                                Manage Courses
                            </td>

                            <td class="text-capitalize">
                                <a href="{{route('managecourses.index')}}">Browse Courses</a><br />
                            </td>

                            <td class="text-capitalize">
                                <a href="{{route('managecourses.cohorts.index')}}">Sets / Cohorts</a><br />
                            </td>

                            </td>
                        </tr>
                        <tr class="">
                            <td class="">
                                Mikrotik Network Settings
                            </td>

                            <td class="text-capitalize">
                                <a href="{{route('mkt.index')}}">hello</a><br />
                            </td>

                            <td class="text-capitalize">
                                <a href="{{route('managecourses.cohorts.index')}}">Sets / Cohorts</a><br />
                            </td>

                            </td>
                        </tr>
                    @endtertiary

                    @secondary
                    <tr class="">
                        <td class="">
                            Manage Classes
                        </td>

                        <td class="text-capitalize">
                            <a href="{{route('manageclazzs.index')}}">Browse Classes</a><br />
                        </td>

                    </tr>
                    @endsecondary

                    <!-- Translations -->
                    <tr class="">
                        <td class="">
                            Translations
                        </td>

                        <td class="text-capitalize">
                            <a href="{{route('term.translations.index', ['locale' => 'en'])}}">Term/Intake Translations</a><br />
                        </td>

                        <td class="text-capitalize">
                            <a href="{{route('term.translations.index', ['locale' => 'en'])}}">Term/Intake Translations</a><br />
                        </td>

                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
    </div>
</div>
@endsection
