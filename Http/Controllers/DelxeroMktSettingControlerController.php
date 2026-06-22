<?php

namespace Modules\Schoolviser\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Modules\DelxeroMkt\Entities\HotspotUserProfile;

class DelxeroMktSettingControlerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $required_settings = [
            'students_user_profile' => null,
        ];

        $settings = (object) getTenantSettings('schoolviser_mkt', $required_settings);

        $user_profiles = HotspotUserProfile::whereCompanyId(company()->id)->get();

        return view('schoolviser::settings.mkt.index', compact('settings', 'user_profiles'));
    }

   
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) 
    {
        setTenantSetting('students_user_profile', $request->students_user_profile, 'schoolviser_mkt');

        return back()->with('success', 'Setting updated successfullyc.....');
    }

}
