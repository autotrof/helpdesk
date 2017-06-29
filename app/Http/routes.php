<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', [
	'uses'=>'GeneralController@laporan',
	'as'=>'laporan'
]);
Route::post('/',[
	'uses'=>'LaporanController@addLaporan'
]);
Route::get('/laporan_data',[
	'uses'=>'LaporanController@getAll',
	'as'=>'laporan_get_all'
]);
Route::get('/pengumuman',[
	'uses'=>'GeneralController@pengumuman',
	'as'=>'pengumuman'
]);

Route::group(['prefix'=>'intern','as'=>'intern.','middleware'=>'intern_only'],function(){
	Route::get('/',[
		'uses'=>'GeneralController@internLaporan',
		'as'=>'laporan'
	]);
	Route::get('/summary',[
		'uses'=>'GeneralController@internSummary',
		'as'=>'summary'
	]);
	Route::get('/pengumuman',[
		'uses'=>'GeneralController@internPengumuman',
		'as'=>'pengumuman'
	]);
});