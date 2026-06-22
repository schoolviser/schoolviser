<?php
/**
 * Delxero Engine (https://delgont.co.ug)
 *
 * @copyright Copyright (c) 2026. Delgont Technologies
 *
 * @license Proprietary License - Unauthorized modification or redistribution prohibited.
 * Licensed users may only use this software to host applications and develop modules
 * that extend Delxero Engine, subject to a valid license agreement.
 */

namespace Modules\Schoolviser\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Company;

class SchoolviserSetupController extends Controller
{
    public function __construct()
    {
        

        $this->middleware(function ($request, $next) {
            $company = company();

            if (!$company || $company->user_id !== auth()->id()) {
                abort(403, 'You are not authorized to access this company.');
            }
            return $next($request);
        });

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $school_type = company()->school_type;

        if(in_array($school_type, ['secondary', 'tertiary', 'primary'])){
            abort(403, 'School type is already configured');
        }
        return view('schoolviser::settings.setup', compact('school_type'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function setup(Request $request) 
    {
        $company = company();
        $company->school_type = $request->school_type;

        $company->save();

        return back()->with('success', 'Setting updated successfullyc.....');
    }
}
