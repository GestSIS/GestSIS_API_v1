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
        return response()->json([
                'data' => Sis::getList()
        ]);
    }

    public function localities(Request $resquest,int $id){
        return response()->json([
                'data' => Sis::getLocalities($id)
        ]);
    }
}
