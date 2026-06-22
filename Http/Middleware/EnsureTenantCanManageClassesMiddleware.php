<?php
namespace Modules\Schoolviser\Http\Middleware;

use Closure;

class EnsureTenantCanManageClassesMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Only allow tenants whose school_type is "primary" or "secondary"
     * to access routes for managing/creating classes (e.g. P2, P3).
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        // Retrieve school_type from tenant settings
        $schoolType = getTenantSetting('school_type', null, 'schoolviser_setup');


        // Only allow primary or secondary schools
        if (!in_array(strtolower($schoolType), ['primary', 'secondary'])) {
            abort(403, 'Your school type does not allow class management.');
        }

        return $next($request);
    }
}