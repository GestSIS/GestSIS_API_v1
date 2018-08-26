<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exceptions\InvalidUserInputException;

use App\Core\User;
use App\Core\Auth;
use App\Core\Sis;

/**
 * Controlleur pour la gestion du compte
 */
class UserController extends Controller {

    public function showConnectionForm(Request $request){
        return view('connection', [
            'title' => 'Connexion',
            'full_page' => true, // Sans menu, ni sidebar
            'body_class' => 'login-page',
            'sis_list' => (new Sis())->getList(['actif' => true])
        ]);
    }

    public function login(Request $request){
        if(Auth::login('password', $request->only('username', 'password', 'sis_id'))){
            $request->session()->put('sis_id', config('sis.id'));
            $request->session()->put('uid', Auth::getCurrentUser()->getId());
            $request->session()->put('login_date', time());
            return response()->json([
                    'success' => true,
                    'redirect' => route('user.dashboard')
            ]);
        }
        else{
			return response()->json([
                    'error' => 'Données d\'identification invalides'
            ], 401);
		}
    }

    public function showDashboard(Request $request){
        return view('dashboard', [
            'title' => 'Tableau de bord'
        ]);
    }

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
