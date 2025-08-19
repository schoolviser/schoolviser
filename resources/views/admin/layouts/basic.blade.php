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

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset('fonts/font-awesome-4.3.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/basic.css') }}">

    <!-- Page Level Css -->
    @yield('requiredCss')
    @yield('required-css')

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
    @yield('required-js')

</head>

<body style="background-coloor: rgb(241,250,248)">
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

    @include('admin.includes.topbar')

    <div class="wrapper d-flex align-items-stretch">
         <!-- Sidebar for Larger Screens -->
        <nav class="sidebar mb-5 d-none d-md-block" role="navigation" id="sidebar">



            <ul class="nav list-group">
                <li class="list-group-item">
                    @includeIf('accounting::components.select_company', ['some' => 'data'])
                </li>
                <li class="list-group-item border-0">
                    <a class="nav-link d-flex align-items-center" href="{{ route('home') }}">
                        <i class="fa fa-home" aria-hidden="true"></i>
                        <span class="menu-title text-muted">{{ __('Dashboard') }}</span>
                    </a>
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

        <!-- Page Content  -->
        <div id="content" class="p-4">
            <div class="row mb-4">
                <div class="col-9 col-md-4 col-lg-6">
                    <h4 class="text-capitalize pt-3 pb-2 p-lg-0 m-lg-0 module-page-heading fw-bold">@yield('module-page-heading')</h4>
                    <small class="text-muted">@yield('module-page-description')</small>

                </div>
                <div class="d-none d-md-block mb-3 col-md-8 col-lg-6 text-lg-end  module-links module-quick-links module-nav">
                    @yield('module-page-links', 'provide module page links')
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
            @yield('content')
        </div>
	</div>

    @include('admin.includes.offcanvas.user')
    @includeIf('admin.includes.offcanvas.sidebar_small', ['some' => 'data'])

    @yield('scripts')
</body>

</html>
