@extends(config('delxero.layouts.dashboard.layout', 'layouts.dashboard.light_header_layout'))

@section('title', 'Students Overview')

@section('module-page-heading', 'Students Overview')
@section('pageheaderDescription', 'Manage Students')

@section('module-page-actions')
<a href="{{route('tertiary.students.create')}}" class="btn btn-sm btn-light">Add Student</a>
<a href="{{route('tertiary.students.unregistered')}}" class="btn btn-sm btn-light">Un Registered Students</a>
<a href="{{route('tertiary.students.export')}}" class="btn btn-sm btn-light">Export Students</a>
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
        'label' => 'Students Overview Page',
        'url' => route('tertiary.students.overview')
    ]
    
]" />
@endsection

@section('requiredJs')
<script src="{{ asset('modules/schoolviser/js/tertiary_students.js') }}" defer></script>
@endsection

@section('content')
<div class="row gy-5 gx-xl-10">

    <!--begin::Col-->
    <div class="col-xxl-6">
        <!--begin::Row-->
        <div class="row gx-5 gx-xl-10">
            <!--begin::Col-->

            <div class="col-sm-6 mb-5 mb-xl-10">
                @include('schoolviser::tertiary.students.includes._students_gender_stat_card')
            </div>

            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-sm-6 mb-5 mb-xl-10">
                <!--begin::List widget 2-->
                <div class="card card-flush h-lg-100">
                    <!--begin::Header-->
                    <div class="card-header pt-5">
                        <!--begin::Title-->
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-gray-900">Academic Year {{ $academicYear->name }}</span>
                            <span class="text-gray-500 mt-1 fw-semibold fs-6">Total Students Per Intake</span>
                        </h3>
                        <!--end::Title-->
                        <!--begin::Toolbar-->
                        <div class="card-toolbar">
                            <!--begin::Menu-->
                            <button class="btn btn-icon btn-color-gray-500 btn-active-color-primary justify-content-end" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">
                                <i class="bi bi-three-dots fs-1">
                                </i>
                            </button>
                            <!--begin::Menu 3-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">
                                <!--begin::Heading-->
                                <div class="menu-item px-3">
                                    <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">Payments</div>
                                </div>
                                <!--end::Heading-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3">Create Invoice</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link flex-stack px-3">Create Payment 
                                    <span class="ms-2" data-bs-toggle="tooltip" title="Specify a target name for future usage and reference">
                                        <i class="ki-duotone ki-information fs-6">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </span></a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3">Generate Bill</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-end">
                                    <a href="#" class="menu-link px-3">
                                        <span class="menu-title">Subscription</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <!--begin::Menu sub-->
                                    <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">Plans</a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">Billing</a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">Statements</a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu separator-->
                                        <div class="separator my-2"></div>
                                        <!--end::Menu separator-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <div class="menu-content px-3">
                                                <!--begin::Switch-->
                                                <label class="form-check form-switch form-check-custom form-check-solid">
                                                    <!--begin::Input-->
                                                    <input class="form-check-input w-30px h-20px" type="checkbox" value="1" checked="checked" name="notifications" />
                                                    <!--end::Input-->
                                                    <!--end::Label-->
                                                    <span class="form-check-label text-muted fs-6">Recuring</span>
                                                    <!--end::Label-->
                                                </label>
                                                <!--end::Switch-->
                                            </div>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu sub-->
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3 my-1">
                                    <a href="#" class="menu-link px-3">Settings</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu 3-->
                            <!--end::Menu-->
                        </div>
                        <!--end::Toolbar-->
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body pt-5">
                        @foreach ($totalRegistrationsPerIntake as $term)
                            <!--begin::Item-->
                            <div class="d-flex flex-stack">
                                <!--begin::Title-->
                                <a href="{{ route('tertiary.students.intake', $term->uuid) }}" class="text-primary opacity-75-hover fs-6 fw-semibold">{{ termLabel($term->term) }}</a>
                                <!--end::Title-->
                                <!--begin::Action-->
                                <button type="button" class="btn btn-icon btn-sm h-auto btn-color-gray-500 btn-active-color-primary justify-content-end">
                                    {{ $term->intake_registrations_count }}
                                </button>
                                <!--end::Action-->
                            </div>
                        
                            <div class="separator separator-dashed my-3"></div>
                        @endforeach
                        
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::List widget 2-->
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->
        <!--begin::Table widget 1-->

        <!-- Students Per Course -->
        <div class="card card-flush mb-xxl-10">
            <div class="card-header pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-900">Students In Each Course</span>
                </h3>
                <div class="card-toolbar">
                    <button class="btn btn-icon btn-color-gray-500 btn-active-color-primary justify-content-end" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">
                        <i class="bi bi-three-dots fs-1 text-gray-500 me-n1">
                        </i>
                    </button>

                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px" data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <div class="menu-content fs-6 text-gray-900 fw-bold px-3 py-4">Related Stat</div>
                        </div>
                        <!--end::Menu item-->
                        <div class="separator mb-3 opacity-20"></div>

                        <!-- Existing items -->
                        <div class="menu-item px-3">
                            <a href="{{ route('analytics.tertiary.course-enrollment-trend', $academicYear->uuid) }}" class="menu-link px-3 dev">Course Enrollment Trends</a>
                        </div>

                        <div class="separator mt-3 opacity-75"></div>

                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3 dev">Alumni Employment Outcomes</a>
                        </div>

                        <div class="separator mt-3 opacity-75"></div>

                        <!-- Existing Generate Reports button -->
                        <div class="menu-item px-3">
                            <div class="menu-content px-3 py-3">
                                <a class="btn btn-primary btn-sm px-4 dev" href="#">Go to Reports</a>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle gs-0 gy-4 my-0">
                        <thead>
                            <tr class="fs-7 fw-bold text-gray-500">
                                <th class="p-0 min-w-150px d-block pt-3">Course</th>
                                <th class="text-end min-w-140px pt-3">Number Of Students</th>
                                <th class="pe-0 text-end min-w-120px pt-3"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($studentsPerCourse as $studentPerCourse)
                                <tr>
                                    <td>
                                        <a href="#" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">{{ $studentPerCourse->name }}</a>
                                    </td>
                                    <td class="text-end">
                                        <span class="badge badge-light-warning fs-7 fw-bold">{{ $studentPerCourse->students_count }}</span>
                                    </td>
                                    <td class="text-end">
                                        <span class="text-gray-800 fw-bold d-block fs-6"></span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!--end: Card Body-->
        </div>
        <!--end::Table widget 1-->
    </div>

    <!--end::Col-->
    <!--begin::Col-->
    <div class="col-xxl-6 mb-5 mb-xl-10">
        <!--begin::Chart widget 8-->
        <div class="card card-flush h-xl-100">
            <!--begin::Header-->
            <div class="card-header pt-5">
                <!--begin::Title-->
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-900">Performance Overview</span>
                    <span class="text-gray-500 mt-1 fw-semibold fs-6">Users from all channels</span>
                </h3>
                <!--end::Title-->
                <!--begin::Toolbar-->
                <div class="card-toolbar">
                    <ul class="nav" id="kt_chart_widget_8_tabs">
                        <li class="nav-item">
                            <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light fw-bold px-4 me-1" data-bs-toggle="tab" id="kt_chart_widget_8_week_toggle" href="#kt_chart_widget_8_week_tab">Month</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light fw-bold px-4 me-1 active" data-bs-toggle="tab" id="kt_chart_widget_8_month_toggle" href="#kt_chart_widget_8_month_tab">Week</a>
                        </li>
                    </ul>
                </div>
                <!--end::Toolbar-->
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body pt-6">
                <!--begin::Tab content-->
                <div class="tab-content">
                    <!--begin::Tab pane-->
                    <div class="tab-pane fade" id="kt_chart_widget_8_week_tab" role="tabpanel">
                        <!--begin::Statistics-->
                        <div class="mb-5">
                            <!--begin::Statistics-->
                            <div class="d-flex align-items-center mb-2">
                                <span class="fs-1 fw-semibold text-gray-500 me-1 mt-n1">$</span>
                                <span class="fs-3x fw-bold text-gray-800 me-2 lh-1 ls-n2">18,89</span>
                                <span class="badge badge-light-success fs-base">
                                <i class="ki-duotone ki-arrow-up fs-5 text-success ms-n1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>4,8%</span>
                            </div>
                            <!--end::Statistics-->
                            <!--begin::Description-->
                            <span class="fs-6 fw-semibold text-gray-500">Avarage cost per interaction</span>
                            <!--end::Description-->
                        </div>
                        <!--end::Statistics-->
                        <!--begin::Chart-->
                        <div id="kt_chart_widget_8_week_chart" class="ms-n5 min-h-auto" style="height: 425px"></div>
                        <!--end::Chart-->
                        <!--begin::Items-->
                        <div class="d-flex flex-wrap pt-5">
                            <!--begin::Item-->
                            <div class="d-flex flex-column me-7 me-lg-16 pt-sm-3 pt-6">
                                <!--begin::Item-->
                                <div class="d-flex align-items-center mb-3 mb-sm-6">
                                    <!--begin::Bullet-->
                                    <span class="bullet bullet-dot bg-primary me-2 h-10px w-10px"></span>
                                    <!--end::Bullet-->
                                    <!--begin::Label-->
                                    <span class="fw-bold text-gray-600 fs-6">Social Campaigns</span>
                                    <!--end::Label-->
                                </div>
                                <!--ed::Item-->
                                <!--begin::Item-->
                                <div class="d-flex align-items-center">
                                    <!--begin::Bullet-->
                                    <span class="bullet bullet-dot bg-danger me-2 h-10px w-10px"></span>
                                    <!--end::Bullet-->
                                    <!--begin::Label-->
                                    <span class="fw-bold text-&lt;gray-600 fs-6">Google Ads</span>
                                    <!--end::Label-->
                                </div>
                                <!--ed::Item-->
                            </div>
                            <!--ed::Item-->
                            <!--begin::Item-->
                            <div class="d-flex flex-column me-7 me-lg-16 pt-sm-3 pt-6">
                                <!--begin::Item-->
                                <div class="d-flex align-items-center mb-3 mb-sm-6">
                                    <!--begin::Bullet-->
                                    <span class="bullet bullet-dot bg-success me-2 h-10px w-10px"></span>
                                    <!--end::Bullet-->
                                    <!--begin::Label-->
                                    <span class="fw-bold text-gray-600 fs-6">Email Newsletter</span>
                                    <!--end::Label-->
                                </div>
                                <!--ed::Item-->
                                <!--begin::Item-->
                                <div class="d-flex align-items-center">
                                    <!--begin::Bullet-->
                                    <span class="bullet bullet-dot bg-warning me-2 h-10px w-10px"></span>
                                    <!--end::Bullet-->
                                    <!--begin::Label-->
                                    <span class="fw-bold text-gray-600 fs-6">Courses</span>
                                    <!--end::Label-->
                                </div>
                                <!--ed::Item-->
                            </div>
                            <!--ed::Item-->
                            <!--begin::Item-->
                            <div class="d-flex flex-column pt-sm-3 pt-6">
                                <!--begin::Item-->
                                <div class="d-flex align-items-center mb-3 mb-sm-6">
                                    <!--begin::Bullet-->
                                    <span class="bullet bullet-dot bg-info me-2 h-10px w-10px"></span>
                                    <!--end::Bullet-->
                                    <!--begin::Label-->
                                    <span class="fw-bold text-gray-600 fs-6">TV Campaign</span>
                                    <!--end::Label-->
                                </div>
                                <!--ed::Item-->
                                <!--begin::Item-->
                                <div class="d-flex align-items-center">
                                    <!--begin::Bullet-->
                                    <span class="bullet bullet-dot bg-success me-2 h-10px w-10px"></span>
                                    <!--end::Bullet-->
                                    <!--begin::Label-->
                                    <span class="fw-bold text-gray-600 fs-6">Radio</span>
                                    <!--end::Label-->
                                </div>
                                <!--ed::Item-->
                            </div>
                            <!--ed::Item-->
                        </div>
                        <!--ed::Items-->
                    </div>
                    <!--end::Tab pane-->
                    <!--begin::Tab pane-->
                    <div class="tab-pane fade active show" id="kt_chart_widget_8_month_tab" role="tabpanel">
                        <!--begin::Statistics-->
                        <div class="mb-5">
                            <!--begin::Statistics-->
                            <div class="d-flex align-items-center mb-2">
                                <span class="fs-1 fw-semibold text-gray-500 me-1 mt-n1">$</span>
                                <span class="fs-3x fw-bold text-gray-800 me-2 lh-1 ls-n2">8,55</span>
                                <span class="badge badge-light-success fs-base">
                                <i class="ki-duotone ki-arrow-up fs-5 text-success ms-n1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>2.2%</span>
                            </div>
                            <!--end::Statistics-->
                            <!--begin::Description-->
                            <span class="fs-6 fw-semibold text-gray-500">Avarage cost per interaction</span>
                            <!--end::Description-->
                        </div>
                        <!--end::Statistics-->
                        <!--begin::Chart-->
                        <div id="kt_chart_widget_8_month_chart" class="ms-n5 min-h-auto" style="height: 425px"></div>
                        <!--end::Chart-->
                        <!--begin::Items-->
                        <div class="d-flex flex-wrap pt-5">
                            <!--begin::Item-->
                            <div class="d-flex flex-column me-7 me-lg-16 pt-sm-3 pt-6">
                                <!--begin::Item-->
                                <div class="d-flex align-items-center mb-3 mb-sm-6">
                                    <!--begin::Bullet-->
                                    <span class="bullet bullet-dot bg-primary me-2 h-10px w-10px"></span>
                                    <!--end::Bullet-->
                                    <!--begin::Label-->
                                    <span class="fw-bold text-gray-600 fs-6">Social Campaigns</span>
                                    <!--end::Label-->
                                </div>
                                <!--ed::Item-->
                                <!--begin::Item-->
                                <div class="d-flex align-items-center">
                                    <!--begin::Bullet-->
                                    <span class="bullet bullet-dot bg-danger me-2 h-10px w-10px"></span>
                                    <!--end::Bullet-->
                                    <!--begin::Label-->
                                    <span class="fw-bold text-gray-600 fs-6">Google Ads</span>
                                    <!--end::Label-->
                                </div>
                                <!--ed::Item-->
                            </div>
                            <!--ed::Item-->
                            <!--begin::Item-->
                            <div class="d-flex flex-column me-7 me-lg-16 pt-sm-3 pt-6">
                                <!--begin::Item-->
                                <div class="d-flex align-items-center mb-3 mb-sm-6">
                                    <!--begin::Bullet-->
                                    <span class="bullet bullet-dot bg-success me-2 h-10px w-10px"></span>
                                    <!--end::Bullet-->
                                    <!--begin::Label-->
                                    <span class="fw-bold text-gray-600 fs-6">Email Newsletter</span>
                                    <!--end::Label-->
                                </div>
                                <!--ed::Item-->
                                <!--begin::Item-->
                                <div class="d-flex align-items-center">
                                    <!--begin::Bullet-->
                                    <span class="bullet bullet-dot bg-warning me-2 h-10px w-10px"></span>
                                    <!--end::Bullet-->
                                    <!--begin::Label-->
                                    <span class="fw-bold text-gray-600 fs-6">Courses</span>
                                    <!--end::Label-->
                                </div>
                                <!--ed::Item-->
                            </div>
                            <!--ed::Item-->
                            <!--begin::Item-->
                            <div class="d-flex flex-column pt-sm-3 pt-6">
                                <!--begin::Item-->
                                <div class="d-flex align-items-center mb-3 mb-sm-6">
                                    <!--begin::Bullet-->
                                    <span class="bullet bullet-dot bg-info me-2 h-10px w-10px"></span>
                                    <!--end::Bullet-->
                                    <!--begin::Label-->
                                    <span class="fw-bold text-gray-600 fs-6">TV Campaign</span>
                                    <!--end::Label-->
                                </div>
                                <!--ed::Item-->
                                <!--begin::Item-->
                                <div class="d-flex align-items-center">
                                    <!--begin::Bullet-->
                                    <span class="bullet bullet-dot bg-success me-2 h-10px w-10px"></span>
                                    <!--end::Bullet-->
                                    <!--begin::Label-->
                                    <span class="fw-bold text-gray-600 fs-6">Radio</span>
                                    <!--end::Label-->
                                </div>
                                <!--ed::Item-->
                            </div>
                            <!--ed::Item-->
                        </div>
                        <!--ed::Items-->
                    </div>
                    <!--end::Tab pane-->
                </div>
                <!--end::Tab content-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Chart widget 8-->
    </div>
    <!--end::Col-->
</div>

<div
    class="offcanvas offcanvas-start"
    data-bs-scroll="true"
    tabindex="-1"
    id="Id1"
    aria-labelledby="Enable both scrolling & backdrop"
>
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="Enable both scrolling & backdrop">
            Backdrop with scrolling
        </h5>
        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="offcanvas"
            aria-label="Close"
        ></button>
    </div>
    <div class="offcanvas-body">
        <p>
            Try scrolling the rest of the page to see this option in
            action.
        </p>
    </div>
</div>

@include('schoolviser::tertiary.students.partials.offcanvas._search_students_offcanvas')

@endsection

