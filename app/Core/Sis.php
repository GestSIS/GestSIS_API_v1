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
                SELECT BDO_HOST, BDO_PORT, BDO_USER, BDO_PWD, BDO_NOM,
                       BDO_CHARSET, BDO_COLLATION, SIS_NOM, SIS_Abr, SIS_Actif, SIS_URL
                  FROM SIS
                 INNER JOIN BASE_DONNEES ON SIS.BDO_ID = BASE_DONNEES.BDO_ID
                 WHERE SIS_ID = ?
             ', [$sisID]);

        if(count($res) == 1){
            config([
                'database.connections.mysql_managed.host' => $res[0]->BDO_HOST,
                'database.connections.mysql_managed.port' => $res[0]->BDO_PORT,
                'database.connections.mysql_managed.database' => $res[0]->BDO_NOM,
                'database.connections.mysql_managed.username' => decrypt($res[0]->BDO_USER),
                'database.connections.mysql_managed.password' => decrypt($res[0]->BDO_PWD),
                'database.connections.mysql_managed.charset' => $res[0]->BDO_CHARSET,
                'database.connections.mysql_managed.collation' => $res[0]->BDO_COLLATION,
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
}
