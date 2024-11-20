<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

use App\Concerns\BootObservers;

use Illuminate\Support\Facades\View;
use App\Http\View\Composers\AdminPermissionComposer;

use Illuminate\Pagination\Paginator;

use Laravel\Passport\Passport;


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

        $this->BootObservers();

        //Admin Permission Registrars
        View::composer('admin.*', AdminPermissionComposer::class);

    }
}
