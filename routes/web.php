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

Route::get('connexion', 'UserController@showConnectionForm')->name('user.login');
Route::get('tableau-de-bord', 'UserController@showDashboard')->name('user.dashboard');

// Sapeurs
Route::get('sapeurs', 'SapeurController@showIndex')->name('sapeur.index');

Route::get('user/activate', 'UserController@activate')->name('user.activate');
