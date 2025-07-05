<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!in_array(Auth::user()?->role, ['super_admin', 'admin_company', 'admin_hrm', 'admin_lms', 'admin_akademik', 'admin_hr'])) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
