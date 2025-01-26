@php
    $modules = config('schoolviser.modules', []);
    $modulesCount = count($modules); // Get the number of modules
@endphp
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en" class="">
<!--<![endif]-->

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <title>@yield('title')</title>

    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keywords" content="">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    @if (false)
    <link href="https://fonts.cdnfonts.com/css/open-dyslexic" rel="stylesheet">
    @endif
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

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

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
                <a class="col-lg-3 d-flex align-items-center" href="{{ route('home') }}">
                  <img src="{{ asset('images/logo.svg') }}" style="max-height: 40px; margin-right: 2px" alt="logo" class="img-fluid" />
                  <span class="text-small">{{config('schoolviser.version')}}</span>
                </a>
                <div class="col-lg-7">
                    <nav class="nav justify-content-end">

                        <!-- Site Settings -->
                        <a class="nav-link my-0 py-0 d-flex align-items-center" href="{{ route('site.settings') }}">
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
                                <a href="{{route('accounting.expenses.record.payment')}}" class="text-muted font-14 dropdown-item">Expense Payment</a>
                                <a href="" class="text-muted font-14 dev dropdown-item">Bill</a>
                                <a href="{{route('accounting.invoices.create')}}" class="text-muted font-14 dropdown-item">New Invoice</a>
                                <a href="" class="text-muted font-14 dev dropdown-item">New Project</a>
                            </div>
                        </div>
                        @endif

                        @yield('module-topbar-links')

                    </nav>

                </div>
                <div class="col-lg-2 text-end">
                    <a class="nav-link cursor-pointer" data-bs-toggle="offcanvas" data-bs-target="#userOffCanvas" aria-controls="accountQuickLinksOffCanvas">
                    <div class="nav-profile-text text-capitalize px-3 d-inline">{{ 'Hi, '.auth()->user()->name }} </div>
                    <img src="{{ asset(auth()->user()->avator ?? 'images/avator.png') }}" alt="" class="rounded-circle d-inline" style="width: 35px;">
                    </a>
                </div>
            </div>
           </div>
        </section>

        <section>
            <div class="container-xl container-lg">
                <div class="row py-3">
                    <div class="col-lg-6">
                        <h2 class="text-capitalize p-0 m-0" style="font-weight: 700;">@yield('module-page-heading')</h2>
                    </div>
                    <div class="col-lg-6 text-lg-end module-links module-quick-links module-nav">
                    @yield('module-links')
                    </div>
                    <div class="col-lg-6">
                        <small class="fw-bold">@yield('module-page-description')</small>
                    </div>
                    <div class="col-lg-6 text-end">
                        <small class="fw-bold">@yield('module-page-description-right')</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-lg-3">
                        <div class="card rounded-3">
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

                                <nav class="sidebar mb-5" data-spy="affix" data-offset-top="300" data-offset-bottom="200" role="navigation">
                                    <ul class="nav">
                                        <li>
                                            <a href="{{ route('home') }}">
                                                Dashboard
                                            </a>
                                        </li>

                                        <!-- Student Module Links -->
                                        @if (in_array(Modules\Student\Providers\StudentServiceProvider::class, config('app.providers', [])))
                                            @includeIf('student::includes.navitems.main')
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
                                </nav >
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

</body>

</html>
