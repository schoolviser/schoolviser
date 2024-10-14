@extends(config('student.layout', 'student::layouts.master'))


@section('module-page-heading', 'Dashboard')
@section('pageheaderDescription', 'Manage Students')



@section('requiredCss')
<style>
  .table-responsive {
    overflow-x: auto !important;
  }
</style>
@endsection

@section('requiredJs')
<script src="{{ asset('chart.js/Chart.min.js') }}" defer></script>

<script src="{{ asset('js/dashboard.js') }}" defer></script>
@endsection

@section('content')
    <div class="row row-1">

      <!-- Students Module -->
      <div class="col-lg-6">
        
        <div class="row">

          <div class="col-lg-12">
            <div class="card mb-3" style="border-color: rgb(136,211,202);">
              <div class="card-body row m-0 py-2 pl-1 text-uppercase" style="font: 20px;">
                <div class="col-lg-5"><small class="mb-0 p-0" data-bs-target="#FeeParticularsTable" data-bs-toggle="collapse" style="cursor: pointer;">{{ 'Totoal Students' }}</small></div>
                <div class="col-lg-5 text-end p-0" style="font-weight: 800;">0</div>
                <div class="col-lg-2"></div>
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="card mb-3" style="border-color: rgb(136,211,202);">
              <div class="card-body row m-0 py-2 pl-1 text-uppercase" style="font: 20px;">
                <div class="col-lg-6"><small class="mb-0 p-0" data-bs-target="#FeeParticularsTable" data-bs-toggle="collapse" style="cursor: pointer;">{{ 'Female' }}</small></div>
                <div class="col-lg-6 text-end p-0" style="font-weight: 800;">0</div>
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="card mb-3" style="border-color: rgb(136,211,202);">
              <div class="card-body row m-0 py-2 pl-1 text-uppercase" style="font: 20px;">
                <div class="col-lg-6"><small class="mb-0 p-0" data-bs-target="#FeeParticularsTable" data-bs-toggle="collapse" style="cursor: pointer;">{{ 'Male' }}</small></div>
                <div class="col-lg-6 text-end p-0" style="font-weight: 800;">4000000</div>
              </div>
            </div>
          </div>

        </div>

      </div>
      <!-- //Students Module -->

      <div class="col-lg-6">
        

      </div>


    </div>
@endsection
