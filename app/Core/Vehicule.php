<?php
namespace App\Core;

use Request;
use DB;

class Vehicule {
  /**
   * Récupération de materiel
   * @return liste du matériel
   */
   static public function getListe(){
     $vehicule = DB::connection('mysql_managed')->select('
                   SELECT VHCI_ID,
                        VHCI_Designation,
                        VHCI_Tri
                   FROM
                        VhcIntervention
                   ORDER BY MatIntervention.MAT_Tri ASC');

     return array_map(function($vehicule) {
         return [
             'id' => $vehicule->VHCI_ID,
             'nom' => $vehicule->VHCI_Designation,
             'tri' => $vehicule->VHCI_Tri
         ];
     }, $vehicule);
   }

}
