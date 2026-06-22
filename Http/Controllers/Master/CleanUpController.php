<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Delgont\Auth\AuthManager;
use Illuminate\Support\Facades\Artisan;

class CleanUpController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        Artisan::call('permission:sync');
        //$syncPermissions = app(AuthManager::class)->syncPermissions();
        Artisan::call('cache:clear');

        return 'Cleaned';
    }
}
