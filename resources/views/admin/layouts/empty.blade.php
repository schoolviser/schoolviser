<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Schoolviser - @yield('title')</title>

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
  <body>
    <div class="container-scroller">
     
      <div class="container page-body-wrapper py-5">

        <div class="main-panel py-5">
          <div class="content-wrapper border border-light">
            <section>
              <div class="container">
                <div class="row pb-3">
                  <div class="col-lg-12">@yield('links')</div>
                </div>
              </div>
            </section>
            @yield('content')
          </div>
          
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->

    </div>
   
  </body>
</html>