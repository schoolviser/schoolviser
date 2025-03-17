<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Delgont\Armor\Concerns\MultiAuthCredentials;

use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    use MultiAuthCredentials;

    public function login(Request $request)
    {

        if(!Auth::attempt($this->credentials($request))){
            return response()->json([
                'message' => 'Invalid email or password'
            ], 401);
        }



        $user = Auth::user();

        if(!$user){
            return response()->json([
                'message' => 'User not found'
            ], 401);
        }

        $token = $user->createToken('Access Token')->accessToken;

        //$user->access_token = $token->accessToken;

        return response()->json([
            'token' => $token
        ], 200);
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
