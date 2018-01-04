<?php
namespace App\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Exceptions\InvalidUserInputException;

use App\Core\Auth;
use App\Core\Sapeur;

/**
 * API pour la gestion des sapeurs
 */
class SapeurApiController extends ApiController {

    public function index(Request $request){
        $start = $request->input('start');
        $limit = $request->input('limit');
        $order = $request->input('order', '');
        $reverseSort = $request->input('reverse', false) == '1';
        $availableFilters = [
            'grp_id', 'cou_id', 'com_id', 'fon_id', 'civ_id', 'annee_inco', 'annee_sortie',
            'annee_naiss_de', 'annee_naiss_a', 'porteur', 'permis_c1', 'permis_b',
            'actif', 'politique', 'effectif_en'
        ];

        $sapeur = new Sapeur();

		$sapeurs = $sapeur->getList($start, $limit, $order, $reverseSort, $request->only($availableFilters));

        return response()->json($sapeurs);
    }

    public function show(Request $request, $id){
        $sapeur = new Sapeur($id);

        if(!Auth::getCurrentUser()->canViewSapeur($id)){
            throw new InvalidUserInputException('not authorized');
        }

        return response()->json([
            'sapeur' => $sapeur->getDetails(),
            'mutations' => $sapeur->getMutations(),
            'fonctions' => $sapeur->getFonctions(),
            'groupes' => $sapeur->getGroupes(),
            'cours' => $sapeur->getCours(),
            'promotions' => $sapeur->getPromotions(),
            'ctrl_med' => $sapeur->getControlesMedicaux(),
            'exercices' => $sapeur->getExercices(),
            'interventions' => $sapeur->getInterventions()
        ]);
    }
}
