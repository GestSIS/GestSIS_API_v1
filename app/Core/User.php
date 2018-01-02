<?php
namespace App\Core;

use App\Exceptions\InvalidUserInputException;
use DB;
use Mail;
use App\Mail\AccountActivation;

class User {
    private $id;

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

    public function getId(){
        return $this->id;
    }
}
