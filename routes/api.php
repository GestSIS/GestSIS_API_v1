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

Route::group(['prefix' => 'v1', 'middleware' => ['jwt']], function(){
    // Login & signup
    Route::group(['prefix' => 'user'], function(){
        Route::post('login', 'UserApiController@login')->name('api.v1.user.login');
        Route::post('signup', 'UserApiController@signup')->name('api.v1.user.signup');
    });

    // Sapeurs
    Route::get('sapeurs', 'SapeurController@list')->name('api.v1.sapeur.list');
    Route::get('sapeurs/{id}', 'SapeurController@get')->name('api.v1.sapeur.list');
});
