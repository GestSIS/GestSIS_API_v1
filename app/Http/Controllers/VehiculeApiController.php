<?php
namespace App\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

use App\Core\Vehicule;

/**
 * API pour la gestion des exercices
 */
class VehiculeApiController extends ApiController {

    public function index(Request $request){
        return response()->json([
              'data' => Vehicule::getList()
        ]);
    }
}
