<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class SiteSettingsController extends Controller
{
    public function index()
    {
        return view('admin.settings.index');
    }
}
