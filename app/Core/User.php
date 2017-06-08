<?php
namespace App\Core;

use App\Exceptions\InvalidUserInputException;
use DB;
use Mail;
use Firebase\JWT\JWT;
use App\Mail\AccountActivation;

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
     * Inscription de l'utilisateur
     * @param  int    $sisID                ID du SIS
     * @param  string $email                Adresse e-mail du sapeur
     * @param  string $password             Mot de passe
     * @param  string $passwordConfirmation Confirmation du mot de passe
     * @return bool
     */
    public function signup(int $sisID, string $email, string $password, string $passwordConfirmation): bool{
        if(ActivityLog::limitIsReached('create-account-fail')){
            throw new InvalidUserInputException(trans('global.quota_exceeded'));
        }
        else if(!$this->isValidEmail($email)){
            throw new InvalidUserInputException(trans('account.invalid_email'));
        }
        else if($password !== $passwordConfirmation){
            throw new InvalidUserInputException(trans('account.invalid_password'));
        }

        $sapeur = DB::connection('mysql_managed')->select('
                        SELECT SAP_ID, SAP_Prenom, SAP_Nom, SAP_Email
                          FROM Sapeur
                         WHERE SAP_Email = ?
                           AND SAP_Actif = 1
                           AND (SELECT COUNT(USER_ID)
                                  FROM Users
                                 WHERE Users.SAP_ID = Sapeur.SAP_ID) = 0',
                        [$email]);

        // Vérifie qu'un sapeur a cette adresse e-mail + que le sapeur n'a pas encore de compte
        if(!isset($sapeur[0])){
            ActivityLog::add('create-account-fail', 'SIS ID : '.$sisID.', E-mail : '.$email);
            throw new InvalidUserInputException(trans('account.creation_error_email'));
        }

        $activationKey = md5(str_random(256));
        DB::connection('mysql_managed')->update('
            INSERT INTO Users (
                SAP_ID,
                USER_Pass,
                USER_CpteStat,
                USER_GestTache,
                USER_VisuDocument,
                USER_VisuEffectif,
                USER_VisuTouteTache,
                USER_VisuInfoSap,
                USER_GestUser,
                USER_KeyAct,
                USER_Special,
                USER_AjoutTache,
                USER_VisuMateriel,
                USER_VisuIntervention,
                USER_VisuAgenda,
                USER_VisuExercice,
                USER_VisuCMedicaux,
                USER_PrioritaireTache,
                USER_VisuEntreprise,
                USER_VisuDecompte,
                USER_GestDecompte
            )
            VALUES (
                ?,
                ?,
                0,
                0,
                1,
                1,
                0,
                0,
                0,
                ?,
                0,0,0,0,0,0,0,0,0,0,0
            )',
            [$sapeur[0]->SAP_ID, md5($password), $activationKey]);

        Mail::to($sapeur[0]->SAP_Email)->send(new AccountActivation($sisID, $sapeur[0]->SAP_Email, $activationKey));
        ActivityLog::add('create-account-success', 'SIS ID : '.$sisID.', E-mail : '.$sapeur[0]->SAP_Email);

        return true;
    }

    /**
     * Activation du compte
     * @param  int    $sisID ID du SIS
     * @param  string $email Adresse e-mail du sapeur
     * @param  string $key   Clé d'activation
     * @return bool
     */
    public function activate(int $sisID, string $email, string $key): bool{
        if(ActivityLog::limitIsReached('activate-account-fail')){
            throw new InvalidUserInputException(trans('global.quota_exceeded'));
        }

        $user = DB::connection('mysql_managed')->select('
                    SELECT Users.USER_ID
                      FROM Users
                     INNER JOIN Sapeur ON Users.SAP_ID = Sapeur.SAP_ID
                     WHERE USER_KeyAct = ?
                       AND SAP_Email = ?
                       AND SAP_Actif = 1',
                    [$key, $email]);

        if(!isset($user[0])){
            ActivityLog::add('activate-account-fail', 'SIS ID : '.$sisID.', E-mail : '.$email);
            return false;
        }

        DB::connection('mysql_managed')->update('
            UPDATE Users
               SET USER_CpteStat = 1
             WHERE USER_ID = ?',
            [$user[0]->USER_ID]);

        ActivityLog::add('activate-account-success', 'SIS ID : '.$sisID.', E-mail : '.$email);

        return true;
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
	 * @param string $email
	 * @return bool si l'adresse e-mail passée en paramètre est valide
	 */
	private function isValidEmail(string $email): bool{
		return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
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
    public static function isValid(int $id, int $iat): bool {
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
     * Détermine si l'utilisateur a le rôle passé en paramètre
     * @param  int    $id
     * @param  string $role
     * @return bool
     */
    public static function hasRole(int $id, string $role): bool {
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
            'decompte_all' => 'USER_GestDecompte'
        ];

        if(!isset($roleColumn[$role])){
            throw new \Exception('invalid role');
        }

        $result =  DB::connection('mysql_managed')->select('
                    SELECT COUNT(*) AS ROLE_ACCESS
                    FROM Users
                    WHERE USER_ID = ?
                      AND '.$roleColumn[$role].' = 1',
                    [$id]);

        return $result[0]->ROLE_ACCESS == 1;
    }

    /**
     * Détermine si le sapeur a les accès pour visualiser le détail du sapeur
     * @param  int  $id
     * @return bool
     */
    public function canViewSapeur(int $id): bool {
        $res = DB::connection('mysql_managed')->select('
                SELECT SAP_ID, USER_VisuInfoSap
                  FROM Users
                 WHERE USER_ID = ?',
                [$this->id]);

        if(!isset($res[0])){
            throw new InvalidUserInputException('invalid user id');
        }

        return $res[0]->SAP_ID == $id || $res[0]->USER_VisuInfoSap == 1;
    }
}
