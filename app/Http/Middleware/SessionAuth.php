<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use App\Core\Auth;
use Log;

class SessionAuth {

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
            if($request->session()->has('uid') && Auth::authenticateSession($request->session()->get('sis_id'), $request->session()->get('uid'))){
                $guest = false;
            }
            elseif(!empty($request->cookie('stay_connected')) && Auth::authenticate($request->cookie('stay_connected'))){
                $guest = false;
            }
        }
        catch(\Exception $e){
            Log::error('Error during session authentication : '.$e->getMessage());
        }

        if($guest){
            if($request->ajax()){
                return response()->json([
                    'error' => 'not authenticated'
                ], 401);
            }
            else{
                return redirect()->route('user.connection');
            }            
        }
        else{
            view()->share('user_details', Auth::getCurrentUser()->getDetails());
        }

        return $next($request);
    }

}
