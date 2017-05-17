<?php
namespace App\Core;

use Request;
use DB;

class ActivityLog {
    /**
	 * Constructeur, recherche des infos dans la DB
	 * @param string $Code
	 */
	public function __construct($code){

    }

    public static function limitIsReached(string $code){
        // Récupération d'informations sur le quota
		$result =  DB::select('
					SELECT LCA_PK, LCA_LIMITE
					  FROM LOG_CATEGORIE
				     WHERE LCA_CODE = ?',
                    [$code]);

		// Si le quota n'existe pas
		if(!isset($result[0])){
			throw new \Exception('invalid log_categorie code');
		}
        $id = $result[0]->LCA_PK;
        $limit = $result[0]->LCA_LIMITE;

        // Pas de limite
        if(is_null($limit)){
            return false;
        }

        // Récupération du nombre d'action
		$result = DB::select('
					SELECT COUNT(LOG_PK) AS COUNT_USER_ACTIONS
					  FROM LOG
				     WHERE LOG_IP = ? AND
						   LOG_LCA_FK = ? AND
						   TIMESTAMPDIFF(DAY, NOW(), LOG_TIMESTAMP) = 0',
					array(Request::ip(), $id));

		return $result[0]->COUNT_USER_ACTIONS >= $limit;
    }

    public static function add(string $code, string $details){
        DB::insert('
            INSERT INTO LOG (
                LOG_IP,
                LOG_TIMESTAMP,
                LOG_LCA_FK,
                LOG_DETAILS
            )
            VALUES (
                ?,
                NOW(),
                (SELECT LCA_PK FROM LOG_CATEGORIE WHERE LCA_CODE = ?),
                ?
                )',
            [Request::ip(), $code, $details]);
    }
}
