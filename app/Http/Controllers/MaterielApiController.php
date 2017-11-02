<?php
namespace App\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

use App\Core\MaterielIntervention;

/**
 * API pour la gestion des exercices
 */
class MaterielApiController extends ApiController {

    public function index(Request $request){
        return response()->json([
              'data' => MaterielIntervention::getList()
        ]);
    }
}
