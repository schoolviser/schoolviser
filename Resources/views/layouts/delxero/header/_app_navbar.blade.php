<div class="app-navbar flex-shrink-0">

    <div class="app-navbar-item ms-1 me-lg-4 ms-md-4">
        <a href="{{route('settings.index')}}" class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
            <i class="bi bi-gear fs-2"></i> <span class="ms-1">Settings</span>
        </a>
    </div>
    
    <!--begin::Theme mode-->
    <div class="app-navbar-item ms-1 ms-md-4">
        <!--begin::Menu toggle-->
        <a href="#" class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px" data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
            <!-- Light mode icon -->
            <i class="bi bi-sun theme-light-show fs-1"></i>

            <!-- Dark mode icon -->
            <i class="bi bi-moon theme-dark-show fs-1"></i>


        </a>
        <!--begin::Menu toggle-->
        <!--begin::Menu-->
        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px" data-kt-menu="true" data-kt-element="theme-mode-menu">
            <!--begin::Menu item-->

            
            <div class="menu-item px-3 my-0">
                <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
                    <span class="menu-icon" data-kt-element="icon">
                        <i class="bi bi-sun fs-2">
                        </i>
                    </span>
                    <span class="menu-title">Light</span>
                </a>
            </div>
            
            <div class="menu-item px-3 my-0">
                <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
                    <span class="menu-icon" data-kt-element="icon">
                        <i class="bi bi-moon fs-2">
                        </i>
                    </span>
                    <span class="menu-title">Dark</span>
                </a>
            </div>
            <!--end::Menu item-->
            <!--begin::Menu item-->
            <div class="menu-item px-3 my-0">
                <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
                    <span class="menu-icon" data-kt-element="icon">
                        <i class="bi bi-system fs-2">
                        </i>
                    </span>
                    <span class="menu-title">System</span>
                </a>
            </div>
            <!--end::Menu item-->
        </div>
        <!--end::Menu-->
    </div>
    
    <div class="app-navbar-item ms-1 ms-md-4" id="kt_header_user_menu_toggle">
        <div class="cursor-pointer symbol symbol-35px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
            <img src="{{asset('media/avatars/blank.png')}}" class="rounded-3" alt="user" />
            {{ str_limit(auth()->user()->name, 10) }} 
        </div>
        @include('layouts.partials._usermenu')

    </div>

    <div class="app-navbar-item d-lg-none ms-2 me-n2" title="Show header menu">
        <div class="btn btn-flex btn-icon btn-active-color-primary w-30px h-30px" id="kt_app_header_menu_toggle">
            <i class="bi bi-grid fs-1">
            </i>
        </div>
    </div>

</div>