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
Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');

Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');


Auth::routes(['register' => false]);


Route::get('/dashboard', 'HomeController@dashboard');
Route::get('eleves/pourcentage','ElevesController@pourcentage');

Route::resource('eleves', 'ElevesController');
Route::resource('mois', 'MoisController');

Route::resource('payments', 'PaymentsController');
Route::resource('seances', 'SeancesController');
Route::resource('tests', 'TestsController');



Route::get('/eleves/show/all', 'ElevesController@index');
Route::get('/eleves/', 'HomeController@index');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/mois/show/all', 'MoisController@index');
Route::get('/mois/', 'HomeController@index');

Route::get('/mois/{mois}', 'HomeController@index');
Route::get('/mois/payments/{mois}/all', 'MoisController@showOne');
Route::get('/mois/{mois}/all', 'MoisController@show');


Route::get('/payments/show/all', 'PaymentsController@index');
Route::get('/payments/', 'HomeController@index');



Route::get('/tests/show/all', 'TestsController@index');
Route::get('/tests/', 'HomeController@index');



