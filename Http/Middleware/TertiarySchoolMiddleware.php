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

namespace Modules\Schoolviser\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TertiarySchoolMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
       $company = company();

        if (!$company || $company->school_type !== 'tertiary') {
            abort(403, 'Access denied: only tertiary schools are allowed.');
        }
        return $next($request);
    }
}
