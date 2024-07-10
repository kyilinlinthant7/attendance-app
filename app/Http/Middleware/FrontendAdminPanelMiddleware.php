<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class FrontendAdminPanelMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Custom authentication logic using 'admins' table
        if ($request->session()->has('admin_id')) {
            $admin = DB::table('login_users')->where('id', $request->session()->get('admin_id'))->first();

            if ($admin) {
                // If admin is found, allow the request
                return $next($request);
            }
        }

        // Redirect to a specific login page if not authenticated
        return redirect('/leader-login');
    }
}

