<?php
namespace App\Core;

use App\Exceptions\InvalidUserInputException;
use DB;

/**
 * Classe représentant un exercice
 */
class Exercice {
    private $id;

    public function __construct(int $id = null){
        if(!is_null($id)){
            $this->id = $id;
        }
    }

    public static function getExcuseType():array{
      $excusesTypes = DB::connection('mysql_managed')->select('
                      SELECT ExcuseType.EXCTYPE_ID,
                             ExcuseType.EXCTYPE_Designation
                       FROM ExcuseType
                       ORDER BY EXCTYPE_ID;');

      $res['data'] = array_map(function($excusesTypes) {
          return [
              'id' => $excusesTypes->EXCTYPE_ID,
              'designation' => $excusesTypes->EXCTYPE_Designation
          ];
      }, $excusesTypes);

      return $res;
    }

    /**
     * Retourne une liste d'exercices selon les filtres passés en paramètre
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
            'date' => 'Exercice.EXE_Date '.$orderType,
            'heure' => 'Exercice.EXE_Heure '.$orderType,
            'localite' => 'Localite.LOC_Designation '.$orderType,
            'categorie' => 'CatExercice.CEX_Designation '.$orderType,
            'lieu' => 'Exercice.EXE_Lieu '.$orderType,
            'communication' => 'Exercice.EXE_Communication '.$orderType,
            'heure_fin' => 'TIME(DATE_ADD(CONCAT(EXE_Date,\' \',EXE_Heure), INTERVAL EXE_Duree MINUTE)) '.$orderType
        ];

        $orderBy = isset($orders[$orderCode]) ?  $orders[$orderCode] : $orders['date'];
        $res = [];

        $exercices = DB::connection('mysql_managed')->select('
                        SELECT SQL_CALC_FOUND_ROWS
                               Exercice.EXE_ID,
                               Exercice.EXE_Date,
                               Exercice.EXE_Heure,
                               Exercice.EXE_Lieu,
                               Exercice.EXE_Communication,
                               Exercice.EXE_Duree,
                               Exercice.EXE_Statut,
                               CatExercice.CEX_Designation,
                               Localite.LOC_Designation,'.
                               (isset($filters['sap_id']) ?
                               'ExeSap.EXESAP_Convoque,
                               ExeSap.EXESAP_Present,
                               ExeSap.EXESAP_Amende,
                               ExcuseType.EXCTYPE_Designation,
                               ExcuseType.EXCTYPE_ID' :
                               'NULL AS EXESAP_Convoque,
                                NULL AS EXESAP_Present,
                                NULL AS EXESAP_Amende,
                                NULL AS EXCTYPE_Designation,
                                NULL AS EXCTYPE_ID'). '
                          FROM Exercice
                         INNER JOIN CatExercice ON Exercice.CEX_ID = CatExercice.CEX_ID
                         INNER JOIN Localite ON Exercice.LOC_ID = Localite.LOC_ID '.
                         (isset($filters['sap_id']) ?
                         'INNER JOIN ExeSap ON Exercice.EXE_ID = ExeSap.EXE_ID
                           LEFT OUTER JOIN ExcuseType ON ExeSap.EXCTYPE_ID = ExcuseType.EXCTYPE_ID ' : '').'
                         WHERE 1 = 1
                         '.(isset($filters['sap_id']) ? ' AND ExeSap.SAP_ID = :sap_id' : '').'
                         '.(isset($filters['annee']) ? ' AND Exercice.EXE_AnneeFiltre = :annee' : '').'
                         '.(isset($filters['loc_id']) ? ' AND Localite.LOC_ID = :loc_id' : '').'
                         '.(isset($filters['cex_id']) ? ' AND Exercice.CEX_ID = :cex_id' : '').'
                         '.(isset($filters['date_debut']) ? ' AND Exercice.EXE_Date >= :date_debut' : '').'
                         ORDER BY '.$orderBy.'
                         '.(!is_null($start) && !is_null($limit) ? 'LIMIT :start, :limit' : ''),
                         $params);
        $count = $this->count();

        // Récupération des exercices dont les présences ont déjà été complétées
        $exeComplets = DB::connection('mysql_dba')->select('
                        SELECT TRA_Reference
                          FROM Transfert_App
                         INNER JOIN Transfert_App_Cat ON Transfert_App.TAC_ID = Transfert_App_Cat.TAC_ID
                         WHERE TAC_Code = "presences-exercice"
                           AND TRA_Reference IS NOT NULL
                           AND TRA_Complet = 1
        ');

        $idExeComplets = array_map(function($exe) {
            return $exe->TRA_Reference;
        }, $exeComplets);

        $res['data'] = array_map(function($exercice) use ($idExeComplets) {
            return [
                'id' => $exercice->EXE_ID,
                'date' => DateHelper::toIso8601($exercice->EXE_Date.' '.$exercice->EXE_Heure),
                'heure' => $exercice->EXE_Heure,
                'lieu' => $exercice->EXE_Lieu,
                'communication' => $exercice->EXE_Communication,
                'duree' => $exercice->EXE_Duree,
                'statut' => $exercice->EXE_Statut,
                'categorie' => $exercice->CEX_Designation,
                'localite' => $exercice->LOC_Designation,
                'convoque' => $exercice->EXESAP_Convoque,
                'present' => $exercice->EXESAP_Present,
                'amende' => $exercice->EXESAP_Amende,
                'type_excuse' => $exercice->EXCTYPE_Designation,
                'id_type_excuse' => $exercice->EXCTYPE_ID,
                'presences_completees' => in_array($exercice->EXE_ID, $idExeComplets),
                'sapeurs' => $this->getSapeursList($exercice->EXE_ID)
            ];
        }, $exercices);

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

            $res['paging'] = ['next' => route('api.v1.exercice.index', $params)];
        }

        $res['count'] = $count;

        return $res;
    }

    /**
     * Détail d'un exercice
     * @return array
     */
    public function getDetails(): array{
        $res = DB::connection('mysql_managed')->select('
                SELECT Exercice.EXE_ID,
                       Exercice.EXE_Date,
                       Exercice.EXE_Heure,
                       Exercice.EXE_Lieu,
                       Exercice.EXE_Communication,
                       Exercice.EXE_Duree,
                       Exercice.EXE_Statut,
                       Exercice.EXE_Designation,
                       CatExercice.CEX_Designation,
                       Localite.LOC_Designation
                  FROM Exercice
                 INNER JOIN Localite ON Exercice.LOC_ID = Localite.LOC_ID
                 INNER JOIN CatExercice ON Exercice.CEX_ID = CatExercice.CEX_ID
                 WHERE Exercice.EXE_ID = ?',
             [$this->id]);

        if(isset($res[0])){
            return [
                'id' => $res[0]->EXE_ID,
                'date' => DateHelper::toIso8601($res[0]->EXE_Date.' '.$res[0]->EXE_Heure),
                'heure' => $res[0]->EXE_Heure,
                'lieu' => $res[0]->EXE_Lieu,
                'communication' => $res[0]->EXE_Communication,
                'description' => $res[0]->EXE_Designation,
                'duree' => $res[0]->EXE_Duree,
                'statut' => $res[0]->EXE_Statut,
                'categorie' => $res[0]->CEX_Designation,
                'localite' => $res[0]->LOC_Designation
            ];
        }
        else{
            throw new InvalidUserInputException('invalid sapeur id');
        }
    }

    /**
     * Liste des sapeurs qui ont effectués l'exercice
     * @return array
     */
    public function getSapeursList(int $id = null): array{
        $sapeurs = DB::connection('mysql_managed')->select('
                SELECT Sapeur.SAP_ID,
                       Sapeur.SAP_Nom,
                       Sapeur.SAP_Prenom,
                       ExeSap.EXESAP_Convoque,
                       ExeSap.EXESAP_Present,
                       ExeSap.EXESAP_Amende,
                       ExcuseType.EXCTYPE_Designation,
                       NULL AS SAP_Absent
                  FROM ExeSap
                 INNER JOIN Sapeur ON ExeSap.SAP_ID = Sapeur.SAP_ID
                  LEFT OUTER JOIN ExcuseType ON ExeSap.EXCTYPE_ID = ExcuseType.EXCTYPE_ID
       	         WHERE ExeSap.EXE_ID = ?
                 ORDER BY Sapeur.SAP_Nom ASC, Sapeur.SAP_Prenom ASC',
                [$id ?? $this->id]);

        return array_map(function($sapeur) {
            return [
                'id' => $sapeur->SAP_ID,
                'nom' => $sapeur->SAP_Nom,
                'prenom' => $sapeur->SAP_Prenom,
                'convoque' => $sapeur->EXESAP_Convoque,
                'present' => $sapeur->EXESAP_Present,
                'absent' => $sapeur->SAP_Absent,
                'amende' => $sapeur->EXESAP_Amende,
                'type_excuse' => $sapeur->EXCTYPE_Designation
            ];
        }, $sapeurs);
    }

    /**
     * @return int Nombre d'enregistrements sélectionnés (sans tenir compte du LIMIT) lors de la dernière requête
     */
    public function count(){
        $result = DB::connection('mysql_managed')->select('SELECT FOUND_ROWS() AS FOUND_ROWS');
        return $result[0]->FOUND_ROWS;
    }
}
