<?php
namespace App\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

use App\Core\Intervention;

/**
 * API pour la gestion des exercices
 */
class InterventionApiController extends ApiController {

    public function index(Request $request){
        $start = $request->input('start');
        $limit = $request->input('limit');
        $order = $request->input('order', '');
        $reverseSort = $request->input('reverse', false) == '1';
        $availableFilters = [
            'loc_id', 'annee', 'type_int_id', 'traitement_id', 'stat_fed_id', 'sap_id'
        ];

        $intervention = new Intervention();

        $interventions = $intervention->getList($start, $limit, $order, $reverseSort, $request->only($availableFilters));

        return response()->json($interventions);
    }

    public function show(Request $request, $id){
        $intervention = new Intervention($id);

        return response()->json([
            'intervention' => $intervention->getDetails(),
            'sapeurs' => $intervention->getSapeursList(),
            'groupes' => $intervention->getGroupesList(),
            'vehicules' => $intervention->getVehiculesList(),
            'materiel' => $intervention->getMaterielList()
        ]);
    }

}
