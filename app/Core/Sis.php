<?php
namespace App\Core;

use App\Exceptions\InvalidUserInputException;
use DB;

/**
 * Classe représentant un SIS
 */
class Sis {
    /**
     * @return mixed Liste des SIS
     */
    public function getList(array $filters): array {
        $filters = array_where($filters, function($value, $key){
            return !is_null($value);
        });
        $params = $filters;

        $sis = DB::connection('mysql_dba')->select('
                SELECT SIS_ID,
                       SIS_NOM,
                       SIS_Abr,
                       SIS_Actif,
                       SIS_URL,
                       SIS_Mobile
                  FROM SIS
                 WHERE 1 = 1
                 '.(isset($filters['actif']) ? ' AND SIS_Actif = :actif' : '').'
                 '.(isset($filters['mobile']) ? ' AND SIS_Mobile = :mobile' : '').'
                 ORDER BY SIS_NOM ASC',
                $params);

       return array_map(function($sis) {
           return [
               'id' => $sis->SIS_ID,
               'nom' => $sis->SIS_NOM,
               'abr' => $sis->SIS_Abr,
               'actif' => boolval($sis->SIS_Actif),
               'mobile' => boolval($sis->SIS_Mobile),
               'url' => $sis->SIS_URL
           ];
       }, $sis);
    }

    /**
     * Paramètre la connexion à la base de données du SIS rattaché
     * @param int $sisID
     */
    public static function retrieveSettings(int $sisID){
        $res = DB::select('
                SELECT BDO_Host, BDO_Port, BDO_User, BDO_PWD, BDO_Nom,
                       BDO_Charset, BDO_Collation, SIS_NOM, SIS_Abr, SIS_Actif, SIS_URL
                  FROM SIS
                 INNER JOIN Base_Donnees ON SIS.BDO_ID = Base_Donnees.BDO_ID
                 WHERE SIS_ID = ?
             ', [$sisID]);

        if(count($res) == 1){
            config([
                'database.connections.mysql_managed.host' => $res[0]->BDO_Host,
                'database.connections.mysql_managed.port' => $res[0]->BDO_Port,
                'database.connections.mysql_managed.database' => $res[0]->BDO_Nom,
                'database.connections.mysql_managed.username' => decrypt($res[0]->BDO_User),
                'database.connections.mysql_managed.password' => decrypt($res[0]->BDO_PWD),
                'database.connections.mysql_managed.charset' => $res[0]->BDO_Charset,
                'database.connections.mysql_managed.collation' => $res[0]->BDO_Collation,
                'sis.name' => $res[0]->SIS_NOM,
                'sis.abr' => $res[0]->SIS_Abr,
                'sis.actif' => $res[0]->SIS_Actif,
                'sis.url' => $res[0]->SIS_URL,
                'sis.id' => $sisID
            ]);
            DB::connection('mysql_managed')->reconnect();
        }
        else{
            throw new InvalidUserInputException('invalid sis id');
        }
    }

    public static function getLocalities(array $filters){
        $query = DB::connection('mysql_dba')->table('Localite')
                    ->select('Localite.LOC_ID', 'LOC_NPA', 'LOC_Designation', 'LOS_ID', 'LOS_PAR_ID')
                    ->leftJoin('Localite_SIS', function($join) {
                        $join->on('Localite_SIS.LOC_ID', '=', 'Localite.LOC_ID')
                             ->where('SIS_No', '=', config('sis.id'));
                    });
        
        if(isset($filters['query'])){
            $query->whereRaw('CONCAT(LOC_NPA, " ", LOC_Designation) LIKE ?', ['%'.$filters['query'].'%']);
        }

        $query->orderBy('LOS_PAR_ID', 'asc');
        $rows = $query->get()->toArray();

        return array_map(function($locality) {
            return [
                'id' => $locality->LOC_ID,
                'npa' => $locality->LOC_NPA,
                'nom' => $locality->LOC_Designation,
                'concerne_sis' => !is_null($locality->LOS_ID)
            ];
        }, $rows);
    }
}
