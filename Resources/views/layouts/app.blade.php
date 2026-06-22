<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="base-url" content="{{ url('/') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('fonts/font-awesome-4.3.0/css/font-awesome.min.css') }}">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">


    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>


</head>
<body>
    <section id="topBar" class="topbar-section">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-3">
                    <a href="{{ route('home') }}" class="d-flex align-items-center py-2">
                    <img src="{{ asset('images/logo-white.svg') }}" style="max-height: 40px; margin-right: 2px" alt="logo" class="img-fluid" />
                    <small class="text-small">{{config('schoolviser.version')}}</small>
                    </a>
                </div>

                <button class="col-6 col-lg-3 d-md-none d-flex align-items-center btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar">
                    <img src="{{ asset('images/menu_24dp_EFEFEF_FILL0_wght400_GRAD0_opsz24.svg') }}" />
                    <span >Menu</span>
                </button>

                <div class="col-6 col-lg-7 d-none d-md-block">
                    <nav class="nav justify-content-end pt-2">

                        <!-- Site Settings -->
                        <a class="nav-link d-none my-0 py-0 d-lg-flex align-items-center" href="{{ route('site.settings') }}">
                            <ii class="fa fa-settings text-dark"></ii>
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
                    <img src="{{ auth()->user()->avator }}" alt="" class="rounded-circle d-inline" style="width: 35px;">
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="wrapper d-flex align-items-stretch" id="app">

	</div>

    @include('admin.includes.offcanvas.user')

</body>
</html>
