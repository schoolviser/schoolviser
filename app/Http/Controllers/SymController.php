<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SymController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        symlink($_SERVER['DOCUMENT_ROOT'].'/storage/app/public', $_SERVER['DOCUMENT_ROOT'].'/public/storage');
        return 'good';
    }
}
