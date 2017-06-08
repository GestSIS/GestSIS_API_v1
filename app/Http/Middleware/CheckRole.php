<?php

namespace App\Http\Middleware;

use Closure;
use App\Core\User;

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
        if (!User::hasRole($request->attributes->get('uid'), $role)) {
            return response()->json([
                'error' => 'not authorized'
            ], 401);
        }

        return $next($request);
    }

}
