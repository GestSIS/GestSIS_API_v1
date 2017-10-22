<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exceptions\InvalidUserInputException;

use App\Core\User;
use App\Core\Sis;

/**
 * API pour la gestion du compte
 */
class UserApiController extends ApiController {

    public function login(Request $request){
        $user = new User();

        $sisID = $request->input('sis_id');
        $username = $request->input('username');
        $password = $request->input('password');

        Sis::retrieveSettings($sisID);
        if($user->login($sisID, $username, $password)){
            $tokenExp = time() + User::TOKEN_DURATION;
            $details = $user->getDetails();

            return response()->json([
                    'success' => true,
                    'token' => $user->getAccessToken($tokenExp),
                    'token_exp' => $tokenExp,
                    'user' => $this->formatUserDetails($details)
            ]);
		}
		else{
			return response()->json([
                    'error' => trans('account.connection_error')
            ], 401);
		}
    }

    public function signup(Request $request){
        $user = new User();

        $sisID = $request->input('sis_id');
        $email = $request->input('email', '');
        $password = $request->input('password', '');
        $passwordConfirm = $request->input('password_confirmation', '');

        Sis::retrieveSettings($sisID);

        if($user->signup($sisID, $email, $password, $passwordConfirm)){
            return response()->json([
                    'success' => true,
                    'message' => trans('account.creation_success')
            ]);
		}
		else{
			return response()->json([
                    'error' => trans('account.creation_error')
            ], 401);
		}
    }

    public function refreshToken(Request $request){
        $account = new User($request->attributes->get('uid'), $request->attributes->get('sis_id'));
        $tokenExp = time() + User::TOKEN_DURATION;

        return response()->json([
                'success' => true,
                'token' => $account->getAccessToken($tokenExp),
                'token_exp' => $tokenExp,
        ]);
    }

    private function formatUserDetails($details){
        return [
            'id' => $details->USER_ID,
            'gender_id' => $details->CIV_ID,
            'gender_label' => $details->CIV_Designation,
            'firstname' => $details->SAP_Prenom,
            'lastname' => $details->SAP_Nom
        ];
    }
}
