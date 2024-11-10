<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\User;
use Carbon\Carbon;

class LastSeenController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return User::employee()->whereNotNull('last_seen_at')->where('id', '!=', auth()->user()->id)->whereBetween('last_seen_at', [Carbon::now()->subHours(14), Carbon::now()])->get();
    }
}
