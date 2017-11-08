<?php
namespace App\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

use App\Core\Telephone;

/**
 * API pour la gestion des exercices
 */
class TelephoneApiController extends ApiController {

    public function index(Request $request){
        return response()->json([
              'data' => Telephone::getList()
        ]);
    }
}
