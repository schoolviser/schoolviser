@php
    $modules = config('schoolviser.modules', []);
    $modulesCount = count($modules); // Get the number of modules
@endphp
<!DOCTYPE html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <title>@yield('title')</title>


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- Base URL -->
    <meta name="base-url" content="{{ url('/') }}" />

    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" type="text/css" href="{{ asset('fonts/font-awesome-4.3.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/basic.css') }}">

    <!-- Page Level Css -->
    @yield('requiredCss')

    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" />

    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark') {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
    <script src="{{ asset('js/basic.js') }}" defer></script>
    <!-- Page Level Js -->
    @yield('requiredJs')


</head>

<body style="background-color: rgb(241,250,248)">
    <button onclick="topFunction()" id="goToTopBtn" title="Go to top"><i class="fa fa-chevron-up" aria-hidden="true"></i></button>

    <script>
        var mybutton = document.getElementById("goToTopBtn");
        window.onscroll = function() {scrollFunction()};
        function scrollFunction() {
            if (document.body.scrollTop > 1000 || document.documentElement.scrollTop > 1000) {
                mybutton.style.display = "block";
            } else {
                mybutton.style.display = "none";
            }
        }
        function topFunction() {
            window.scrollTo({ top: 0, behavior: 'smooth' })
            document.documentElement.scrollTo({ top: 0, behavior: 'smooth' })
        }

        // Function to toggle dark mode and save the preference
        function toggleDarkMode() {
            document.querySelector('html').classList.toggle('dark');
            // Save the current mode in localStorage
            if (document.querySelector('html').classList.contains('dark')) {
                localStorage.setItem('theme', 'dark');
            } else {
                localStorage.setItem('theme', 'light');
            }
        }

        // Apply the saved theme when the page loads
        document.addEventListener("DOMContentLoaded", () => {
            // Check if 'theme' is stored in localStorage
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark') {
                document.querySelector('html').classList.add('dark');
                const tables = document.querySelectorAll('table');
                tables.forEach(table => {
                    if (document.documentElement.classList.contains('dark')) {
                        table.classList.add('table-dark');
                    } else {
                        table.classList.remove('table-dark');
                    }
                });
            }

            // Toggle the dark mode when the button is clicked
            document.querySelector('#mode').addEventListener('click', toggleDarkMode);
        });


    </script>

    <div id="wrapper">

        <section id="topBar" class="topbar-section bg-primary">
           <div class="container">
            <div class="row py-2">
                <div class="col-12 col-lg-3">
                  <a href="{{ route('home') }}" class="d-flex align-items-center py-2">
                    <img src="{{ asset('images/logo.svg') }}" style="max-height: 40px; margin-right: 2px" alt="logo" class="img-fluid" />
                    <small class="text-small">{{config('schoolviser.version')}}</small>
                  </a>
                </div>

                <button class="col-6 col-lg-3 d-md-none d-flex align-items-center btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar">
                    <img src="{{ asset('images/menu_24dp_EFEFEF_FILL0_wght400_GRAD0_opsz24.svg') }}" />
                    <span >Menu</span>
                </button>

                <div class="col-6 col-lg-7 d-none d-md-block">
                    <nav class="nav justify-content-end">

                        <!-- Site Settings -->
                        <a class="nav-link d-none my-0 py-0 d-lg-flex align-items-center" href="{{ route('site.settings') }}">
                            <img src="{{ asset('images/settings_24dp_F3F3F3_FILL0_wght400_GRAD0_opsz24.svg') }}" alt="Settings Icon" style="width: 24px; height: 24px; margin-right: 2px;">
                            Site Settings
                        </a>

                        <!-- Accounting Create New Links -->
                        @if (in_array(Modules\Accounting\Providers\AccountingServiceProvider::class, config('app.providers')))
                        <div class="dropdown ml-5">

                            <a class="nav-link my-0 py-0 d-flex align-items-center" id="messageDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ asset('images/add_24dp_F3F3F3_FILL0_wght400_GRAD0_opsz24.svg') }}" alt="Settings Icon" style="width: 24px; height: 24px; margin-right: 2px;">
                                New
                            </a>
                            <div class="dropdown-menu" aria-labelledby="messageDropdown">
                                <a href="{{route('accounting.expenses.create')}}" class="text-muted font-14 dropdown-item">Expense Payment</a>
                                <a href="" class="text-muted font-14 dev dropdown-item">Bill</a>
                                <a href="{{route('accounting.invoices.create')}}" class="text-muted font-14 dropdown-item">New Invoice</a>
                                <a href="" class="text-muted font-14 dev dropdown-item">New Project</a>
                            </div>
                        </div>
                        @endif

                        @yield('module-topbar-links')

                    </nav>

                </div>
                <div class="col-6 col-lg-2 text-end">
                    <a class="nav-link cursor-pointer" data-bs-toggle="offcanvas" data-bs-target="#userOffCanvas" aria-controls="accountQuickLinksOffCanvas">
                    <div class="nav-profile-text text-capitalize px-3 d-inline">{{ 'Hi, '.auth()->user()->name }} </div>
                    <img src="{{ asset(auth()->user()->avator ?? 'images/avator.png') }}" alt="" class="rounded-circle d-inline" style="width: 35px;">
                    </a>
                </div>
            </div>
           </div>
        </section>

        <section>
            <div class="container container-xl container-lg">
                <div class="row py-3 py-md-4">
                    <div class="col-9 col-md-4">
                        <h2 class="text-capitalize pt-3 pb-1 p-lg-0 m-lg-0 module-page-heading" style="font-weight: 700;">@yield('module-page-heading')</h2>
                    </div>
                    <div class="d-none d-md-block mb-3 col-md-8 text-lg-end  module-links module-quick-links module-nav">
                        @yield('module-links')
                    </div>

                    <div class="d-block d-md-none col-3 text-lg-end  mobile-module-links">
                        <div class="dropdown pt-3 pb-1 p-lg-0 m-lg-0">
                            <button
                                class="btn btn-primary dropdown-toggle"
                                type="button"
                                id="triggerId"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                            >
                                <img src="{{ asset('images/menu_24dp_EFEFEF_FILL0_wght400_GRAD0_opsz24.svg') }}" alt="">
                            </button>
                            <div class="dropdown-menu" aria-labelledby="triggerId">
                                @yield('mobile-module-links')

                            </div>
                        </div>

                    </div>

                </div>
                <div class="row">
                    <div class="col-md-3 col-lg-3 d-none d-md-block">
                        <div class="card mb-3 rounded-3">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-12 text-uppercase">
                                        <small class="mb-0 p-0 fw-bold">{{ 'Sidebar Navigation' }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @php
                                    $modules = config('schoolviser.modules', []);
                                    $modulesCount = count($modules); // Get the number of modules
                                @endphp

                                <div class="above-sidebar">
                                    @yield('above-sidebar')
                                </div>

                                <!-- Sidebar for Larger Screens -->
                                <nav class="sidebar mb-5 d-none d-md-block" role="navigation">

                                    <ul class="nav list-group">
                                        <li class="list-group-item border-0">
                                            <a class="nav-link d-flex align-items-center" href="{{ route('home') }}">
                                                <img src="{{ asset('images/dashboard_24dp_434343_FILL0_wght400_GRAD0_opsz24.svg') }}" alt="Settings Icon" style="width: 24px; height: 24px; margin-right: 4px;">
                                                <span class="menu-title fw-bold text-muted" style="font-size: 15px;">{{ __('Dashboard') }}</span>
                                            </a>
                                            <hr class="mb-0 mt-2" />
                                        </li>

                                        <!-- Student Module Links -->
                                        @if (in_array(Modules\Student\Providers\StudentServiceProvider::class, config('app.providers', [])))
                                            @includeIf('student::includes.navitems.main')
                                        @endif

                                        <!-- Fees Module Links -->
                                        @if (in_array(Modules\Fee\Providers\FeeServiceProvider::class, config('app.providers', [])))
                                            @includeIf('fee::includes.navitems.main')
                                        @endif

                                        <!-- Admission Module Links -->
                                        @if (class_exists('Modules\Admission\Providers\AdmissionServiceProvider') && in_array(Modules\Admission\Providers\AdmissionServiceProvider::class, config('app.providers', [])))
                                            @includeIf('admission::includes.navitems.main')
                                        @endif

                                        <!-- Accounting Module Links -->
                                        @if (in_array(Modules\Accounting\Providers\AccountingServiceProvider::class, config('app.providers', [])))
                                            @includeIf('accounting::includes.navitems.main')
                                        @endif

                                        <!-- Other Modules -->
                                        @foreach ($modules as $module)
                                            @includeIf($module.'::includes.navitems.main', ['some' => 'data'])
                                        @endforeach
                                    </ul>
                                </nav>


                                <div class="below-sidebar">
                                    @yield('below-sidebar')
                                </div>
                             </div>
                        </div>
                    </div>

                    <div class="col-md-9 col-lg-9">

                        <div class="content"  id="content">@yield('content')</div>
                    </div>
                </div>
            </div>
        </section>


        <!-- // end container -->

    </div>
    <!-- end wrapper -->

    @php
        $use_custom_footer = false;

    @endphp
    @if ($use_custom_footer)
        @yield('footer')
    @else
    <footer class="py-5 mt-3">

        <section class="top-section text-white">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                    </div>
                    <div class="col-lg-3"></div>
                    <div class="col-lg-8"></div>
                </div>
            </div>
        </section>

        <section class="bottom-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 text-capitalize text-white">
                        {{ option('school_name', 'schoolviser_school_info') }}
                    </div>
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4 text-lg-end">
                    </div>
                </div>
            </div>
        </section>

    </footer>

    @endif

@include('admin.includes.offcanvas.user')

 <!-- Offcanvas Sidebar for Small Screens -->
 @includeIf('admin.includes.offcanvas.sidebar_small', ['some' => 'data'])

</body>

</html>
