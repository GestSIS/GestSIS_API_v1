<?php
namespace App\Core;

use App\Exceptions\InvalidUserInputException;
use DB;

/**
 * Classe représentant un SIS
 */
class Sis {

    /**
     * @return mixed Liste des SIS
     */
    public function getList(){
        $sis = DB::connection('mysql_dba')->select('
                SELECT SIS_ID,
                       SIS_NOM,
                       SIS_Abr,
                       SIS_Actif,
                       SIS_URL
                  FROM SIS
                  ORDER BY SIS_NOM ASC');
       return array_map(function($sis) {
           return [
               'id' => $sis->SIS_ID,
               'nom' => $sis->SIS_NOM,
               'abr' => $sis->SIS_Abr,
               'actif' => $sis->SIS_Actif,
               'url' => $sis->SIS_URL
           ];
       }, $sis);
    }

    /**
     * Paramètre la connexion à la base de données du SIS rattaché
     * @param int $sisID
     */
    public static function retrieveSettings(int $sisID){
        $res = DB::select('
                SELECT BDO_Host, BDO_Port, BDO_User, BDO_PWD, BDO_Nom,
                       BDO_Charset, BDO_Collation, SIS_NOM, SIS_Abr, SIS_Actif, SIS_URL
                  FROM SIS
                 INNER JOIN Base_Donnees ON SIS.BDO_ID = Base_Donnees.BDO_ID
                 WHERE SIS_ID = ?
             ', [$sisID]);

        if(count($res) == 1){
            config([
                'database.connections.mysql_managed.host' => $res[0]->BDO_Host,
                'database.connections.mysql_managed.port' => $res[0]->BDO_Port,
                'database.connections.mysql_managed.database' => $res[0]->BDO_Nom,
                'database.connections.mysql_managed.username' => decrypt($res[0]->BDO_User),
                'database.connections.mysql_managed.password' => decrypt($res[0]->BDO_PWD),
                'database.connections.mysql_managed.charset' => $res[0]->BDO_Charset,
                'database.connections.mysql_managed.collation' => $res[0]->BDO_Collation,
                'sis.name' => $res[0]->SIS_NOM,
                'sis.abr' => $res[0]->SIS_Abr,
                'sis.actif' => $res[0]->SIS_Actif,
                'sis.url' => $res[0]->SIS_URL
            ]);
            DB::connection('mysql_managed')->reconnect();
        }
        else{
            throw new InvalidUserInputException('invalid sis id');
        }
    }

    public static function getLocalities(int $sisID){
      $localities = DB::connection('mysql_dba')->select('
                        SELECT localite.LOC_ID, LOC_NPA, LOC_Designation
                        FROM Localite
                        INNER JOIN localite_sis ON localite_sis.loc_id = localite.loc_id
                        WHERE SIS_No= ?
                        ORDER BY LOS_PAR_ID;', [$sisID]);

      return array_map(function($locality) {
          return [
              'id' => $locality->LOC_ID,
              'npa' => $locality->LOC_NPA,
              'nom' => $locality->LOC_Designation
          ];
      }, $localities);
    }
}
