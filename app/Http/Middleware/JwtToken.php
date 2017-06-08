<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use App\Exceptions\ApiException;
use App\Core\User;
use App\Core\Sis;

class JwtToken {

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

            if(!empty($jwt)){
                $payload = User::decodeAccessToken($jwt);
                Sis::retrieveSettings($payload->sis_id);

                if(User::isValid($payload->uid, $payload->iat)){
                    $request->attributes->add(['uid' => $payload->uid]);
                    $request->attributes->add(['sis_id' => $payload->sis_id]);
                    $guest = false;
                }
            }
        }
        catch(\Exception $e){ }

        $request->attributes->add(['guest' => $guest]);

        return $next($request);
    }
}
