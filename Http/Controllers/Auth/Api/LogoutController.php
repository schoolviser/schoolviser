<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function logout()
    {
        auth()->user()->token()->revoke();

        return response()->json([
            'success' => 'logged out'
        ],200);
    }
}
