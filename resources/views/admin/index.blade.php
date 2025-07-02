@extends(env('ADMIN_LAYOUT'))


@section('module-page-heading', 'Dashboard')


@section('requiredJs')
    <script src="{{ asset('chart.js/Chart.min.js') }}" defer></script>
    <script>
    var studentsPerCourseChartLabels = @json(array_keys($studentsPerCourseGraphData));
    var studentsPerCourseChartData = @json(array_values($studentsPerCourseGraphData));

    </script>
    <script src="{{ asset('js/student.js') }}" defer></script>
@endsection

@section('content')
    <div class="row row-1">

      <!-- Students Module -->
      @if (in_array(Modules\Student\Providers\StudentServiceProvider::class, config('app.providers', [])))
        @rolecan('can_view_student_totals')
          <div class="col-12 col-md-6">

            <div class="row">

             <div class="col-12 col-lg-12">
                <div class="card mb-3" style="border-color: rgb(136,211,202);">
                    <div class="card-body row m-0 py-2 pl-1 text-uppercase" style="font: 20px;">
                        <div class="col-12 col-lg-6"><small class="mb-0 p-0" data-bs-target="#FeeParticularsTable" data-bs-toggle="collapse" style="cursor: pointer;">{{ 'Totoal Students' }}</small></div>
                        <div class="col-6 col-lg-4 text-md-end" style="font-weight: 800; font-size: 20px;">{{ $overview->total_students }}</div>
                        <div class="col-6 col-lg-2 text-end">
                        </div>
                    </div>
                </div>
            </div>

              <div class="col-6 col-lg-6">
                <div class="card mb-3" style="border-color: rgb(136,211,202);">
                  <div class="card-body row m-0 py-2 pl-1 text-uppercase" style="font: 20px;">
                    <div class="col-12 col-lg-6 d-flex align-items-center">
                      <img src="{{ asset('images/girl_24dp_434343_FILL0_wght400_GRAD0_opsz24.svg') }}" alt="Settings Icon" style="width: 24px; height: 24px;">
                      <a href="{{ route('students.gender.based', ['gender' => 'female']) }}" class="mb-0 p-0 text-small">{{ 'Female' }}</a>
                    </div>
                    <div class="col-lg-6 text-md-end p-md-0" style="font-weight: 800; font-size: 20px;">{{ $overview->total_female }}</div>
                  </div>
                </div>
              </div>

              <div class="col-6 col-lg-6">
                <div class="card mb-3" style="border-color: rgb(136,211,202);">
                  <div class="card-body row m-0 py-2 pl-1 text-uppercase" style="font: 20px;">
                    <div class="col-12 col-lg-6 d-flex align-items-center">
                      <img src="{{ asset('images/man_24dp_434343_FILL0_wght400_GRAD0_opsz24.svg') }}" alt="Settings Icon" style="width: 24px; height: 24px;">
                        <a href="{{ route('students.gender.based', ['gender' => 'male']) }}" class="mb-0 p-0 text-small">{{ 'Male' }}</a>
                    </div>
                    <div class="col-12 col-lg-6 text-md-end p-md-0" style="font-weight: 800; font-size: 20px">{{ $overview->total_male }}</div>
                  </div>
                </div>
              </div>

            </div>

          </div>

          <!-- Student Per Course Chart -->
          <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-8 text-uppercase">
                                <small class="mb-0 p-0 fw-bold">{{ 'Students Per Course' }}</small>
                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="studentsPerCourseChart" height="200px"></canvas>
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
    <div class="row mt-3">


    </div>


    <div
        class="offcanvas offcanvas-start rounded-end-3" data-url="{{ 'hello' }}"
        data-bs-scroll="true"
        tabindex="-1"
        id="studentsInformationOffcanvas"
        aria-labelledby="Enable both scrolling & backdrop"
    >
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="Enable both scrolling & backdrop">
                Students Information
            </h5>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="offcanvas"
                aria-label="Close"
            ></button>
        </div>
        <div class="offcanvas-body">
            <p>
                Loading ..
            </p>
        </div>
    </div>

@endsection
