<?php
namespace App\Core;

use DB;

class Telephone {
  /**
   * Récupération des téléphones
   * @return liste des téléphones
   */
   static public function getList(): array {
       $telephones = DB::connection('mysql_managed')->select('
                       SELECT TEL_ID,
                              TEL_Numero,
                              TEL_Designation,
                              TEL_Tri
                         FROM Telephone
                        ORDER BY TEL_Tri ASC,
                                 TEL_Designation ASC');

        return array_map(function($telephone) {
            return [
                'id' => $telephone->TEL_ID,
                'numero' => $telephone->TEL_Numero,
                'nom' => $telephone->TEL_Designation,
                'tri' => $telephone->TEL_Tri
            ];
        }, $telephones);
   }

}
