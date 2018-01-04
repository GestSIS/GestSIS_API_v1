<?php
namespace App\Core;

use App\Exceptions\InvalidUserInputException;
use DB;
use Log;
use Firebase\JWT\JWT;

class Auth {
    const TOKEN_DURATION = 60*60*24*30; // 30 jours
    const TOKEN_TYPE = 'Bearer';

    private static $user,
                   $apiKey;

    public static function login(string $grantType, array $credentials): bool{
        if(ActivityLog::limitIsReached('login-fail')){
            throw new InvalidUserInputException(trans('global.quota_exceeded'));
        }

        switch($grantType){
            case 'password':
                Sis::retrieveSettings($credentials['sis_id']);

                if(!isset($credentials['username']) || !isset($credentials['password'])){
                    throw new InvalidUserInputException(trans('account.invalid_credentials'));
                }

                $user = DB::connection('mysql_managed')->select('
        					SELECT Users.USER_ID, USER_Login, USER_Pass, USER_CpteStat
        				      FROM Users
                              LEFT OUTER JOIN Sapeur ON Users.SAP_ID = Sapeur.SAP_ID
        					 WHERE ((Users.SAP_ID IS NULL OR Users.SAP_ID = 0)
                                    AND USER_Login = ?)
                                OR ((Users.SAP_ID IS NOT NULL AND Users.SAP_ID <> 0)
                                    AND SAP_Email = ?)',
        				    [$credentials['username'], $credentials['username']]);

        		if(isset($user[0]) && md5($credentials['password']) === $user[0]->USER_Pass){
                    if($user[0]->USER_CpteStat == 0){
                        throw new InvalidUserInputException(trans('account.need_activation'));
                    }

                    self::$user = new User($user[0]->USER_ID);
                    ActivityLog::add('login-success', 'SIS ID : '.$credentials['sis_id'].', Username : '.$credentials['username']);
                    return true;
        		}
        		else{
                    ActivityLog::add('login-fail', 'SIS ID : '.$credentials['sis_id'].', Username : '.$credentials['username']);
                    return false;
        		}
                break;

            case 'client_credentials':
                if(!isset($credentials['client_id']) || !isset($credentials['client_secret'])){
                    throw new InvalidUserInputException(trans('account.invalid_credentials'));
                }

                $apiKey = DB::connection('mysql_dba')->select('
                            SELECT APC_ID, SIS_ID, APC_Client_ID, APC_Client_Secret
                              FROM API_Cle
                             WHERE APC_Client_ID = ?
                               AND APC_Date_Revocation IS NULL',
                           [$credentials['client_id']]);

                if(isset($apiKey[0]) && $credentials['client_secret'] === decrypt($apiKey[0]->APC_Client_Secret)){
                    Sis::retrieveSettings($apiKey[0]->SIS_ID);
                    self::$apiKey = new ApiKey($apiKey[0]->APC_ID);
                    ActivityLog::add('login-success', 'Client ID : '.$credentials['client_id']);
                    return true;
                }
                else{
                    ActivityLog::add('login-fail', 'Client ID : '.$credentials['client_id']);
                    return false;
                }
                break;

            default:
                Log::error('Invalid grant type : '.$grantType);
                return false;
                break;
        }
    }

    public static function authenticate($jwt): bool{
        $payload = JWT::decode($jwt, base64_decode(substr(config('app.key'),7)), array('HS256'));
        Sis::retrieveSettings($payload->sis_id);

        if(isset($payload->uid)){
            self::$user = new User($payload->uid);
            return self::$user->isValid();
        }
        elseif(isset($payload->ak_id)){
            self::$apiKey = new ApiKey($payload->ak_id);
            return self::$apiKey->isValid();
        }
        else{
            return false;
        }

    }

    /**
     * Retourne un token d'accès au format JWT (données inclues : (user id ou api key id) et sis id)
     * @return mixed
     */
    public static function getAccessToken(){
		$token = [
			'iss' => config('app.url'),
			'iat' => time(),
			'exp' => time() + self::TOKEN_DURATION, // 30 jours
			'scopes' => ['all'],
			'sis_id' => config('sis.id')
		];

        if(isset(self::$user)){
            $token['uid'] = self::$user->getId();
        }
        elseif(isset(self::$apiKey)){
            $token['ak_id'] = self::$apiKey->getId();
        }

		return JWT::encode($token, base64_decode(substr(config('app.key'), 7)));
	}

    /**
     * Détermine si l'utilisateur ou la clé API a le rôle passé en paramètre
     * @param  string $role
     * @return bool
     */
    public static function hasRole(string $role): bool {
        $hasRole = false;

        if(isset(self::$user)){
            // Conversion du rôle
            $roleColumn = [
                'tache_all' => 'USER_GestTache',
                'document_read' => 'USER_VisuDocument',
                'effectif_read' => 'USER_VisuEffectif',
                // USER_VisuTouteTache => Compris dans tache_all
                'effectif_all' => 'USER_VisuInfoSap',
                'user_all' => 'USER_GestUser',
                'tache_add' => 'USER_AjoutTache',
                'materiel_read' => 'USER_VisuMateriel',
                'intervention_read' => 'USER_VisuIntervention',
                'agenda_read' => 'USER_VisuAgenda',
                'exercice_read' => 'USER_VisuExercice',
                'ctrl_med_read' => 'USER_VisuCMedicaux',
                'tache_prioritaire_all' => 'USER_PrioritaireTache',
                'entreprise_read' => 'USER_VisuEntreprise',
                'decompte_read' => 'USER_VisuDecompte',
                'decompte_all' => 'USER_GestDecompte',
                'transfert_all' => 'USER_GestTranfertApp'
            ];

            if(!isset($roleColumn[$role])){
                Log::error('Invalid role code : '.$role);
                return false;
            }

            $result =  DB::connection('mysql_managed')->select('
                        SELECT COUNT(*) AS ACCES
                        FROM Users
                        WHERE USER_ID = ?
                          AND '.$roleColumn[$role].' = 1',
                        [self::$user->getId()]);

            $hasRole = $result[0]->ACCES == 1;
        }
        elseif(isset(self::$apiKey)) {
            $result = DB::connection('mysql_dba')->select('
                        SELECT COUNT(*) AS ACCES
                          FROM API_Cle_Role
                         INNER JOIN API_Role ON API_Cle_Role.APR_ID = API_Role.APR_ID
                         WHERE APR_Code = ?
                           AND APC_ID = ?',
                       [$role, self::$apiKey->getId()]);

            $hasRole = $result[0]->ACCES == 1;
        }
        else {
            Log::error('Not authenticated');
            return false;
        }

        if(!$hasRole){
            $message = 'Unauthorized role : '.$role.', SIS ID : '.config('sis.id');
            if(isset(self::$user)){
                $message .= ', User ID : '.self::$user->getId();
            }
            elseif(isset(self::$apiKey)){
                $message .= ', API key ID : '.self::$apiKey->getId();
            }

            Log::error($message);
        }

        return $hasRole;
    }

    public static function getCurrentUser(){
        return self::$user;
    }

    public static function getCurrentApiKey(){
        return self::$apiKey;
    }
}
