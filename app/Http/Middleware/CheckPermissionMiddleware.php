<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class CheckPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        if ($user->role_id == 1) {
            return $next($request);
        }

        $permission_ids = RolePermission::where('role_id', $user->role_id)->pluck('permission_id')->toArray();
        $permissions    = Permission::whereIn('id', $permission_ids)->pluck('route')->toArray();

        $current_route = Route::currentRouteName();

        if (str_contains($current_route, 'update')) {
            $edit_route = str_replace('update', 'edit', $current_route);
            $edit_route = str_replace(get_current_user_role() . '.', '', $edit_route);

            if (in_array($edit_route, $permissions)) {
                $update        = str_replace('edit', 'update', $edit_route);
                $permissions[] = $update;
            }
        }

        $role = Role::where('id', $user->role_id)->value('title');

        $prefixedRoutes = array_map(function ($route) use ($role) {
            return "{$role}.{$route}";
        }, $permissions);

        $dashboardRoute = "{$role}.dashboard";
        array_push($prefixedRoutes, $dashboardRoute);

        $route = Route::currentRouteName();

        if (!in_array($route, $prefixedRoutes)) {
            return redirect()->route($dashboardRoute)->with('error', 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}
