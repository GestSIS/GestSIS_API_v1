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
        $sis = new Sis();

        return response()->json([
                'data' => $this->formatSisIndex($sis->getList())
        ]);
    }

    private function formatSisIndex($sisList){
        return array_map(function($sis) {
            return [
                'id' => $sis->SIS_PK,
                'nom' => $sis->SIS_NOM,
                'url' => $sis->SIS_URL
            ];
        }, $sisList);
    }
}
