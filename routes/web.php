<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Authentication
Route::get('connexion', 'UserController@showConnectionForm')->name('user.connection');
Route::post('connexion', 'UserController@login')->name('user.login');
Route::post('deconnexion', 'UserController@logout')->name('user.logout');

// Mot de passe oublié
Route::get('mot-passe-oublie', 'UserController@showForgotPasswordForm')->name('user.forgot_password_form');
Route::post('mot-passe-oublie', 'UserController@sendForgotPasswordEmail')->name('user.forgot_password');
//Route::get('reinitialiser-mp', 'UserController@showResetPasswordForm')->name('user.reset_password_form');
//Route::post('reinitialiser-mp', 'UserController@resetPassword')->name('user.reset_password');

// Authorization required
Route::group(['middleware' => 'session.auth'], function(){
    Route::get('tableau-de-bord', 'UserController@showDashboard')->name('user.dashboard');

    // Sapeurs
    Route::get('sapeurs', 'SapeurController@showDetails')->name('sapeur.index');
    Route::get('sapeurs/{id}', 'SapeurController@showDetails')->name('sapeur.details');
    Route::get('sapeurs/create', 'SapeurController@showDetails')->name('sapeur.create');
});

Route::get('user/activate', 'UserController@activate')->name('user.activate');
