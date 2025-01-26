<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;

use Delgont\Armor\Concerns\MultiAuthCredentials;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers, MultiAuthCredentials, ThrottlesLogins;

    /**
     * Where to redirect users after login - You can redirect to users default home page
     *
     * @var string
     */
    protected $redirectTo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');

          // Apply the middleware only on the login page route
          $this->middleware('track.page-access:login-page')->only('showLoginForm');
    }

    /**
     * Override this method for multi user authentication to work
     */
    protected function credentials(Request $request)
    {
        return $this->multiAuthCredentials($request);
    }




    public function username()
    {
        return 'username_email';
    }


}
