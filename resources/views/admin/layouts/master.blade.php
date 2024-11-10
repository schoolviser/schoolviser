<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Schoolviser - Dashboard</title>

    <!-- Mdi:Css -->
    <link rel="stylesheet" href="{{ asset('mdi/css/materialdesignicons.min.css') }}">
    
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />

    <!-- Page Level Css -->
    @yield('requiredCss')

    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" />

    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Page Level Js -->
    @yield('requiredJs')
    
  </head>
  <body class="sidebar-toggle-display {{ option('sidebar_icon_only', 'sidebar-icon-only') }}">
    <div class="container-scroller">

      @include('dashboard.includes.sidebar')
     
      <div class="container-fluid page-body-wrapper">

        @include('dashboard.includes.navbar')
        
        <div class="main-panel">
          <div class="content-wrapper ">


            <div class="page-header mb-2" style="border-: 1px solid #dcdcdc;">
              <div class="row">
                <div class="col-lg-5">
                  <h5 class="page-title text-capitalize text-primary mb-0 font-weight-bolder" style="font-weight: 800;">@yield('pageheader')</h5>
                  <small class="font-12 text-muted" style="font-weight: 500;">@yield('pageheaderDescription')</small>
                </div>
                <div class="col-lg-7 text-end pageheader-links">
                  @yield('pageheader-controls')
                  <br />
                  <div class="my-1">@yield('where-am-i')</div>
                </div>
              </div>
            </div>

            <div class="container">@yield('content')</div>
          </div>
          <!-- content-wrapper ends -->

          <!-- dashboard:includes/footer -->
          @include('dashboard.includes.footer')
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->

    </div>
   
  </body>
</html>