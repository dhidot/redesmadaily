<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Role;
use Illuminate\Http\Request;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, ...$roles)
    {
        $userRole = Role::find(auth()->user()->role_id);
        foreach ($roles as $role) {
            // if ($role === "superadmin" && auth()->user()->isSuperadmin()) return $next($request);
            if ($userRole->name === $role) {
                return $next($request);
            }
        }

        // return abort(403);
        $route  = $userRole->name === 'user' ? 'home.index' : 'dashboard.index';
        return redirect()->route($route)->with('failed', 'Kamu tidak memilik izin untuk mengakses halaman tersebut.');
    }
}
