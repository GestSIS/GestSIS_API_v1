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
    $communes = DB::connection('mysql_dba')->select('
                SELECT COM_ID,
                       COM_Designation
                  FROM
                       Commune
                  ORDER BY Commune.COM_Designation ASC');

    return array_map(function($commune) {
        return [
            'id' => $commune->COM_ID,
            'nom' => $commune->COM_Designation,
            'localite' => BaseData::getLocalityPerDistrict($commune->COM_ID)
        ];
    }, $communes);
  }

  /**
   * Récupérations des localités
   * @return liste des localités
   */
  static public function getLocalities(){
    $localities = DB::connection('mysql_dba')->select('
                    SELECT LOC_ID,
                           LOC_NPA,
                           LOC_Designation
                      FROM Localite
                      ORDER BY Localite.LOC_Designation ASC');
    return array_map(function($locality) {
        return [
            'id' => $locality->LOC_ID,
            'npa' => $locality->LOC_NPA,
            'nom' => $locality->LOC_Designation
        ];
    }, $localities);
  }

  /**
   * Récupération localités d'une commune
   * @param id de la commune
   * @return liste des localités pour une commune
   */
  static public function getLocalityPerDistrict(int $id){
    $localities = DB::connection('mysql_dba')->select('
                SELECT LOC_ID,
                       LOC_NPA,
                       LOC_Designation
                  FROM Localite
                  WHERE Localite.COM_ID = ?
                  ORDER BY Localite.LOC_Designation ASC',
                [$id]);
    return array_map(function($locality) {
        return [
            'id' => $locality->LOC_ID,
            'npa' => $locality->LOC_NPA,
            'nom' => $locality->LOC_Designation
        ];
    }, $localities);
  }

  /**
   * Récupération des statistiques fédérales
   * @return liste des statistiques fédérales
   */
  static public function getFederalStat(){
    $federalStats = DB::connection('mysql_dba')->select('
                SELECT STF_ID,
                       STF_Statut,
                       STF_Designation,
                       STF_Tri
                  FROM StatFederal
                  ORDER BY STF_ID ASC');
    return array_map(function($federalStat) {
        return [
            'id' => $federalStat->STF_ID,
            'statut' => $federalStat->STF_Statut,
            'nom' => $federalStat->STF_Designation,
            'tri' => $federalStat->STF_Tri
        ];
    }, $federalStats);
  }

  /**
   * Récupération des types d'intervention
   * @return liste des types d'interventions
   */
  static public function getInterventiontype(){
    $interventionTypes = DB::connection('mysql_dba')->select('
                SELECT TINT_ID,
                       STINT_ID,
                       TINT_Tri,
                       TINT_Designation
                  FROM TypeIntervention
                  ORDER BY TINT_Tri ASC');
    return array_map(function($interventionType) {
        return [
            'id' => $interventionType->TINT_ID,
            'id_stat' => $interventionType->STINT_ID,
            'nom' => $interventionType->TINT_Designation,
            'tri' => $interventionType->TINT_Tri
        ];
    }, $interventionTypes);
  }

  /**
   * Récupération des grades
   * @return liste des grades
   */
  static public function getGrade(){
    $grades = DB::connection('mysql_dba')->select('
                SELECT GRA_ID,
                       GRA_Designation,
                       GRA_Abr,
                       GRA_Grp,
                       GRA_Tri
                  FROM Grade
                  ORDER BY GRA_Tri ASC');
    return array_map(function($grade) {
        return [
            'id' => $grade->GRA_ID,
            'abr' => $grade->GRA_Abr,
            'nom' => $grade->GRA_Designation,
            'grp' => $grade->GRA_Grp,
            'tri' => $grade->GRA_Tri
        ];
    }, $grades);
  }

  /**
   * Récupération des Cours
   * @return liste des cours
   */
   static public function getCours(){
     $coursList = DB::connection('mysql_dba')->select('
                   SELECT COU_ID,
                          COU_Prec,
                          GRA_ID,
                          GRA_ID2004,
                          FON_ID,
                          COU_Fon_Cumul,
                          COU_Abr,
                          COU_Designation,
                          COU_Tri
                     FROM Cours
                     ORDER BY COU_Tri ASC');
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
     }, $coursList);
   }

   /**
    * Récupération des types de controle médical
    * @return liste des type de controle médical
    */
    static public function getControlesMedicauxTypes(){
      $cmts = DB::connection('mysql_dba')->select('
                    SELECT CMT_ID,
                           CMT_Type,
                           CMT_Tri
                      FROM CMED_Type
                      ORDER BY CMT_Tri ASC');
      return array_map(function($cmt) {
          return [
              'id' => $cmt->CMT_ID,
              'type' => $cmt->CMT_Type,
              'tri' => $cmt->CMT_Tri
          ];
      }, $cmts);
    }
}
