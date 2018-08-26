<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exceptions\InvalidUserInputException;

use App\Core\Sapeur;
use App\Core\Sis;

/**
 * Controlleur pour la gestion des sapeurs
 */
class SapeurController extends Controller {

    public function showIndex(Request $request){
        return view('sapeur-index', [
            'title' => 'Sapeurs'
        ]);
    }
    
}