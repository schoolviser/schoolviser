<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>@yield('title')</title>

   

     <!-- CSRF Token -->
     <meta name="csrf-token" content="{{ csrf_token() }}">

     <!-- Base URL -->
     <meta name="base-url" content="{{ url('/') }}" />

     <!-- Material Design Icons -->
     <link rel="stylesheet" href="{{ asset('mdi/css/materialdesignicons.min.css') }}">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('css/app-horizontal.css') }}" />

    <!-- Page Level Css -->
    @yield('requiredCss')

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" />

    <script src="{{ asset('js/app.js') }}" defer></script>
    
    @yield('requiredJs')
    
  </head>
  <body class="sidebar-toggle-display" data-bs-theme="light">
    <div class="container-scroller">

      <!-- Accounting Navigation Set As Default -->
     @include('admin.includes.accounting_navbar')
     
      <div class="container-fluid page-body-wrapper">

        
        <div class="main-panel">
          <div class="content-wrapper mb-4 pb-5 ">


            <div class="page-header mb-2">
              <div class="row">
                <div class="col-ms-12 col-lg-5 pt-3">
                  <h5 class="page-title text-capitalize text-primary mb-0 fw-bold fst-italic fs-5">@yield('module-page-heading')</h5>
                  <small class="font-12 text-muted fw-100">@yield('module-page-description')</small>
                </div>
                <div class="col-sm-12 mt-sm-3 col-lg-7 text-lg-end pageheader-links fst-italic">
                  @yield('module-links')
                  <br />
                  <div class="my-3">@yield('where-am-i')</div>
                </div>
              </div>
            </div>

            @yield('content')
          </div>
          
          
          <!-- content-wrapper ends -->

          <!-- dashboard:includes/footer -->
          @include('admin.includes.footer')
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->

    </div>


    <!-- Advanced Features Offcanvas -->
    @include('admin.includes.offcanvas.advanced_features')
   
  </body>
</html>
