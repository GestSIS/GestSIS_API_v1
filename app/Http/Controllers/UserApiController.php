<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exceptions\InvalidUserInputException;

use App\Core\User;
use App\Core\Sis;

/**
 * API pour la gestion des utilisateurs
 */
class UserApiController extends ApiController {

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
