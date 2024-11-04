<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Schoolviser - Login</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" />

    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}" />

    <!-- Page Level Css -->
    @yield('requiredCss')

    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" />

    <script src="{{ asset('js/auth.js') }}" defer></script>
    
    <!-- Page Level Js -->
    @yield('requiredJs')
    
  </head>
  <body>

    <section class="container">
      @yield('content')
    </section>

    <footer class="fixed-bottom py-2  bg-white" style="border-top: 1px solid rgb(234, 227, 227);">
      <div class="caontainer">
        <div class="row">
          <div class="col-lg-6 text-lg-end text-center">
            <p class="m-0">© {{ now()->year }} <a href="https://stephenokello.com">Schoolviser</a> All Rights Reserved. {{config('schoolviser.version')}}</p>
          </div>
          <div class="col-lg-6 text-lg-start text-center">
            <p class="m-0">Developed and maintained by <a href="https://stephenokello.com">Stephen Okello</a></p>
          </div>
        </div>
      </div>
    </footer>
   
  </body>
</html>