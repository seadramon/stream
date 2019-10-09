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

Auth::routes();

Route::get('/', 		['as' => 'index', 'uses' => 'HomeController@index', 'middleware' => 'auth']);

Route::post('tvradio/export', ['as' => 'tvradio.export', 'uses' => 'TvradioController@export']);
Route::get('tvradio/play/{id}', ['as' => 'tvradio.play', 'uses' => 'TvradioController@play']);
Route::resource('tvradio', 'TvradioController');