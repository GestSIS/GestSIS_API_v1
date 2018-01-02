<?php

namespace App\Http\Middleware;

use Closure;
use App\Core\Auth;
use Log;

class CheckRole
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::hasRole($role)) {
            return response()->json([
                'error' => 'Not authorized'
            ], 401);
        }

        return $next($request);
    }

}
