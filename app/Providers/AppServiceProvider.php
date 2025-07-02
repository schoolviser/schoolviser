<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

use App\Concerns\BootObservers;

use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;

use Laravel\Passport\Passport;
use Delgont\Armor\Armor;
use App\Schoolviser;

use App\Services\LicenseManager;

class AppServiceProvider extends ServiceProvider
{
    use BootObservers;
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Passport::hashClientSecrets();

        Schema::defaultStringLength(191);

        Paginator::useBootstrap();

        Schoolviser::enableAccounting();

        $this->BootObservers();


        $this->app->singleton('viser', function () {
            return new LicenseManager();
        });

        Armor::registerPermissionables([
            'role' => \Delgont\Armor\Models\Role::class
        ]);

    }
}
