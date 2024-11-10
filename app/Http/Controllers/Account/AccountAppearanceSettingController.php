<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountAppearanceSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return setting('dashboard_view_layout', auth()->user());
        return view('dashboard.account.settings.appearance');
    }

   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if($request->has('dashboard_view_layout')){
            auth()->user()->updateSetting('dashboard_view_layout', $request->dashboard_view_layout, 'setting');
        }
        return back()->withInput();
    }

}
