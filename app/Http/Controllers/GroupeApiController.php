<?php
namespace App\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

use App\Core\Groupe;

/**
 * API pour la gestion des groupes
 */
class GroupeApiController extends ApiController {

    public function index(Request $request){
        return response()->json([
              'data' => Groupe::getList()
        ]);
    }
}
