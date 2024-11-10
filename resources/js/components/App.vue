<!--Website Root Component-->
<template>
   <div class="container-scroller">
    <Navbar />
    <div class="container-fluid page-body-wrapper">
       
       <div class="main-panel">
       <div class="content-wrapper ">
 
 
          <div class="page-header mb-2">
             <div class="row">
             <div class="col-ms-12 col-lg-5">
                <h5 class="page-title text-capitalize text-dark mb-0 fw-bold fs-5"><!--@yield('pageheader')--></h5>
                <small class="font-12 text-muted fw-100"><!--@yield('pageheaderDescription')--></small>
             </div>
             <div class="col-sm-12 mt-sm-3 col-lg-7 text-lg-end pageheader-links">
                <!-- @yield('pageheader-controls') -->
                <br />
                <div class="my-3"><!-- @yield('where-am-i') --></div>
             </div>
             </div>
          </div>
 
          <!-- @yield('content') -->
          <router-view />
       </div>
       
       
       <!-- content-wrapper ends -->
 
       <!-- @include('dashboard.includes.footer') -->
       
       <!-- partial -->
       </div>
       <!-- main-panel ends -->
    </div>
  <!-- page-body-wrapper ends -->
 
 </div>
 
  </template>
  
  <script>
  import Navbar from './Navbar.vue';
  
  export default {
     name: 'App',
     components : {
       Navbar
     }
  }
  </script>