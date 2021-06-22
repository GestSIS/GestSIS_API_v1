<?php

namespace App\Http\Controllers;

use App\Core\Auth;
use Illuminate\Http\Request;

/**
 * API pour la gestion du compte
 */
class AuthApiController extends ApiController
{

    public function getToken(Request $request)
    {
        $grantType = $request->input('grant_type');

        if (Auth::login($grantType, $request->only('username', 'password', 'client_id', 'client_secret', 'sis_id'))) {
            return response()->json([
                'success' => true,
                'access_token' => Auth::getAccessToken(),
                'token_type' => Auth::TOKEN_TYPE,
                'expires_in' => Auth::TOKEN_DURATION
            ]);
        } else {
            return response()->json([
                'error' => trans('account.invalid_credentials')
            ], 401);
        }
    }

    public function refreshToken(Request $request)
    {
        return response()->json([
            'success' => true,
            'access_token' => Auth::getAccessToken(),
            'token_type' => Auth::TOKEN_TYPE,
            'expires_in' => Auth::TOKEN_DURATION
        ]);
    }

    public function encryptParam(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $decrypt = $request->input('decrypt');

        return response()->json([
            'username' => encrypt($username),
            'password' => encrypt($password),
            'decripted_username' => decrypt(encrypt($username)),
            'decripted_password' => decrypt(encrypt($password)),
            'decripted' => decrypt($decrypt),
        ]);
    }
}
