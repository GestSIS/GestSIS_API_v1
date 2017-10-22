<?php
namespace App\Core;

use App\Exceptions\InvalidUserInputException;
use DB;

/**
 * Classe représentant une intervention
 */
class Intervention {
    private $id;

    public function __construct(int $id = null){
        if(!is_null($id)){
            $this->id = $id;
        }
    }

    /**
     * Liste des interventions selon les filtres passés en paramètre
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
        $params = $filters;

        if(!is_null($start) && !is_null($limit)){
            $params['start'] = $start;
            $params['limit'] = $limit;
        }

        $orderType = ($reverseSort ? 'DESC' : 'ASC');
        $orders = [
            'date' => 'Intervention.INT_Date '.$orderType,
            'traitement' => 'IntTraitement.INTR_Designation '.$orderType,
            'localite' => 'Localite.LOC_Designation '.$orderType,
            'type' => 'TypeIntervention.TINT_Designation '.$orderType,
            'lieu' => 'Intervention.INT_Lieu '.$orderType,
            'objet' => 'Intervention.INT_Objet '.$orderType
        ];

        $orderBy = isset($orders[$orderCode]) ?  $orders[$orderCode] : $orders['date'];
        $res = [];

        $interventions = DB::connection('mysql_managed')->select('
                            SELECT SQL_CALC_FOUND_ROWS
                                   Intervention.INT_ID,
                                   Intervention.INT_Date,
                                   Intervention.INT_Heure,
                                   Intervention.INT_Lieu,
                                   Intervention.INT_Objet,
                                   Intervention.INT_DateFin,
                                   Intervention.INT_HeureFin,'.
                                   (isset($filters['sap_id']) ?
                                   'IntSap.INTSAP_Quittance,
                                   IntSap.INTSAP_Present,
                                   IntSap.INTSAP_NbHeure,
                                   IntSap.INTSAP_NbPiquet,
                                   IntSap.INTSAP_NbEntr,' :
                                   'NULL AS INTSAP_Quittance,
                                   NULL AS INTSAP_Present,
                                   NULL AS INTSAP_NbHeure,
                                   NULL AS INTSAP_NbPiquet,
                                   NULL AS INTSAP_NbEntr, '
                                   ).'
                                   TypeIntervention.TINT_Designation,
                                   IntTraitement.Intr_Designation,
                                   Localite.LOC_Npa,
                                   Localite.LOC_Designation,
                                   StatFederal.STF_Designation
                              FROM Intervention
                             INNER JOIN TypeIntervention ON Intervention.TINT_ID = TypeIntervention.TINT_ID
                             INNER JOIN Localite ON Intervention.LOC_ID = Localite.LOC_ID '.
                             (isset($filters['sap_id']) ? 'INNER JOIN IntSap ON Intervention.INT_ID = IntSap.INT_ID ' : '').'
                              LEFT OUTER JOIN IntTraitement ON Intervention.INTR_ID = IntTraitement.INTR_ID
                              LEFT OUTER JOIN StatFederal ON StatFederal.STF_ID = Intervention.STF_ID
                             WHERE 1=1
                             '.(isset($filters['loc_id']) ? ' AND Localite.LOC_ID = :loc_id' : '').'
                             '.(isset($filters['annee']) ? ' AND Intervention.INT_AnneeFiltre = :annee' : '').'
                             '.(isset($filters['type_int_id']) ? ' AND Intervention.TINT_ID = :type_int_id' : '').'
                             '.(isset($filters['traitement_id']) ? ' AND Intervention.INTR_ID = :traitement_id' : '').'
                             '.(isset($filters['stat_fed_id']) ? ' AND Intervention.STF_ID = :stat_fed_id' : '').'
                             '.(isset($filters['sap_id']) ? ' AND IntSap.SAP_ID = :sap_id' : '').'
                             ORDER BY '.$orderBy.'
                             '.(!is_null($start) && !is_null($limit) ? 'LIMIT :start, :limit' : ''),
                             $params);
        $count = $this->count();

        $res['data'] = array_map(function($intervention) {
            return [
                'id' => $intervention->INT_ID,
                'date' => $intervention->INT_Date,
                'heure' => $intervention->INT_Heure,
                'lieu' => $intervention->INT_Lieu,
                'objet' => $intervention->INT_Objet,
                'date_fin' => $intervention->INT_DateFin,
                'heure_fin' => $intervention->INT_HeureFin,
                'quittance' => $intervention->INTSAP_Quittance,
                'present' => $intervention->INTSAP_Present,
                'nb_heures' => $intervention->INTSAP_NbHeure,
                'nb_heures_piquet' => $intervention->INTSAP_NbPiquet,
                'nb_heures_entretien' => $intervention->INTSAP_NbEntr,
                'type' => $intervention->TINT_Designation,
                'npa' => $intervention->LOC_Npa,
                'localite' => $intervention->LOC_Designation,
                'traitement' => $intervention->Intr_Designation,
                'stat_fed' => $intervention->STF_Designation
            ];
        }, $interventions);

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

            $res['paging'] = ['next' => route('api.v1.intervention.index', $params)];
        }

        $res['count'] = $count;

        return $res;
    }

    /**
     * Détail d'une intervention
     * @return array
     */
    public function getDetails(): array{
        $res = DB::connection('mysql_managed')->select('
                SELECT Intervention.INT_ID,
                       Intervention.INT_Date,
                       Intervention.INT_Heure,
                       Intervention.INT_Lieu,
                       Intervention.INT_Objet,
                       Intervention.INT_DateFin,
                       Intervention.INT_HeureFin,
                       Intervention.INT_RapportPolice,
                       Intervention.INT_STAT_Nb,
                       Intervention.INT_SauvPersonne,
                       Intervention.INT_SauvAnimaux,
                       Intervention.INT_Description,
                       Intervention.INT_Proprietaire,
                       Intervention.INT_Responsable,
                       Intervention.INT_Degre,
                       Localite.LOC_Npa,
                       Localite.LOC_Designation,
                       IntTraitement.Intr_Designation,
                       StatFederal.STF_Designation,
                       TypeIntervention.TINT_Designation,
                       Sapeur.SAP_Nom,
                       Sapeur.SAP_Prenom
                  FROM Intervention
                 INNER JOIN TypeIntervention ON Intervention.TINT_ID = TypeIntervention.TINT_ID
                 INNER JOIN Localite ON Intervention.LOC_ID = Localite.LOC_ID
                  LEFT OUTER JOIN IntTraitement ON Intervention.INTR_ID = IntTraitement.INTR_ID
                  LEFT OUTER JOIN StatFederal ON Intervention.STF_ID = StatFederal.STF_ID
                  LEFT OUTER JOIN Sapeur ON Intervention.SAP_ID_CI = Sapeur.SAP_ID
                 WHERE Intervention.INT_ID = ?',
             [$this->id]);

        if(isset($res[0])){
            return [
                'id' => $res[0]->INT_ID,
                'date' => $res[0]->INT_Date,
                'heure' => $res[0]->INT_Heure,
                'lieu' => $res[0]->INT_Lieu,
                'objet' => $res[0]->INT_Objet,
                'date_fin' => $res[0]->INT_DateFin,
                'heure_fin' => $res[0]->INT_HeureFin,
                'rapport_police' => $res[0]->INT_RapportPolice,
                'stat_fed_nb' => $res[0]->INT_STAT_Nb,
                'personnes_sauvees' => $res[0]->INT_SauvPersonne,
                'animaux_sauves' => $res[0]->INT_SauvAnimaux,
                'description' => $res[0]->INT_Description,
                'proprietaire' => $res[0]->INT_Proprietaire,
                'responsable' => $res[0]->INT_Responsable,
                'degre' => $res[0]->INT_Degre,
                'type' => $res[0]->TINT_Designation,
                'npa' => $res[0]->LOC_Npa,
                'localite' => $res[0]->LOC_Designation,
                'traitement' => $res[0]->Intr_Designation,
                'stat_fed' => $res[0]->STF_Designation,
                'chef_int_nom' => $res[0]->SAP_Nom,
                'chef_int_prenom' => $res[0]->SAP_Prenom
            ];
        }
        else{
            throw new InvalidUserInputException('invalid intervention id');
        }
    }

    /**
     * Liste des sapeurs intervenus
     * @return array
     */
    public function getSapeursList(): array{
        $sapeurs = DB::connection('mysql_managed')->select('
                    SELECT Sapeur.SAP_ID,
                           Sapeur.SAP_Nom,
                           Sapeur.SAP_Prenom,
                           IntSap.INTSAP_Quittance,
                           IntSap.INTSAP_Present,
                           IntSap.INTSAP_NbHeure,
                           IntSap.INTSAP_NbPiquet,
                           IntSap.INTSAP_NbEntr
                      FROM IntSap
                     INNER JOIN Sapeur ON IntSap.SAP_ID = Sapeur.SAP_ID
                     WHERE IntSap.INT_ID = ?
                     ORDER BY Sapeur.SAP_NOM ASC, Sapeur.SAP_Prenom ASC',
                 [$this->id]);

        return array_map(function($sapeur) {
            return [
                'id' => $sapeur->SAP_ID,
                'nom' => $sapeur->SAP_Nom,
                'prenom' => $sapeur->SAP_Prenom,
                'quittance' => $sapeur->INTSAP_Quittance,
                'present' => $sapeur->INTSAP_Present,
                'nb_heure' => $sapeur->INTSAP_NbHeure,
                'nb_heure_piquet' => $sapeur->INTSAP_NbPiquet,
                'nb_heure_entretien' => $sapeur->INTSAP_NbEntr
            ];
        }, $sapeurs);
    }

    /**
     * Liste des groupes intervenus
     * @return array
     */
    public function getGroupesList(): array {
        $groupes = DB::connection('mysql_managed')->select('
                    SELECT Groupe.GRP_ID,
                           Groupe.GRP_No,
                           Groupe.GRP_Designation
                      FROM GrpInt
                     INNER JOIN Groupe ON GrpInt.GRP_ID = Groupe.GRP_ID
                     WHERE GrpInt.INT_ID = ?
                     ORDER BY Groupe.GRP_No ASC',
                 [$this->id]);

        return array_map(function($groupe) {
            return [
                'id' => $groupe->GRP_ID,
                'no' => $groupe->GRP_No,
                'nom' => $groupe->GRP_Designation
            ];
        }, $groupes);
    }

    /**
     * Liste des véhicules intervenus
     * @return array
     */
    public function getVehiculesList(): array {
        $vehicules = DB::connection('mysql_managed')->select('
                        SELECT VhcIntervention.VHCI_ID,
                               VhcIntervention.VHCI_Designation
                          FROM VhcInt
                         INNER JOIN VhcIntervention ON VhcInt.VHCI_ID = VhcIntervention.VHCI_ID
                         WHERE VhcInt.INT_ID = ?
                         ORDER BY VhcIntervention.VHCI_Designation ASC',
                     [$this->id]);

        return array_map(function($vehicule) {
            return [
                'id' => $vehicule->VHCI_ID,
                'nom' => $vehicule->VHCI_Designation
            ];
        }, $vehicules);
    }

    /**
     * Liste du matériel utilisé
     * @return array
     */
    public function getMaterielList(): array {
        $materiel = DB::connection('mysql_managed')->select('
                        SELECT MatIntervention.MATI_ID,
                               MatIntervention.MATI_Designation,
                               MatInt.MI_Qte
                          FROM MatInt
                         INNER JOIN MatIntervention ON MatInt.MATI_ID = MatIntervention.MATI_ID
                         WHERE MatInt.INT_ID = ?
                         ORDER BY MatIntervention.MATI_Designation ASC',
                     [$this->id]);

        return array_map(function($a_materiel) {
            return [
                'id' => $a_materiel->MATI_ID,
                'nom' => $a_materiel->MATI_Designation
            ];
        }, $materiel);
    }

    /**
     * @return int Nombre d'enregistrements sélectionnés (sans tenir compte du LIMIT) lors de la dernière requête
     */
    public function count(){
        $result = DB::connection('mysql_managed')->select('SELECT FOUND_ROWS() AS FOUND_ROWS');
        return $result[0]->FOUND_ROWS;
    }
}
