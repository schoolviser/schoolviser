<!DOCTYPE html>
<html lang="en">

	<head>
        <title>@yield('title')</title>
		<meta charset="utf-8" />
		<meta name="robots" content="noindex, nofollow">

		<meta name="viewport" content="width=device-width, initial-scale=1" />

		<link rel="canonical" href="{{ url('/') }}" />
		<link rel="shortcut icon" href="{{ asset(config('delxero.favicon', 'media/logos/favicon.png')) }}" />

		<!--begin::Fonts(mandatory for all pages)-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
		<link href="{{asset('css/plugins.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('css/style.css')}}" rel="stylesheet" type="text/css" />
	</head>

	<body id="kt_app_body" data-kt-app-layout="light-header" data-kt-app-header-fixed="true" data-kt-app-toolbar-enabled="true" class="app-default">
        
		<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
		
        <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
			<!--begin::Page-->
			<div class="app-page flex-column flex-column-fluid" id="kt_app_page">

				<!--begin::Header-->
				<div id="kt_app_header" class="app-header" data-kt-sticky="true" data-kt-sticky-activate="{default: true, lg: true}" data-kt-sticky-name="app-header-minimize" data-kt-sticky-offset="{default: '200px', lg: '0'}" data-kt-sticky-animation="false">
					<!--begin::Header container-->
					<div class="app-container container-xxl d-flex align-items-stretch justify-content-between" id="kt_app_header_container">
                        
						<!--begin::Logo-->
						<div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0 me-lg-15">
							<a href="index.html">
								<img alt="Logo" src="{{ asset(config('delxero.logo_light', 'media/logos/logo-light.svg')) }}" class="h-20px h-lg-30px app-sidebar-logo-default theme-light-show" />
								<img alt="Logo" src="{{ asset(config('delxero.logo_dark', 'media/logos/logo-dark.svg')) }}" class="h-20px h-lg-30px app-sidebar-logo-default theme-dark-show" />
							</a>
						</div>
						<!--end::Logo-->

						<!--begin::Header wrapper-->
						<div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1" id="kt_app_header_wrapper">

							<!--begin::Menu wrapper-->
							<div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true" data-kt-swapper-mode="{default: 'append', lg: 'prepend'}" data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">

								@tertiarySchool
									<div class="menu menu-rounded menu-column menu-lg-row my-5 my-lg-0 align-items-stretch fw-semibold px-2 px-lg-0" id="kt_app_header_menu" data-kt-menu="true">
										@include('schoolviser::layouts.dashboard.menus._tertiary_students_menuitems')
									</div>
								@else
									<div class="menu menu-rounded menu-column menu-lg-row my-5 my-lg-0 align-items-stretch fw-semibold px-2 px-lg-0" id="kt_app_header_menu" data-kt-menu="true">
										@include('schoolviser::layouts.dashboard.menus._students_menuitems')
									</div>
								@endtertiarySchool


								<!--end::Menu-->

							</div>
							<!--end::Menu wrapper-->

							<!--begin::Navbar-->
                            @include('schoolviser::layouts.delxero.header._app_navbar')
							<!--end::Navbar-->
							

						</div>
						<!--end::Header wrapper-->
					</div>
					<!--end::Header container-->
				</div>
				<!--end::Header-->

				<!--begin::Wrapper-->
				<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
					<!--begin::Main-->
					<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
						<!--begin::Content wrapper-->
						<div class="d-flex flex-column flex-column-fluid">

							<!--begin::Toolbar-->
							@include('layouts.delxero.partials.light_header_toolbar')
							<!--end::Toolbar-->
                            
							<!--begin::Content-->
							<div id="kt_app_content" class="app-content flex-column-fluid">

								<!--begin::Content container-->
								<div id="kt_app_content_container" class="app-container container-xxl">
									@yield('content')
								</div>
								<!--end::Content container-->
							</div>
							<!--end::Content-->
						</div>
						<!--end::Content wrapper-->

						<div id="kt_app_footer" class="app-footer">
							<div class="app-container container-xxl d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
								<div class="text-gray-900 order-2 order-md-1">
									<span class="text-muted fw-semibold me-1">2026&copy;</span>
									<a href="https://delgont.co.ug" target="_blank" class="text-gray-800 text-hover-primary">Delgont Technologies | {{ company()?->name ?? 'No Company' }}</a>
								</div>
								<ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
									<li class="menu-item">
										<a href="https://delgont.co.ug/about-us" target="_blank" class="menu-link px-2">About</a>
									</li>
									@siteAdmin
									<li class="menu-item">
										<a href="{{ route('siteadmin.index') }}"  class="menu-link px-2">Site Administration</a>
									</li>
									@endsiteAdmin
									
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>


		<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
		<i class="bi bi-arrow-up"></i>
			<i class="bi bi-arrow-up"></i>
		</div>

		<script>var hostUrl = "{{asset('metronic/')}}";</script>

		<script src="{{asset('js/plugins.js')}}"></script>
		<script src="{{asset('js/scripts.js')}}"></script>

        @yield('requiredJs')
        @yield('scripts')

	</body>
	<!--end::Body-->
</html>