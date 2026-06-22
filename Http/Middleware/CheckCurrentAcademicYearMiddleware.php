<?php

namespace Modules\Schoolviser\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Schoolviser\Entities\AcademicYear;
use Carbon\Carbon;

class CheckCurrentAcademicYearMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $companyId = company()?->id;
        $currentYear = AcademicYear::whereCompanyId($companyId)->current()->first();

        if (!$currentYear) {
            // Option 1: abort with error
            return response()->json([
                'message' => 'No current academic year is set. Please configure one before proceeding.'
            ], 400);

            // Option 2: redirect to a setup page
            // return redirect()->route('academic-years.create')
            //     ->with('error', 'You must set the current academic year first.');
        }

        // Optionally bind the current year into the request for downstream use
        $request->attributes->set('currentAcademicYear', $currentYear);

        return $next($request);
    }
}
