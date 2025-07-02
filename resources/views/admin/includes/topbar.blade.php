<section id="topbar" class="topbar-section">
           <div class="container-fluid">
            <div class="row py-2">
                <div class="col-12 col-lg-3">
                  <a href="{{ route('home') }}" class="d-flex align-items-center py-2">
                    <img src="{{ asset('images/logo-white.svg') }}" style="" alt="logo" class="img-fluid" />
                    <small class="text-small">{{config('schoolviser.version')}}</small>
                  </a>
                </div>

                <button class="col-6 col-lg-3 d-md-none d-flex align-items-center btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar">
                    <img src="{{ asset('images/menu_24dp_EFEFEF_FILL0_wght400_GRAD0_opsz24.svg') }}" />
                    <span >Menu</span>
                </button>

                <div class="col-6 col-lg-7 d-none d-md-block">
                    <nav class="nav justify-content-end">

                        <!-- Site Settings -->
                        <a class="nav-link d-none my-0 py-0 d-lg-flex align-items-center" href="{{ route('site.settings') }}">
                            <img src="{{ asset('images/settings_24dp_F3F3F3_FILL0_wght400_GRAD0_opsz24.svg') }}" alt="Settings Icon" style="width: 24px; height: 24px; margin-right: 2px;">
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
