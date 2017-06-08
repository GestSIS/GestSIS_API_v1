<?php
namespace App\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

use App\Core\Exercice;

/**
 * API pour la gestion des exercices
 */
class ExerciceApiController extends ApiController {

    public function index(Request $request){
        $start = $request->input('start');
        $limit = $request->input('limit');
        $order = $request->input('order', '');
        $reverseSort = $request->input('reverse', false) == '1';
        $availableFilters = [
            'annee', 'loc_id', 'cex_id', 'sap_id'
        ];

        $this->checkForValidLimiters($start, $limit);

        $exercice = new Exercice();

        $exercices = $exercice->getList($start, $limit, $order, $reverseSort, $request->only($availableFilters));

        return response()->json($exercices);
    }

    public function show(Request $request, $id){
        $exercice = new Exercice($id);

        return response()->json([
            'exercice' => $exercice->getDetails(),
            'sapeurs' => $exercice->getSapeursList()
        ]);
    }
}
