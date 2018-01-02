<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exceptions\InvalidUserInputException;

use App\Core\Auth;
use App\Core\Sis;

/**
 * API pour la gestion du compte
 */
class AuthApiController extends ApiController {

    public function getToken(Request $request){
        $grantType = $request->input('grant_type');

        if(Auth::login($grantType, $request->only('username', 'password', 'client_id', 'client_secret', 'sis_id'))){
            return response()->json([
                    'success' => true,
                    'access_token' => Auth::getAccessToken(),
                    'token_type' => Auth::TOKEN_TYPE,
                    'expires_in' => Auth::TOKEN_DURATION
            ]);
        }
        else{
			return response()->json([
                    'error' => trans('account.invalid_credentials')
            ], 401);
		}
    }

    public function refreshToken(Request $request){
        return response()->json([
                'success' => true,
                'access_token' => Auth::getAccessToken(),
                'token_type' => Auth::TOKEN_TYPE,
                'expires_in' => Auth::TOKEN_DURATION
        ]);
    }
}
