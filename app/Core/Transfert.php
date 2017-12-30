<?php
namespace App\Core;

use App\Exceptions\InvalidUserInputException;
use DB;

/**
 * Classe représentant un transfert
 */
class Transfert {

    private $id;

    public function __construct(int $id = null){
        if(!is_null($id)){
            $this->id = $id;
        }
    }

    /**
     * Récupération des transferts
     * @return array liste des transferts
     */
    public function getList(array $filters): array {
        $filters = array_where($filters, function($value, $key){
            return !is_null($value);
        });
        $params = $filters;
        unset($params['transmis']);
        $params['sis_id'] = config('sis.id');

        $transferts = DB::connection('mysql_dba')->select('
                       SELECT TRA_ID,
                              TRA_Designation,
                              TRA_Contenu,
                              TRA_Date_Creation,
                              TRA_Date_Reception,
                              TAC_Code,
                              TRA_Complet
                         FROM Transfert_App
                        INNER JOIN Transfert_App_Cat ON Transfert_App.TAC_ID = Transfert_App_Cat.TAC_ID
                        WHERE SIS_ID = :sis_id
                          '.(isset($filters['categorie']) ? ' AND TAC_Code = :categorie' : '').'
                          '.(isset($filters['transmis']) ? ' AND TRA_Date_Reception '.($filters['transmis'] ? 'IS NOT NULL' : 'IS NULL' ) : '').'
                          '.(isset($filters['complet']) ? ' AND TRA_Complet = :complet' : '').'
                        ORDER BY TRA_Date_Creation ASC',
                      $params);

        return array_map(function($transfert) {
            return [
                'id' => $transfert->TRA_ID,
                'categorie' => $transfert->TAC_Code,
                'nom' => $transfert->TRA_Designation,
                'contenu' => json_decode($transfert->TRA_Contenu),
                'date_creation' => $transfert->TRA_Date_Creation,
                'date_reception' => $transfert->TRA_Date_Reception,
                'complet' => boolval($transfert->TRA_Complet)
            ];
        }, $transferts);
    }

    /**
     * Défini la date de réception du transfert
     */
    public function updateReceiptDate(){
        DB::connection('mysql_dba')->update('
            UPDATE Transfert_App
               SET TRA_Date_Reception = CURRENT_TIMESTAMP
             WHERE TRA_ID = ?
               AND SIS_ID = ?',
         [$this->id, config('sis.id')]);
    }

    /**
     * Crée un transfert
     */
    public function create($catCode, $content){

        switch($catCode){
            case 'rapport-intervention':
                $designation = date('d.m.Y H:i', strtotime($content['date_debut'])).' - '.$content['objet'];
                $reference = null;
                $complet = true;
            break;
            case 'presences-exercice':
                $designation = date('d.m.Y', strtotime($content['date'])).' - '.$content['communication'];
                $reference = $content['id'];
                $complet = $content['complet'] == 1;
            break;
        }

        // Vérification si un transfert avec la même référence existe
        $existing = DB::select('
                      SELECT TRA_ID, TRA_Complet
                        FROM Transfert_App
                       INNER JOIN Transfert_App_Cat ON Transfert_App.TAC_ID = Transfert_App_Cat.TAC_ID
                       WHERE TRA_Reference = ?
                         AND TAC_Code = ?',
                [$reference, $catCode]);

        // Mise à jour d'un enregistrement existant si incomplet
        if(!is_null($reference) && isset($existing[0]) && $existing[0]->TRA_Complet == 0 && $complet){
            DB::update('
                UPDATE Transfert_App
                   SET TRA_Complet = 1,
                       TRA_Contenu = ?,
                       TRA_Date_Creation = CURRENT_TIMESTAMP
                 WHERE TRA_ID = ?',
             [json_encode($content), $existing[0]->TRA_ID]);
        }
        else if(!is_null($reference) && isset($existing[0])){
            \Log::warning('Un transfert avec la même référence et complet existe déjà. Il ne sera pas remplacé. Réf : '.$reference.', Catégorie : '.$catCode);
        }
        else{
            // Insertion d'un nouveau transfert
            DB::insert('
                INSERT INTO Transfert_App (
                    TAC_ID,
                    SIS_ID,
                    TRA_Designation,
                    TRA_Contenu,
                    TRA_Date_Creation,
                    TRA_Reference,
                    TRA_Complet
                )
                VALUES (
                    (SELECT TAC_ID FROM Transfert_App_Cat WHERE TAC_Code = ?),
                    ?,
                    ?,
                    ?,
                    CURRENT_TIMESTAMP,
                    ?,
                    ?
                )',
                [$catCode, config('sis.id'), $designation, json_encode($content), $reference, $complet]);
        }
    }

    /**
     * Liste des transferts completés, seul. pour présences exercices
     */
    public function getArchived($catCode){
        if($catCode !== 'presences-exercice'){
            return [];
        }

        $res = DB::select('
                SELECT TRA_Reference
                  FROM Transfert_App
                 INNER JOIN Transfert_App_Cat ON Transfert_App.TAC_ID = Transfert_App_Cat.TAC_ID
                 WHERE TAC_Code = ?
                   AND TRA_Complet = 1',
        [$catCode]);

        return array_map(function($transfert) {
            return $transfert->TRA_Reference;
        }, $res);
    }

}
