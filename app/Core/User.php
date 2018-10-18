<?php
namespace App\Core;

use App\Exceptions\InvalidUserInputException;
use DB;
use Mail;
use Log;
use App\Mail\AccountActivation;

class User {
    private $id;

    // Role code => Role db column name
    private $rolesTranslations = [
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
        'transfert_all' => 'USER_GestTranfertApp',
        'presence_exe_all' => 'USER_GestPresenceExeApp',
        'rapport_inter_all' => 'USER_GestRapportInterApp'
    ];

	public function __construct(int $id = null){
		$this->id = $id;
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

    public function sendResetPasswordEmail(int $sisID, string $email){
		// Max 20 tentatives erronées par jour
		if(ActivityLog::limitIsReached('forgot-password')){
			throw new InvalidUserInputException(trans('global.quota_exceeded'));
		}

		if(filter_var($email,FILTER_VALIDATE_EMAIL) === false){
			throw new InvalidUserInputException(trans('account.invalid_email'));
		}

		ActivityLog::add('forgot-password', 'SIS ID : '.$sisID.', E-mail : '.$email);

		$user = DB::select('
                      SELECT Users.USER_ID
                        FROM Users
                       INNER JOIN Sapeur ON Users.SAP_ID = Sapeur.SAP_ID
                       WHERE SAP_Email = ?
                         AND SAP_Actif = 1',
					[$email]);

        if(!isset($user[0])){
			return false;
		}

		$resetPasswordToken = Hash::make(str_random(32));

		DB::insert('
                INSERT INTO JETON_RESET_MP (
                    JRP_VALEUR,
                    JRP_DATE_CREATION,
                    JRP_UTI_FK,
                    JRP_STATUT
                    )
                VALUES (
                    ?,
                    NOW(),
                    ?,
                    1
                )',
				array($resetPasswordToken, $user[0]->UTI_PK));

		Mail::to($user[0]->UTI_EMAIL)->send(new ResetPassword($resetPasswordToken, $user[0]->UTI_EMAIL));

		return true;
    }

    /**
     * @return mixed Détails du user connecté
     */
    public function getDetails(){
        $user = DB::connection('mysql_managed')->select('
                    SELECT Users.USER_ID, Users.USER_Login, SAP_Nom, SAP_Prenom, SAP_Email, Sapeur.SAP_ID
                      FROM Users
                      LEFT OUTER JOIN Sapeur ON Users.SAP_ID = Sapeur.SAP_ID
                      LEFT OUTER JOIN Civilite ON Sapeur.CIV_ID = Civilite.CIV_ID
                     WHERE Users.USER_ID = ?',
                    [$this->id]);
        return [
            'id' => $user[0]->USER_ID,
            'nom_utilisateur' => $user[0]->USER_Login,
            'nom' => $user[0]->SAP_Nom,
            'prenom' => $user[0]->SAP_Prenom,
            'email' => $user[0]->SAP_Email,
            'photo' => !is_null($user[0]->SAP_ID) ? 'http://'.config('sis.url').'/photos/sap_id_'.$user[0]->SAP_ID.'.jpg' : null
        ];
    }

    /**
	 * @param string $email
	 * @return bool si l'adresse e-mail passée en paramètre est valide
	 */
	private function isValidEmail(string $email): bool{
		return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
	}

    /**
     * Détermine si le user est valide
     * @return bool
     */
    public function isValid(): bool {
        // Vérification si le user existe et qu'il est actif
        $result =  DB::connection('mysql_managed')->select('
                    SELECT COUNT(*) AS UTI_EXIST
                    FROM Users
                    WHERE USER_ID = ?
                      AND USER_CpteStat = 1',
                    [$this->id]);

        return $result[0]->UTI_EXIST == 1;
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

    /**
     * @param string $role
     * @return bool Vrai si l'utilisateur a le rôle passé en paramètre
     */
    public function hasRole(string $role): bool {
        if(!isset($this->rolesTranslations[$role])){
            Log::error('Invalid role code : '.$role);
            return false;
        }

        $result =  DB::connection('mysql_managed')->select('
                    SELECT COUNT(*) AS ACCES
                    FROM Users
                    WHERE USER_ID = ?
                      AND '.$this->rolesTranslations[$role].' = 1',
                    [$this->id]);

        return $result[0]->ACCES == 1;
    }

    /**
     * @return array Liste des rôles de l'utilisateur
     */
    public function getRoles(): array {
        $res = DB::connection('mysql_managed')->select('
                SELECT '.implode(', ', array_values($this->rolesTranslations)).'
                  FROM Users
                 WHERE USER_ID = ?',
                [$this->id]);

        $roles = (array) $res[0];
        $grantedRoles = [];
        $flippedRolesTranslations = array_flip($this->rolesTranslations);
        foreach($roles as $role => $granted) {
            if($granted){
                $grantedRoles[] = $flippedRolesTranslations[$role];
            }
        }

        return $grantedRoles;
    }

    public function getId(){
        return $this->id;
    }
}
