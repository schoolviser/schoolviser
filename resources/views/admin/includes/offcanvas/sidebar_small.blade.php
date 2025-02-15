 <div class="offcanvas offcanvas-start rounded-end-3" tabindex="-1"style="width: 270px;" id="offcanvasSidebar">

    <div class="offcanvas-header border-bottom border-light">
        <img src="{{ asset('images/avator.png') }}" alt="" style="width: 15%;" class="rounded-circle border border-light shadow-sm" />
        <h5 class="offcanvas-title text-start text-capitalize w-75 px-2" id="">
        <small class="font-16 fw-bold">{{ auth()->user()->name }} </small><br class="mb-0" />
        <small>{{ (auth()->user()->user_type) ? auth()->user()->usertype->first_name.' '.auth()->user()->usertype->last_name : '' }} </small>
        </h5>
        <button type="button" class="btn-close text-reset font-12" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body sidebar">

        <ul class="list-group nav">

            <li class="list-group-item border-0">
                <a class="nav-link d-flex align-items-center" href="{{ route('home') }}">
                    <img src="{{ asset('images/dashboard_24dp_434343_FILL0_wght400_GRAD0_opsz24.svg') }}" alt="Settings Icon" style="width: 24px; height: 24px; margin-right: 4px;">
                    <span class="menu-title fw-bold text-muted" style="font-size: 15px;">{{ __('Dashboard') }}</span>
                </a>
                <hr class="mb-0 mt-2" />
            </li>

             <!-- Student Module Links -->
            @if (in_array(Modules\Student\Providers\StudentServiceProvider::class, config('app.providers', [])))
                @includeIf('student::includes.navitems.main')
            @endif

            <!-- Fees Module Links -->
            @if (in_array(Modules\Fee\Providers\FeeServiceProvider::class, config('app.providers', [])))
                @includeIf('fee::includes.navitems.main')
            @endif

            <!-- Admission Module Links -->
            @if (class_exists('Modules\Admission\Providers\AdmissionServiceProvider') && in_array(Modules\Admission\Providers\AdmissionServiceProvider::class, config('app.providers', [])))
                @includeIf('admission::includes.navitems.main')
            @endif

            <!-- Accounting Module Links -->
            @if (in_array(Modules\Accounting\Providers\AccountingServiceProvider::class, config('app.providers', [])))
                @includeIf('accounting::includes.navitems.main')
            @endif


        </ul>

    </div>
</div>
