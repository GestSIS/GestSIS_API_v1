<?php
namespace App\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Exceptions\InvalidUserInputException;

use App\Core\User;
use App\Core\Sis;

/**
 * API pour la gestion des SIS
 */
class SisApiController extends ApiController {

    public function index(Request $request){
        $availableFilters = [
          'actif', 'mobile'
        ];

        $sis = new Sis();

        return response()->json([
                'data' => $sis->getList($request->only($availableFilters))
        ]);
    }

    public function localities(Request $resquest){
        return response()->json([
                'data' => Sis::getLocalities()
        ]);
    }
}
