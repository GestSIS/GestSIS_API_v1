<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exceptions\InvalidUserInputException;

use App\Core\User;
use App\Core\Sis;

/**
 * Controlleur pour la gestion du compte
 */
class UserController extends Controller {

    public function activate(Request $request){
        $user = new User();

        $sisID = $request->input('sis_id');
        $email = base64_decode($request->input('email', ''));
        $key = base64_decode($request->input('key', ''));

        Sis::retrieveSettings($sisID);

        if($user->activate($sisID, $email, $key)){
            $message = 'account.activation_success';
        }
        else{
            $message = 'account.activation_error';
        }

        return view('account-activation', [
                'message' => $message
        ]);
    }
}
