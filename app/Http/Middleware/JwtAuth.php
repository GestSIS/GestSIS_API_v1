<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use App\Exceptions\ApiException;
use App\Core\Account;

class JwtAuth {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!$request->attributes->has('uid')){
            return response()->json([
                'error' => 'invalid token'
            ], 401);
        }

        return $next($request);
    }

}
