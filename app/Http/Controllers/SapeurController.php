<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exceptions\InvalidUserInputException;

use App\Core\Sapeur;
use App\Core\Sis;
use App\Core\BaseData;

/**
 * Controlleur pour la gestion des sapeurs
 */
class SapeurController extends Controller {

    public function showIndex(Request $request){
        return view('sapeur-index', [
            'title' => 'Sapeurs'
        ]);
    }

    public function showDetails(Request $request, $sapId = null){
        $sapeur = new Sapeur();
        $filters = $request->only('actif');
        $sapeursList = $sapeur->getList(null, null, 'nom_prenom', false, $filters);

        if(!empty($sapId)){
            $sapeur->setID($sapId);
            $details = $this->details($sapeur);
        }
        else if(isset($sapeursList['data'][0])) {
            $sapeur->setID($sapeursList['data'][0]['id']);
            $details = $this->details($sapeur);
        }
        else{
            $details = [];
        }

        return view('sapeur-index', [
            'title' => 'Sapeurs',
            'sapeurs_list' => $sapeursList['data'],
            'filters' => $filters,
            'sap_details' => $details,
            'civilites' => Sapeur::getCivilites(),
            'permis' => Sapeur::getPermisList(),
            'cours_list' => BaseData::getCours(),
            'grade_list' => BaseData::getGrade(),
            'fonction_list' => BaseData::getFonction()
        ]);
    }

    private function details($sapeur){
      return [
          'sapeur' => $sapeur->getDetails(),
          'mutations' => $sapeur->getMutations(),
          'fonctions' => $sapeur->getFonctions(),
          'groupes' => $sapeur->getGroupes(),
          'cours' => $sapeur->getCours(),
          'promotions' => $sapeur->getPromotions(),
          'ctrl_med' => $sapeur->getControlesMedicaux(),
          'exercices' => $sapeur->getExercices(),
          'permis' => $sapeur->getPermis()
      ];
    }
}
