<div class="card card-flush h-lg-100">

    <div class="card-header pt-5">

        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold text-gray-900">Students Stat</span>
            <span class="text-gray-500 mt-1 fw-semibold fs-6">Latest students statistics</span>
        </h3>

        <div class="card-toolbar">
            <!--begin::Menu-->
            <button class="btn btn-icon btn-color-gray-500 btn-active-color-primary justify-content-end" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">
                <i class="ki-duotone ki-dots-square fs-1">
                </i>
            </button>
            <!--begin::Menu 2-->
            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px" data-kt-menu="true">
                <!--begin::Menu item-->
                <div class="menu-item px-3">
                    <div class="menu-content fs-6 text-gray-900 fw-bold px-3 py-4">Quick Actions</div>
                </div>
                <!--end::Menu item-->
                <!--begin::Menu separator-->
                <div class="separator mb-3 opacity-75"></div>
                <!--end::Menu separator-->
                <!--begin::Menu item-->
                <div class="menu-item px-3">
                    <a href="#" class="menu-link px-3">New Ticket</a>
                </div>
                <!--end::Menu item-->
                <!--begin::Menu item-->
                <div class="menu-item px-3">
                    <a href="#" class="menu-link px-3">New Customer</a>
                </div>
                <!--end::Menu item-->
                <!--begin::Menu item-->
                <div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-start">
                    <!--begin::Menu item-->
                    <a href="#" class="menu-link px-3">
                        <span class="menu-title">New Group</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <!--end::Menu item-->
                    <!--begin::Menu sub-->
                    <div class="menu-sub menu-sub-dropdown w-175px py-4">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3">Admin Group</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3">Staff Group</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3">Member Group</a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::Menu sub-->
                </div>
                <!--end::Menu item-->
                <!--begin::Menu item-->
                <div class="menu-item px-3">
                    <a href="#" class="menu-link px-3">New Contact</a>
                </div>
                <!--end::Menu item-->
                <!--begin::Menu separator-->
                <div class="separator mt-3 opacity-75"></div>
                <!--end::Menu separator-->
                <!--begin::Menu item-->
                <div class="menu-item px-3">
                    <div class="menu-content px-3 py-3">
                        <a class="btn btn-primary btn-sm px-4" href="#">Generate Reports</a>
                    </div>
                </div>
                <!--end::Menu item-->
            </div>
            <!--end::Menu 2-->
            <!--end::Menu-->
        </div>

    </div>

    <div class="card-body pt-5">

        <div class="d-flex flex-stack">
            <div class="text-gray-700 fw-semibold fs-6 me-2">Male</div>
            <div class="d-flex align-items-senter">
                <i class="ki-duotone ki-arrow-up-right fs-2 text-success me-2">
                </i>
                <span class="text-gray-900 fw-bolder fs-6">{{ $studentsGenderCounts->total_male }}</span>
            </div>
        </div>

        <!--end::Item-->
        <!--begin::Separator-->
        <div class="separator separator-dashed my-3"></div>
        <!--end::Separator-->
        <!--begin::Item-->
        <div class="d-flex flex-stack">
            <!--begin::Section-->
            <div class="text-gray-700 fw-semibold fs-6 me-2">Female</div>
            <!--end::Section-->
            <!--begin::Statistics-->
            <div class="d-flex align-items-senter">
                <i class="ki-duotone ki-arrow-down-right fs-2 text-danger me-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
                <!--begin::Number-->
                <span class="text-gray-900 fw-bolder fs-6">{{ $studentsGenderCounts->total_female }}</span>
                <!--end::Number-->
            </div>
            <!--end::Statistics-->
        </div>
        <!--end::Item-->
        <!--begin::Separator-->
        <div class="separator separator-dashed my-3"></div>
        <!--end::Separator-->
        <!--begin::Item-->
        <div class="d-flex flex-stack">
            <!--begin::Section-->
            <div class="text-gray-700 fw-semibold fs-6 me-2">Total</div>
            <!--end::Section-->
            <!--begin::Statistics-->
            <div class="d-flex align-items-senter">
                <i class="ki-duotone ki-arrow-up-right fs-2 text-success me-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
                <!--begin::Number-->
                <span class="text-gray-900 fw-bolder fs-6">{{ $studentsGenderCounts->total_students }}</span>
                <!--end::Number-->
            </div>
            <!--end::Statistics-->
        </div>
        <!--end::Item-->
    </div>

</div>