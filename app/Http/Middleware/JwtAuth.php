<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use App\Core\Auth;
use Log;

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
        $guest = true;

        try {
            $jwt = $request->bearerToken();

            if(Auth::authenticate($jwt)){
                $guest = false;
            }
        }
        catch(\Exception $e){
            Log::error('Error during JWT authentication : '.$e->getMessage());
        }

        if($guest){
            return response()->json([
                'error' => 'Invalid token'
            ], 401);
        }

        return $next($request);
    }

}
