@extends(env('ADMIN_LAYOUT'))


@section('module-page-heading', 'Dashboard')

@section('module-page-description', config('schoolviser.school_name'))
@section('module-page-description-right', config('schoolviser.school_name'))

@section('module-links')
    <a href="" class="module-link">Students</a>
    <a href="" class="module-link">admissions</a>
    <a href="" class="module-link">Schoolviser</a>
@endsection



@section('requiredCss')
<style>
  .table-responsive {
    overflow-x: auto !important;
  }


</style>
@endsection

@section('requiredJs')
<script src="{{ asset('chart.js/Chart.min.js') }}" defer></script>
@endsection

@section('content')
    <div class="row row-1">

      <!-- Students Module -->
      @if (in_array(Modules\Student\Providers\StudentServiceProvider::class, config('app.providers', [])))
        @rolecan('can_view_student_totals')
          <div class="col-lg-6">

            <div class="row">

             <div class="col-lg-12">
                <div class="card mb-3" style="border-color: rgb(136,211,202);">
                    <div class="card-body row m-0 py-2 pl-1 text-uppercase" style="font: 20px;">
                    <div class="col-lg-5"><small class="mb-0 p-0" data-bs-target="#FeeParticularsTable" data-bs-toggle="collapse" style="cursor: pointer;">{{ 'Totoal Students' }}</small></div>
                    <div class="col-lg-5 text-end p-0" style="font-weight: 800;">{{ $overview->total_students }}</div>
                    <div class="col-lg-2"></div>
                    </div>
                </div>
            </div>

              <div class="col-lg-6">
                <div class="card mb-3" style="border-color: rgb(136,211,202);">
                  <div class="card-body row m-0 py-2 pl-1 text-uppercase" style="font: 20px;">
                    <div class="col-lg-6 d-flex align-items-center">
                      <img src="{{ asset('images/girl_24dp_434343_FILL0_wght400_GRAD0_opsz24.svg') }}" alt="Settings Icon" style="width: 24px; height: 24px; margin-right: 2px;">
                      <small class="mb-0 p-0" data-bs-target="#FeeParticularsTable" data-bs-toggle="collapse" style="cursor: pointer;">{{ 'Female' }}</small>
                    </div>
                    <div class="col-lg-6 text-end p-0" style="font-weight: 800;">{{ $overview->total_female }}</div>
                  </div>
                </div>
              </div>

              <div class="col-lg-6">
                <div class="card mb-3" style="border-color: rgb(136,211,202);">
                  <div class="card-body row m-0 py-2 pl-1 text-uppercase" style="font: 20px;">
                    <div class="col-lg-6 d-flex align-items-center">
                      <img src="{{ asset('images/man_24dp_434343_FILL0_wght400_GRAD0_opsz24.svg') }}" alt="Settings Icon" style="width: 24px; height: 24px; margin-right: 2px;">
                      <small class="mb-0 p-0" data-bs-target="#FeeParticularsTable" data-bs-toggle="collapse" style="cursor: pointer;">{{ 'Male' }}</small>
                    </div>
                    <div class="col-lg-6 text-end p-0" style="font-weight: 800;">{{ $overview->total_male }}</div>
                  </div>
                </div>
              </div>

            </div>

          </div>
        @endrolecan
      @endif

      <!-- //Students Module -->

      <!-- Admissions Module -->
      @if (in_array(Modules\Admission\Providers\AdmissionServiceProvider::class, config('app.providers', [])))
        @includeIf('admission::includes.cards.dashboard', ['some' => 'data'])
      @endif


    </div>
@endsection
