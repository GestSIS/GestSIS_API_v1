<?php
namespace App\Core;

use Request;
use DB;

class Vehicule {
  /**
   * Récupération des véhicules
   * @return liste des véhicules
   */
   static public function getList(){
     $vehicules = DB::connection('mysql_managed')->select('
                   SELECT VHCI_ID,
                        VHCI_Designation,
                        VHCI_Tri
                   FROM
                        VhcIntervention
                   ORDER BY VhcIntervention.VHCI_Tri ASC');

     return array_map(function($vehicule) {
         return [
             'id' => $vehicule->VHCI_ID,
             'nom' => $vehicule->VHCI_Designation,
             'tri' => $vehicule->VHCI_Tri
         ];
     }, $vehicules);
   }

}
