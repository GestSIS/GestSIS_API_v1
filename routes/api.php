<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1'], function(){

    Route::get('sis', 'SisApiController@index')->name('api.v1.sis.index');

    // Authentication
    Route::group(['prefix' => 'auth'], function(){
        Route::post('token', 'AuthApiController@getToken')->name('api.v1.auth.login');
        Route::post('token/refresh', 'AuthApiController@refreshToken')->name('api.v1.auth.refresh_token')->middleware('jwt.auth');
    });

    Route::post('user/signup', 'UserApiController@signup')->name('api.v1.user.signup');

    // Authorization required
    Route::group(['middleware' => 'jwt.auth'], function(){
        // Sapeurs
        Route::get('sapeurs', 'SapeurApiController@index')->name('api.v1.sapeur.index')->middleware('role:effectif_read');
        Route::get('sapeurs/{id}', 'SapeurApiController@show')->name('api.v1.sapeur.show')->middleware('role:effectif_read');
        Route::post('sapeurs', 'SapeurApiController@store')->name('api.v1.sapeur.store')->middleware('role:effectif_read');
        Route::put('sapeurs/{id}', 'SapeurApiController@update')->name('api.v1.sapeur.update')->middleware('role:effectif_read');        

        // Exercices
        Route::get('excusestypes', 'ExerciceApiController@excusesTypes')->name('api.v1.exercice.excusesTypes')->middleware('role:exercice_read');
        Route::get('exercices', 'ExerciceApiController@index')->name('api.v1.exercice.index')->middleware('role:exercice_read');
        Route::get('exercices/{id}', 'ExerciceApiController@show')->name('api.v1.exercice.show')->middleware('role:exercice_read');

        // Interventions
        Route::get('interventions', 'InterventionApiController@index')->name('api.v1.intervention.index')->middleware('role:intervention_read');
        Route::get('interventions/{id}', 'InterventionApiController@show')->name('api.v1.intervention.show')->middleware('role:intervention_read');

        // Vehicules
        Route::get('vehicule', 'VehiculeApiController@index')->name('api.v1.vehicule.index');

        // Materiel
        Route::get('materiel', 'MaterielApiController@index')->name('api.v1.materiel.index');

        // Sis
        Route::get('localities', 'SisApiController@localities')->name('api.v1.sis.localities');

        // Téléphones
        Route::get('telephones', 'TelephoneApiController@index')->name('api.v1.telephone.index');

        // Groupes
        Route::get('groupes', 'GroupeApiController@index')->name('api.v1.groupe.index');

        // Transfert
        Route::get('transfert', 'TransfertApiController@index')->name('api.v1.transfert.index')->middleware('role:transfert_all');
        Route::post('transfert/{slug}', 'TransfertApiController@create')->name('api.v1.transfert.create')->middleware('role:transfert_all');
        Route::put('transfert/{id}/recu', 'TransfertApiController@received')->name('api.v1.transfert.received')->middleware('role:transfert_all');

        // Données de bases
        Route::get('statfederal', 'BaseDataApiController@statfederal')->name('api.v1.basedata.statfederal');
        Route::get('typeintervention', 'BaseDataApiController@typeintervention')->name('api.v1.basedata.typeintervention');
        Route::get('grade', 'BaseDataApiController@grade')->name('api.v1.basedata.grade');
        Route::get('cours', 'BaseDataApiController@cours')->name('api.v1.basedata.cours');
        Route::get('districtlocality', 'BaseDataApiController@districtlocality')->name('api.v1.basedata.districtlocality');
        Route::get('cmedtype', 'BaseDataApiController@cmedtype')->name('api.v1.basedata.cmedtype');
    });
});
