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

Route::get('/', 'PageController@index')->name('welcome');

Route::get('/autocomplete', 'SearchController@autocomplete');

Route::get('/players/{name}', 'SearchController@player');

Route::get('/{league}/{team?}/{game?}', 'SearchController@index');


//Route::get('import', function(){
//    dd('test');
////    dd(\Artisan::call('importer:import-games'));
//});