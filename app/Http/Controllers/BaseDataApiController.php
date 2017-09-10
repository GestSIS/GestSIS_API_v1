<?php
namespace App\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

use App\Core\BaseData;

/**
 * API pour la gestion des exercices
 */
class BaseDataApiController extends ApiController {

    public function statfederal(Request $request){
        return response()->json([
                'data' => BaseData::getFederalStat()
        ]);
    }

    public function typeintervention(Request $request){
        return response()->json([
                'data' => BaseData::getInterventionType()
        ]);
    }

    public function grade(Request $request){
        return response()->json([
                'data' => BaseData::getGrade()
        ]);
    }

    public function cours(Request $request){
        return response()->json([
                'data' => BaseData::getCours()
        ]);
    }

    public function localities(Request $request){
        return response()->json([
                'data' => BaseData::getLocalities()
        ]);
    }

    public function districtlocality(Request $request){
        return response()->json([
                'data' => BaseData::getDistrictLocality()
        ]);
    }

    public function cmedtype(Request $request){
        return response()->json([
                'data' => BaseData::getControlesMedicauxTypes()
        ]);
    }
}
