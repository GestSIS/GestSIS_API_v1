<?php
namespace App\Core;

use DB;

/**
 * Classe représentant un groupe
 */
class Groupe {

    /**
     * Récupération des groupes
     * @return liste des groupes
     */
     static public function getList(): array {
         $groupes = DB::connection('mysql_managed')->select('
                         SELECT GRP_ID,
                                GRP_Pere,
                                GRP_Type,
                                GRP_No,
                                GRP_Designation,
                                GRP_Info,
                                GRP_Tri,
                                GRP_Fils,
                                GRP_Prefix
                           FROM Groupe
                          ORDER BY GRP_Tri ASC');

          return array_map(function($groupe) {
              return [
                  'id' => $groupe->GRP_ID,
                  'id_pere' => $groupe->GRP_Pere,
                  'type' => $groupe->GRP_Type,
                  'numero' => $groupe->GRP_No,
                  'designation' => $groupe->GRP_Designation,
                  'info' => $groupe->GRP_Info,
                  'tri' => $groupe->GRP_Tri,
                  'fils' => array_map('intval', explode(',', $groupe->GRP_Fils)),
                  'prefixe' => $groupe->GRP_Prefix
              ];
          }, $groupes);
     }

}
