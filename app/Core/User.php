<?php
namespace App\Core;

use App\Exceptions\InvalidUserInputException;
use DB;
use Firebase\JWT\JWT;

class User {
    private $id,
            $sisID;

	public function __construct(int $id = null){
		$this->id = $id;
	}

    /**
     * Connexion de l'utilisateur
     * @param  int    $sisID      ID du sis
     * @param  string $username   Username (comptes sans sapeur rattaché) ou adresse email
     * @param  string $password   Mot de passe
     * @return bool
     */
    public function login(int $sisID, string $username, string $password): bool{
        if(strlen($password) == 0 || is_null($password)){
			throw new InvalidUserInputException(trans('account.invalid_password_connect'));
		}
		else if(ActivityLog::limitIsReached('login-fail')){
			throw new InvalidUserInputException(trans('global.quota_exceeded'));
		}

		$user = DB::connection('mysql_managed')->select('
					SELECT Users.USER_ID, USER_Login, USER_Pass, USER_CpteStat
					FROM Users
                    LEFT OUTER JOIN Sapeur ON Users.SAP_ID = Sapeur.SAP_ID
					WHERE ((Users.SAP_ID IS NULL OR Users.SAP_ID = 0)
                            AND USER_Login = ?)
                       OR ((Users.SAP_ID IS NOT NULL AND Users.SAP_ID <> 0)
                           AND SAP_Email = ?)',
				    [$username, $username]);

		if(isset($user[0]) && md5($password) === $user[0]->USER_Pass){
            if($user[0]->USER_CpteStat == 0){
                throw new InvalidUserInputException(trans('account.need_activation'));
            }

			$this->id = $user[0]->USER_ID;
            $this->sisID = $sisID;
            ActivityLog::add('login-success', 'SIS ID : '.$sisID.', Username : '.$username);

			return true;
		}
		else{
			ActivityLog::add('login-fail', 'SIS ID : '.$sisID.', Username : '.$username);
			return false;
		}
    }

    /**
     * @return mixed Détails du user connecté
     */
    public function getDetails(){
        $user = DB::connection('mysql_managed')->select('
                    SELECT Users.USER_ID, SAP_Nom, SAP_Prenom, SAP_Email, Sapeur.CIV_ID, CIV_Designation
                      FROM Users
                      LEFT OUTER JOIN Sapeur ON Users.SAP_ID = Sapeur.SAP_ID
                      LEFT OUTER JOIN Civilite ON Sapeur.CIV_ID = Civilite.CIV_ID
                     WHERE Users.USER_ID = ?',
                    [$this->id]);
        return $user[0];
    }

    /**
     * Retourne un token d'accès au format JWT (données inclues : user id et sis id)
     * @param  int    $expiration
     * @return mixed
     */
    public function getAccessToken(int $expiration){
		$token = [
			'iss' => config('app.url'),
			'iat' => time(),
			'exp' => $expiration, // 30 jours
			'scopes' => ['all'],
			'uid' => $this->id,
            'sis_id' => $this->sisID
		];

		return JWT::encode($token, base64_decode(substr(config('app.key'), 7)));
	}

    /**
     * Décode le JWT passé en paramètre
     * @param  string $jwt
     * @return mixed  Contenu du JWT
     */
	public static function decodeAccessToken(string $jwt){
		return JWT::decode($jwt, base64_decode(substr(config('app.key'),7)), array('HS256'));
	}

    /**
     * Détermine si le user id passé en paramètre est valide
     * @param  int    $id
     * @param  int    $iat
     * @return bool
     */
    public static function isValid(int $id, int $iat): bool{
        // Vérification si le user existe et qu'il est actif
        $result =  DB::connection('mysql_managed')->select('
                    SELECT COUNT(*) AS UTI_EXIST
                    FROM Users
                    WHERE USER_ID = ?
                      AND USER_CpteStat = 1',
                    [$id]);

        return $result[0]->UTI_EXIST == 1;
    }

    /**
     * Paramètre la connexion à la base de données du SIS rattaché
     * @param int $sisID
     */
    public static function setManagedDBConnection(int $sisID){
        $db = DB::select('
                SELECT BDO_HOST, BDO_PORT, BDO_USER, BDO_PWD, BDO_NOM,
                       BDO_CHARSET, BDO_COLLATION
                  FROM SIS
                 INNER JOIN BASE_DONNEES ON SIS_BDO_FK = BDO_PK
                 WHERE SIS_PK = ?
             ', [$sisID]);

        if(count($db) == 1){
            config([
                'database.connections.mysql_managed.host' => $db[0]->BDO_HOST,
                'database.connections.mysql_managed.port' => $db[0]->BDO_PORT,
                'database.connections.mysql_managed.database' => $db[0]->BDO_NOM,
                'database.connections.mysql_managed.username' => decrypt($db[0]->BDO_USER),
                'database.connections.mysql_managed.password' => decrypt($db[0]->BDO_PWD),
                'database.connections.mysql_managed.charset' => $db[0]->BDO_CHARSET,
                'database.connections.mysql_managed.collation' => $db[0]->BDO_COLLATION
            ]);
            DB::connection('mysql_managed')->reconnect();
        }
        else{
            throw new InvalidUserInputException('invalid sis id');
        }
    }

}
