<?php
namespace App\Core;

use App\Exceptions\InvalidUserInputException;
use DB;

/**
 * Classe représentant un sapeur
 */
class Sapeur {
    private $id;

    public function __construct(int $id = null){
        if(!is_null($id)){
            $this->id = $id;
        }
    }

    /**
     * Retourne une liste de sapeurs selon les filtres passés en paramètre
     * @param  int    $start
     * @param  int    $limit
     * @param  string $orderCode
     * @param  bool   $reverseSort
     * @param  array  $filters
     * @return array
     */
    public function getList(int $start = null, int $limit = null, string $orderCode,
                            bool $reverseSort, array $filters): array{

        $filters = array_where($filters, function($value, $key){
            return !is_null($value);
        });

        // Vérification des grp_id
        if(isset($filters['grp_id'])){
            $filters['grp_id'] = explode(',', $filters['grp_id']);
            $filters['grp_id'] = array_where($filters['grp_id'], function($value, $key){
                return ctype_digit($value);
            });
            $filters['grp_id'] = implode(',', $filters['grp_id']);
        }

        $params = $filters;
        unset($params['politique']);
        unset($params['grp_id']);

        if(!is_null($start) && !is_null($limit)){
            $params['start'] = $start;
            $params['limit'] = $limit;
        }

        $orderType = ($reverseSort ? 'DESC' : 'ASC');
        $orders = [
            'nom_prenom' => 'SAP_Nom '.$orderType.', SAP_Prenom '.$orderType,
            'fon_nom_prenom' => 'FON_Tri '.$orderType.', SAP_Nom '.$orderType.', SAP_Prenom '.$orderType,
            'porteur_fon_nom_prenom' => 'SAP_Porteur '.$orderType.', FON_Tri '.$orderType.', SAP_Nom '.$orderType.', SAP_Prenom '.$orderType,
            'permisc1_fon_nom_prenom' => 'SAP_Permis_C1 '.$orderType.', FON_Tri '.$orderType.', SAP_Nom '.$orderType.', SAP_Prenom '.$orderType,
            'grade_nom_prenom' => 'GRA_Tri '.$orderType.', SAP_Nom '.$orderType.', SAP_Prenom '.$orderType,
            'datenaiss_nom_prenom' => 'SAP_DNaissance '.$orderType.', SAP_Nom '.$orderType.', SAP_Prenom '.$orderType,
            'anniv_nom_prenom' => 'SUBSTRING(SAP_DNaissance, 5, 6) '.$orderType.', SAP_Nom '.$orderType.', SAP_Prenom '.$orderType,
            'groupe_fon_nom_prenom' => 'Sapeur.TGrp_No '.$orderType.', FON_Tri '.$orderType.', SAP_Nom '.$orderType.', SAP_Prenom '.$orderType,
            'dateinco' => 'Sapeur.SAP_DInco '.$orderType,
            'datesortie' => 'Sapeur.SAP_DSortie '.$orderType,
            'commune' => 'Commune.COM_Designation '.$orderType,
            'mutinco' => 'SAP_Mutation.SMU_Dinco '.$orderType,
            'mutsortie' => 'SAP_Mutation.SMU_DSortie '.$orderType
        ];

        $orderBy = isset($orders[$orderCode]) ?  $orders[$orderCode] : $orders['fon_nom_prenom'];
        $res = [];

        $sapeurs = DB::connection('mysql_managed')->select('
                    SELECT DISTINCT
                           SQL_CALC_FOUND_ROWS
                           Sapeur.SAP_ID,
                           Sapeur.SAP_Nom,
                           Sapeur.SAP_Prenom,
                           Sapeur.SAP_Porteur,
                           Sapeur.TGRP_No,
                           Sapeur.SAP_TelPriv,
                           Sapeur.SAP_TelPriv_RTA,
                           Sapeur.SAP_TelProf,
                           Sapeur.SAP_TelProf_RTA,
                           Sapeur.SAP_TelNat,
                           Sapeur.SAP_TelNat_RTA,
                           Sapeur.SAP_DNaissance,
                           Sapeur.SAP_EMail,
                           Sapeur.SAP_NoRue,
                           Sapeur.SAP_Rue,
                           Sapeur.SAP_DInco,
                           Sapeur.SAP_DSortie,
                           Localite.LOC_Npa,
                           Localite.LOC_Designation,
                           Civilite.CIV_Designation,
                           Fonction_.FON_Nom,
                           Grade.GRA_Abr,
                           (SELECT GROUP_CONCAT(Groupe.GRP_ID ORDER BY Groupe.GRP_Tri ASC)
                              FROM GrpSap
                             INNER JOIN Groupe ON GrpSap.GRP_ID = Groupe.GRP_ID
                             WHERE GrpSap.SAP_ID = Sapeur.SAP_ID) AS groupes
                      FROM Sapeur
                      LEFT OUTER JOIN Fonction_ ON Sapeur.FON_ID_Princ = Fonction_.FON_ID
                      LEFT OUTER JOIN Grade ON Sapeur.GRA_ID_Actu = Grade.GRA_ID
                      LEFT OUTER JOIN Localite ON Sapeur.LOC_ID = Localite.LOC_ID
                      LEFT OUTER JOIN Commune ON Localite.COM_ID = Commune.COM_ID
                      LEFT OUTER JOIN Civilite ON Sapeur.CIV_ID = Civilite.CIV_ID
                      LEFT OUTER JOIN GrpSap ON GrpSap.SAP_ID = Sapeur.SAP_ID
                      LEFT OUTER JOIN CouSap ON CouSap.SAP_ID = Sapeur.SAP_ID
                      LEFT OUTER JOIN FonSap ON FonSap.SAP_ID = Sapeur.SAP_ID
                     WHERE 1=1
                     '.(isset($filters['grp_id']) ? ' AND GrpSap.GRP_ID IN ('.$filters['grp_id'].') ' : '').'
                     '.(isset($filters['cou_id']) ? ' AND CouSap = :cou_id ' : '') .'
                     '.(isset($filters['com_id']) ? ' AND Localite.COM_ID = :com_id' : '').'
                     '.(isset($filters['fon_id']) ? ' AND FonSap.FON_ID = :fon_id AND FonSap.FON_FIN IS NULL ' : '').'
                     '.(isset($filters['civ_id']) ? ' AND Sapeur.CIV_ID = :civ_id ' : '').'
                     '.(isset($filters['annee_inco']) ? ' AND YEAR(Sapeur.SAP_DInco) = :annee_inco ' : '').'
                     '.(isset($filters['annee_sortie']) ? ' AND YEAR(Sapeur.SAP_DSortie) = :annee_sortie' : '').'
                     '.(isset($filters['annee_naiss_de']) ? ' AND YEAR(Sapeur.SAP_DNaissance) >= :annee_naiss_de' : '').'
                     '.(isset($filters['annee_naiss_a']) ? ' AND YEAR(Sapeur.SAP_DNaissance) <= :annee_naiss_a' : '').'
                     '.(isset($filters['porteur']) ? ' AND Sapeur.SAP_Porteur = :porteur' : '').'
                     '.(isset($filters['actif']) ? ' AND Sapeur.SAP_Actif = :actif' : '').'
                     '.(isset($filters['politique']) && $filters['politique'] == '1' ? ' AND Sapeur.SAP_CAT = 2' : ' AND Sapeur.SAP_CAT = 1').'
                     '.(isset($filters['effectif_en']) ? ' AND :effectif_en BETWEEN SMU_Dinco AND SMU_DSortie' : '').'
                     ORDER BY '.$orderBy.'
                     '.(!is_null($start) && !is_null($limit) ? 'LIMIT :start, :limit' : ''),
                     $params);
        $count = $this->count();

        $res['data'] = array_map(function($sapeur) {
             return [
                 'id' => $sapeur->SAP_ID,
                 'nom' => $sapeur->SAP_Nom,
                 'prenom' => $sapeur->SAP_Prenom,
                 'porteur' => boolval($sapeur->SAP_Porteur),
                 'groupes' => explode(',', $sapeur->groupes),
                 'tel_prive' => $sapeur->SAP_TelPriv,
                 'tel_prive_rta' => boolval($sapeur->SAP_TelPriv_RTA),
                 'tel_prof' => $sapeur->SAP_TelProf,
                 'tel_prof_rta' => boolval($sapeur->SAP_TelProf_RTA),
                 'tel_mobile' => $sapeur->SAP_TelNat,
                 'tel_mobile_rta' => boolval($sapeur->SAP_TelNat_RTA),
                 'date_naissance' => DateHelper::toIso8601($sapeur->SAP_DNaissance),
                 'email' => $sapeur->SAP_EMail,
                 'no_rue' => $sapeur->SAP_NoRue,
                 'rue' => $sapeur->SAP_Rue,
                 'date_inco' => DateHelper::toIso8601($sapeur->SAP_DInco),
                 'date_sortie' => DateHelper::toIso8601($sapeur->SAP_DSortie),
                 'npa' => $sapeur->LOC_Npa,
                 'localite' => $sapeur->LOC_Designation,
                 'civilite' => $sapeur->CIV_Designation,
                 'fonction' => $sapeur->FON_Nom,
                 'grade' => $sapeur->GRA_Abr,
                 'photo' => config('sis.url').'/photos/sap_id_'.$sapeur->SAP_ID.'.jpg'
             ];
        }, $sapeurs);

        // Paging
        if(($start + $limit) >= $count || is_null($start) || is_null($limit)){
            $res['paging'] = ['next' => null];
        }
        else {
            $params = $filters;
            $params['start'] = $start + $limit;
            $params['limit'] = $limit;

            if($orderCode !== ''){
                $params['order'] = $orderCode;
            }

            if($reverseSort){
                $params['reverse'] = '1';
            }

            $res['paging'] = ['next' => route('api.v1.sapeur.index', $params)];
        }

        $res['count'] = $count;

        return $res;
    }

    /**
     * Détail d'un sapeur
     * @return array
     */
    public function getDetails(): array{
        $res = DB::connection('mysql_managed')->select('
                SELECT Sapeur.SAP_ID,
                       Sapeur.SAP_Nom,
                       Sapeur.SAP_Prenom,
                       Sapeur.SAP_Porteur,
                       Sapeur.TGRP_No,
                       Sapeur.SAP_TelPriv,
                       Sapeur.SAP_TelPriv_RTA,
                       Sapeur.SAP_TelProf,
                       Sapeur.SAP_TelProf_RTA,
                       Sapeur.SAP_TelNat,
                       Sapeur.SAP_TelNat_RTA,
                       Sapeur.SAP_DNaissance,
                       Sapeur.SAP_EMail,
                       Sapeur.SAP_NoRue,
                       Sapeur.SAP_Rue,
                       Sapeur.SAP_DInco,
                       Sapeur.SAP_DSortie,
                       Sapeur.SAP_Profession,
                       Sapeur.SAP_Employeur,
                       Sapeur.SAP_NoAVS,
                       Sapeur.SAP_LieuDeTravail,
                       Sapeur.SAP_Actif,
                       Sapeur.SAP_CPTBan,
                       Sapeur.SAP_NoCCP,
                       Sapeur.SAP_IBAN,
                       Sapeur.SAP_IBAN_Statut,
                       Sapeur.SAP_CAT,
                       Sapeur.SAP_Suffixe,
                       Sapeur.SAP_Rem,
                       Localite.LOC_ID,
                       Localite.LOC_Npa,
                       Localite.LOC_Designation,
                       Civilite.CIV_Designation,
                       Civilite.CIV_ID,
                       Fonction_.FON_Nom,
                       Grade.GRA_Abr
                  FROM Sapeur
                  LEFT OUTER JOIN Fonction_ ON Sapeur.FON_ID_Princ = Fonction_.FON_ID
                  LEFT OUTER JOIN Grade ON Sapeur.GRA_ID_Actu = Grade.GRA_ID
                  LEFT OUTER JOIN Localite ON Sapeur.LOC_ID = Localite.LOC_ID
                  LEFT OUTER JOIN Commune ON Localite.COM_ID = Commune.COM_ID
                  LEFT OUTER JOIN Civilite ON Sapeur.CIV_ID = Civilite.CIV_ID
                 WHERE Sapeur.SAP_ID = ?',
             [$this->id]);

        if(isset($res[0])){
            return [
                'id' => $res[0]->SAP_ID,
                'nom' => $res[0]->SAP_Nom,
                'prenom' => $res[0]->SAP_Prenom,
                'porteur' => boolval($res[0]->SAP_Porteur),
                'groupes' => $res[0]->TGRP_No,
                'tel_prive' => $res[0]->SAP_TelPriv,
                'tel_prive_rta' => boolval($res[0]->SAP_TelPriv_RTA),
                'tel_prof' => $res[0]->SAP_TelProf,
                'tel_prof_rta' => boolval($res[0]->SAP_TelProf_RTA),
                'tel_mobile' => $res[0]->SAP_TelNat,
                'tel_mobile_rta' => boolval($res[0]->SAP_TelNat_RTA),
                'date_naissance' => DateHelper::toIso8601($res[0]->SAP_DNaissance),
                'suffixe' => $res[0]->SAP_Suffixe,
                'email' => $res[0]->SAP_EMail,
                'no_rue' => $res[0]->SAP_NoRue,
                'rue' => $res[0]->SAP_Rue,
                'date_inco' => DateHelper::toIso8601($res[0]->SAP_DInco),
                'date_sortie' => DateHelper::toIso8601($res[0]->SAP_DSortie),
                'profession' => $res[0]->SAP_Profession,
                'employeur' => $res[0]->SAP_Employeur,
                'no_avs' => $res[0]->SAP_NoAVS,
                'lieu_travail' => $res[0]->SAP_LieuDeTravail,
                'actif' => boolval($res[0]->SAP_Actif),
                'cpt_bancaire' => $res[0]->SAP_CPTBan,
                'no_ccp' => $res[0]->SAP_NoCCP,
                'iban' => $res[0]->SAP_IBAN,
                'iban_statut' => boolval($res[0]->SAP_IBAN_Statut),
                'politique' => $res[0]->SAP_CAT == 2,
                'npa' => $res[0]->LOC_Npa,
                'localite' => $res[0]->LOC_Designation,
                'localite_id' => $res[0]->LOC_ID,
                'civilite' => $res[0]->CIV_Designation,
                'civilite_id' => $res[0]->CIV_ID,
                'fonction' => $res[0]->FON_Nom,
                'grade' => $res[0]->GRA_Abr,
                'photo' => config('sis.url').'/photos/sap_id_'.$res[0]->SAP_ID.'.jpg',
                'remarques' => $res[0]->SAP_Rem,
                'fonctions' => $this->getFonctions(),
                'cours' => $this->getCours(),
                'promotions' => $this->getPromotions(),
                'exercices' => $this->getExercices() // TODO SapExe vs ExeSap, correct one is SapExe in v2
                // TODO: Intégrer les permis
            ];
        }
        else{
            throw new InvalidUserInputException('invalid sapeur id');
        }
    }

    public function create(): bool {


    }

    public function update(): bool {

    }

    public function setID($ID) {
        $this->id = $ID;
    }

    /**
     * Mutations du sapeur
     * @return array
     */
    public function getMutations(): array{
        $mutations = DB::connection('mysql_managed')->select('
                        SELECT SAP_Mutation.SMU_ID,
                               SAP_Mutation.SMU_Dinco,
                               SAP_Mutation.SMU_DSortie,
                               SAP_Mutation.SMU_Motif,
                               Localite.LOC_Designation
                          FROM SAP_Mutation
                         INNER JOIN Localite ON SAP_Mutation.LOC_ID = Localite.LOC_ID
                         INNER JOIN Sapeur ON Sapeur.SAP_ID = SAP_Mutation.SAP_ID
                         WHERE Sapeur.SAP_ID = ?
                         ORDER BY SAP_Mutation.SMU_Dinco ASC,
                                  SAP_Mutation.SMU_DSortie ASC',
                        [$this->id]);

        return array_map(function($mutation) {
            return [
                'id' => $mutation->SMU_ID,
                'date_inco' => DateHelper::toIso8601($mutation->SMU_Dinco),
                'date_sortie' => DateHelper::toIso8601($mutation->SMU_DSortie),
                'motif' => $mutation->SMU_Motif,
                'localite' => $mutation->LOC_Designation
            ];
        }, $mutations);
    }

    public static function getCivilites(): array {
        $rows = DB::connection('mysql_managed')->select('
                    SELECT CIV_ID,
                           CIV_Designation
                      FROM Civilite
                     ORDER BY CIV_Designation');

        return array_map(function($row) {
            return [
                'id' => $row->CIV_ID,
                'designation' => $row->CIV_Designation
            ];
        }, $rows);
    }

    /**
     * Fonctions du sapeur, par ordre chronologique
     * @return array
     */
    public function getFonctions(): array {
        $fonctions = DB::connection('mysql_managed')->select('
                        SELECT Fonction_.FON_ID,
                               Fonction_.FON_Nom,
                               Fonction_.FON_Abr,
                               FonSap.FON_Date,
                               FonSap.FON_Fin,
                               FonSap.FONSAP_Rem
                          FROM FonSap
                         INNER JOIN Fonction_ ON FonSap.FON_ID = Fonction_.Fon_ID
                         WHERE FonSap.SAP_ID = ?
                         ORDER BY FonSap.FON_Date ASC,
                                  FonSap.FON_Fin ASC,
                                  Fonction_.FON_Tri ASC',
                        [$this->id]);

        return array_map(function($fonction) {
            return [
                'id' => $fonction->FON_ID,
                'nom' => $fonction->FON_Nom,
                'nom_abr' => $fonction->FON_Abr,
                'date' => DateHelper::toIso8601($fonction->FON_Date),
                'fin' => DateHelper::toIso8601($fonction->FON_Fin),
                'remarque' => $fonction->FONSAP_Rem
            ];
        }, $fonctions);
    }

    /**
     * Groupes du sapeur
     * @return array
     */
    public function getGroupes($id = null): array {
        $groupes = DB::connection('mysql_managed')->select('
                    SELECT Groupe.GRP_ID,
                           Groupe.GRP_NO,
                           Groupe.GRP_designation
                      FROM GrpSap
                     INNER JOIN Groupe ON GrpSap.GRP_ID = Groupe.GRP_ID
                     WHERE GrpSap.SAP_ID = ?
                     ORDER BY Groupe.GRP_Tri ASC',
                    [$id ?? $this->id]);

        return array_map(function($groupe) {
            return [
                'id' => $groupe->GRP_ID,
                'no' => $groupe->GRP_NO,
                'nom' => $groupe->GRP_designation
            ];
        }, $groupes);
    }

    /**
     * Cours effectués par le sapeur
     * @return array
     */
    public function getCours(): array{
        $coursList = DB::connection('mysql_managed')->select('
                        SELECT Cours.COU_ID,
                               Cours.COU_Abr,
                               Cours.COU_designation,
                               CouSap.COU_Date,
                               CouSap.COU_Lieu
                          FROM CouSap
                         INNER JOIN Cours ON CouSap.COU_ID = Cours.COU_ID
                         WHERE CouSap.SAP_ID = ?
                         ORDER BY CouSap.COU_Date ASC,
                                  Cours.COU_Tri ASC',
                        [$this->id]);

        return array_map(function($cours) {
            return [
                'id' => $cours->COU_ID,
                'nom' => $cours->COU_designation,
                'nom_abr' => $cours->COU_Abr,
                'date' => DateHelper::toIso8601($cours->COU_Date),
                'lieu' => $cours->COU_Lieu
            ];
        }, $coursList);
    }

    /**
     * Promotions du sapeur (grades) par ordre chronologique
     * @return array
     */
    public function getPromotions(): array{
        $promotions = DB::connection('mysql_managed')->select('
                        SELECT Grade.GRA_ID,
                               Grade.GRA_Abr,
                               Grade.GRA_Designation,
                               GraSap.GRA_Date,
                               GraSap.GRASAP_Rem
                          FROM GraSap
                         INNER JOIN Grade ON GraSap.GRA_ID = Grade.GRA_ID
                         WHERE GraSap.SAP_ID = ?
                         ORDER BY GraSap.GRA_Date ASC,
                                  Grade.GRA_Tri ASC',
                        [$this->id]);

        return array_map(function($promotion) {
            return [
                'id' => $promotion->GRA_ID,
                'grade' => $promotion->GRA_Designation,
                'grade_abr' => $promotion->GRA_Abr,
                'date' => DateHelper::toIso8601($promotion->GRA_Date),
                'remarque' => $promotion->GRASAP_Rem
            ];
        }, $promotions);
    }

    /**
     * Contrôle médicaux
     * @return array
     */
    public function getControlesMedicaux(): array{
        $controles = DB::connection('mysql_managed')->select('
                        SELECT ControleMedicaux.CMED_ID,
                               ControleMedicaux.CMED_DConsultation,
                               ControleMedicaux.CMED_DValidite,
                               ControleMedicaux.CMED_Accepter,
                               ControleMedicaux.CMED_EnCours,
                               CMED_Type.CMT_Type,
                               Medecin.MED_Designation
                          FROM ControleMedicaux
                         INNER JOIN CMED_Type ON ControleMedicaux.CMT_ID = CMED_Type.CMT_ID
                         INNER JOIN Medecin ON Medecin.MED_ID = ControleMedicaux.MED_ID
                         WHERE ControleMedicaux.SAP_ID = ?
                         ORDER BY ControleMedicaux.CMED_DConsultation DESC',
                        [$this->id]);

        return array_map(function($controle) {
            return [
                'id' => $controle->CMED_ID,
                'date_consultation' => DateHelper::toIso8601($controle->CMED_DConsultation),
                'date_validite' => DateHelper::toIso8601($controle->CMED_DValidite),
                'accepte' => boolval($controle->CMED_Accepter),
                'encours' => boolval($controle->CMED_EnCours),
                'type' => $controle->CMT_Type,
                'medecin' => $controle->MED_Designation
            ];
        }, $controles);
    }

    /**
     * Exercices effectués par le sapeur, 10 premiers, ordre chronologique inversé
     * @return array
     */
    public function getExercices(): array {
        $exercice = new Exercice();

        return $exercice->getList(0, 10, 'date', true, ['sap_id' => $this->id]);
    }

    /**
     * Interventions effectuées par le sapeur, 10 premières, ordre chronologique inversé
     * @return array [description]
     */
    public function getInterventions(): array {
        $intervention = new Intervention();

        return $intervention->getList(0, 10, 'date', true, ['sap_id' => $this->id]);
    }

    /**
     * @return int Nombre d'enregistrements sélectionnés (sans tenir compte du LIMIT) lors de la dernière requête
     */
    public function count(){
        $result = DB::connection('mysql_managed')->select('SELECT FOUND_ROWS() AS FOUND_ROWS');
        return $result[0]->FOUND_ROWS;
    }
}
