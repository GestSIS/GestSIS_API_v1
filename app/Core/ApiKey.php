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

    /**
     * @param string $role
     * @return bool Vrai si la clé API a le rôle passé en paramètre
     */
    public function hasRole(string $role): bool {
        $result = DB::connection('mysql_dba')->select('
                    SELECT COUNT(*) AS ACCES
                      FROM API_Cle_Role
                     INNER JOIN API_Role ON API_Cle_Role.APR_ID = API_Role.APR_ID
                     WHERE APR_Code = ?
                       AND APC_ID = ?',
                   [$role, $this->id]);

        return $result[0]->ACCES == 1;
    }

    /**
     * @return array Liste des rôles de la clé API
     */
    public function getRoles(): array {
        $result = DB::connection('mysql_dba')->select('
                    SELECT APR_Code
                      FROM API_Cle_Role
                     INNER JOIN API_Role ON API_Cle_Role.APR_ID = API_Role.APR_ID
                     WHERE APC_ID = ?',
                   [$this->id]);
        $grantedRoles = [];

        foreach($result as $role){
            $grantedRoles[] = $role->APR_Code;
        }

        return $grantedRoles;
    }

    public function getId(){
        return $this->id;
    }

}
