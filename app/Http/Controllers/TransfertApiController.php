<?php
namespace App\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

use App\Core\Transfert;

/**
 * API pour la gestion des transferts
 */
class TransfertApiController extends ApiController {

    public function index(Request $request){
        $availableFilters = ['categorie', 'transmis', 'complet'];

        return response()->json([
            'data' => (new Transfert())->getList($request->only($availableFilters))
        ]);
    }

    public function create(Request $request, $slugCat){
        $transfert = new Transfert();
        $transferts = $request->all();

        foreach($transferts as $content){
            $transfert->create($slugCat, $content);
        }

        return response()->json([
            'success' => true,
            'archived' => $transfert->getArchived($slugCat)
        ]);
    }

    // Marque le transfert comme Reçu
    public function received(Request $request, $id){
        $transfert = new Transfert($id);
        $transfert->updateReceiptDate();

        return response()->json([
            'success' => true
        ]);
    }

}
