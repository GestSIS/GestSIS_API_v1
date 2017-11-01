<?php
namespace App\Core;

use Request;
use DB;

class BaseData {
  /**
   * Récupération des communes/localités
   * @return liste des localités par communes
   */
  static public function getDistrictLocality(){
    $commune = DB::connection('mysql_dba')->select('
                SELECT COM_ID,
                       COM_Designation
                  FROM
                       commune
                  ORDER BY commune.COM_Designation ASC');

    return array_map(function($commune) {
        return [
            'id' => $commune->COM_ID,
            'nom' => $commune->COM_Designation,
            'localite' => BaseData::getLocalityPerDistrict($commune->COM_ID)
        ];
    }, $commune);
  }

  /**
   * Récupérations des localités
   * @return liste des localités
   */
  static public function getLocalities(){
    $locality = DB::connection('mysql_dba')->select('
                    SELECT LOC_ID,
                           LOC_NPA,
                           LOC_Designation
                      FROM localite
                      ORDER BY localite.LOC_Designation ASC');
    return array_map(function($locality) {
        return [
            'id' => $locality->LOC_ID,
            'npa' => $locality->LOC_NPA,
            'nom' => $locality->LOC_Designation
        ];
    }, $locality);
  }

  /**
   * Récupération localités d'une commune
   * @param id de la commune
   * @return liste des localités pour une commune
   */
  static public function getLocalityPerDistrict(int $id){
    $locality = DB::connection('mysql_dba')->select('
                SELECT LOC_ID,
                       LOC_NPA,
                       LOC_Designation
                  FROM localite
                  WHERE localite.COM_ID = ?
                  ORDER BY localite.LOC_Designation ASC',
                [$id]);
    return array_map(function($locality) {
        return [
            'id' => $locality->LOC_ID,
            'npa' => $locality->LOC_NPA,
            'nom' => $locality->LOC_Designation
        ];
    }, $locality);
  }

  /**
   * Récupération des statistiques fédérales
   * @return liste des statistiques fédérales
   */
  static public function getFederalStat(){
    $federalStat = DB::connection('mysql_dba')->select('
                SELECT statfederal.STF_ID,
                       statfederal.STF_Statut,
                       statfederal.STF_Designation,
                       statfederal.STF_Tri
                  FROM statfederal
                  ORDER BY statfederal.STF_ID ASC');
    return array_map(function($federalStat) {
        return [
            'id' => $federalStat->STF_ID,
            'statut' => $federalStat->STF_Statut,
            'nom' => $federalStat->STF_Designation,
            'tri' => $federalStat->STF_Tri
        ];
    }, $federalStat);
  }

  /**
   * Récupération des types d'intervention
   * @return liste des types d'interventions
   */
  static public function getInterventiontype(){
    $interventionType = DB::connection('mysql_dba')->select('
                SELECT typeintervention.TINT_ID,
                       typeintervention.STINT_ID,
                       typeintervention.TINT_Tri,
                       typeintervention.TINT_Designation
                  FROM typeintervention
                  ORDER BY typeintervention.TINT_Tri ASC');
    return array_map(function($interventionType) {
        return [
            'id' => $interventionType->TINT_ID,
            'id_stat' => $interventionType->STINT_ID,
            'nom' => $interventionType->TINT_Designation,
            'tri' => $interventionType->TINT_Tri
        ];
    }, $interventionType);
  }

  /**
   * Récupération des grades
   * @return liste des grades
   */
  static public function getGrade(){
    $grade = DB::connection('mysql_dba')->select('
                SELECT grade.GRA_ID,
                       grade.GRA_Designation,
                       grade.GRA_Abr,
                       grade.GRA_Grp,
                       grade.GRA_Tri
                  FROM grade
                  ORDER BY grade.GRA_Tri ASC');
    return array_map(function($grade) {
        return [
            'id' => $grade->GRA_ID,
            'abr' => $grade->GRA_Abr,
            'nom' => $grade->GRA_Designation,
            'grp' => $grade->GRA_Grp,
            'tri' => $grade->GRA_Tri
        ];
    }, $grade);
  }

  /**
   * Récupération des Cours
   * @return liste des cours
   */
   static public function getCours(){
     $cours = DB::connection('mysql_dba')->select('
                   SELECT cours.COU_ID,
                          cours.COU_Prec,
                          cours.GRA_ID,
                          cours.GRA_ID2004,
                          cours.FON_ID,
                          cours.COU_Fon_Cumul,
                          cours.COU_Abr,
                          cours.COU_Designation,
                          cours.COU_Tri
                     FROM cours
                     ORDER BY cours.COU_Tri ASC');
     return array_map(function($cours) {
         return [
             'id' => $cours->COU_ID,
             'prec' => $cours->COU_Prec,
             'id_gra' => $cours->GRA_ID,
             'id_gra2004' => $cours->GRA_ID2004,
             'id_fon' => $cours->FON_ID,
             'fon_cumul' => $cours->COU_Fon_Cumul,
             'abr' => $cours->COU_Abr,
             'nom' => $cours->COU_Designation,
             'tri' => $cours->COU_Tri
         ];
     }, $cours);
   }

   /**
    * Récupération des types de controle médical
    * @return liste des type de controle médical
    */
    static public function getControlesMedicauxTypes(){
      $cmt = DB::connection('mysql_dba')->select('
                    SELECT cmed_type.CMT_ID,
                           cmed_type.CMT_Type,
                           cmed_type.CMT_Tri
                      FROM cmed_type
                      ORDER BY cmed_type.CMT_Tri ASC');
      return array_map(function($cmt) {
          return [
              'id' => $cmt->CMT_ID,
              'type' => $cmt->CMT_Type,
              'tri' => $cmt->CMT_Tri
          ];
      }, $cmt);
    }
}
