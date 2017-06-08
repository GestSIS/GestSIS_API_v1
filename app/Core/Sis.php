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
        return DB::select('
                SELECT SIS_PK,
                       SIS_NOM,
                       SIS_URL
                  FROM SIS
                 ORDER BY SIS_NOM ASC');
    }

    /**
     * Paramètre la connexion à la base de données du SIS rattaché
     * @param int $sisID
     */
    public static function retrieveSettings(int $sisID){
        $res = DB::select('
                SELECT BDO_HOST, BDO_PORT, BDO_USER, BDO_PWD, BDO_NOM,
                       BDO_CHARSET, BDO_COLLATION, SIS_NOM, SIS_URL
                  FROM SIS
                 INNER JOIN BASE_DONNEES ON SIS_BDO_FK = BDO_PK
                 WHERE SIS_PK = ?
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
                'sis.url' => $res[0]->SIS_URL
            ]);
            DB::connection('mysql_managed')->reconnect();
        }
        else{
            throw new InvalidUserInputException('invalid sis id');
        }
    }
}
