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
					SELECT LCA_ID, LCA_Limit
					  FROM Log_Cat
				     WHERE LCA_Code = ?',
                    [$code]);

		// Si le quota n'existe pas
		if(!isset($result[0])){
			throw new \Exception('invalid log_categorie code');
		}
        $id = $result[0]->LCA_ID;
        $limit = $result[0]->LCA_Limit;

        // Pas de limite
        if(is_null($limit)){
            return false;
        }

        // Récupération du nombre d'action
		$result = DB::select('
					SELECT COUNT(LOG_ID) AS COUNT_USER_ACTIONS
					  FROM Log
				     WHERE LOG_IP = ? AND
						   LCA_ID = ? AND
						   TIMESTAMPDIFF(DAY, NOW(), LOG_Timestamp) = 0',
					array(Request::ip(), $id));

		return $result[0]->COUNT_USER_ACTIONS >= $limit;
    }

    public static function add(string $code, string $details){
        DB::insert('
            INSERT INTO Log (
                LOG_IP,
                LOG_Timestamp,
                LCA_ID,
                LOG_Details
            )
            VALUES (
                ?,
                NOW(),
                (SELECT LCA_ID FROM Log_Cat WHERE LCA_Code = ?),
                ?
                )',
            [Request::ip(), $code, $details]);
    }
}
