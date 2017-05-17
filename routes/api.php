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
    Route::group(['prefix' => 'user'], function(){
        Route::post('login', 'UserApiController@login')->name('api.v1.user.connect');
        Route::get('check-token', 'UserApiController@checkToken');
    });
});
