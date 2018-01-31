<?php
namespace App\Core;

use App\Exceptions\InvalidUserInputException;
use DB;
use Firebase\JWT\JWT;

class ApiKey {
    private $id;

	public function __construct(int $id = null){
		$this->id = $id;
	}

    /**
     * Détermine si la clé est valide
     * @return bool
     */
    public function isValid(): bool {
        $result =  DB::connection('mysql_dba')->select('
                    SELECT COUNT(*) AS KEY_EXIST
                      FROM API_Cle
                     WHERE APC_ID = ?
                       AND APC_Date_Revocation >= NOW()',
                    [$this->id]);

        return $result[0]->KEY_EXIST == 1;
    }

    public function getId(){
        return $this->id;
    }


}
