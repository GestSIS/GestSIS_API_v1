<?php
namespace App\Core;

use Request;
use DB;

class MaterielIntervention {
  /**
   * Récupération de materiel
   * @return liste du matériel
   */
   static public function getList(){
     $materielList = DB::connection('mysql_managed')->select('
                         SELECT MATI_ID,
                                MATI_Designation,
                                MATI_Tri
                           FROM
                                MatIntervention
                           ORDER BY MatIntervention.MATI_Tri ASC');

     return array_map(function($materiel) {
         return [
             'id' => $materiel->MATI_ID,
             'nom' => $materiel->MATI_Designation,
             'tri' => $materiel->MATI_Tri
         ];
     }, $materielList);
   }

}
