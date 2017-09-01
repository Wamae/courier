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

Route::get('/package_types/grid', 'Package_typesController@grid');
Route::resource('/package_types', 'Package_typesController');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/main_offices/grid', 'Main_officesController@grid');
Route::resource('/main_offices', 'Main_officesController');

Route::get('/clients/grid', 'ClientsController@grid');
Route::resource('/clients', 'ClientsController');

Route::get('/manifests/grid', 'ManifestsController@grid');
Route::resource('/manifests', 'ManifestsController');

Route::get('/stations/grid', 'StationsController@grid');
Route::resource('/stations', 'StationsController');

Route::get('/payment_modes/grid', 'Payment_modesController@grid');
Route::resource('/payment_modes', 'Payment_modesController');

Route::get('/waybills/grid', 'WaybillsController@grid');
Route::resource('/waybills', 'WaybillsController');

Route::get('/test_tables/grid', 'Test_tablesController@grid');
Route::resource('/test_tables', 'Test_tablesController');

Route::get('/waybill_statuses/grid', 'Waybill_statusesController@grid');
Route::resource('/waybill_statuses', 'Waybill_statusesController');

Route::get('/waybill_manifests/grid', 'Waybill_manifestsController@grid');
Route::get('/waybill_manifests', 'Waybill_manifestsController@index');
Route::get('/waybill_manifests/{manifest}', 'Waybill_manifestsController@show');
Route::get('/waybill_manifests/filters/{manifest}', 'Waybill_manifestsController@filters');
Route::get('/waybill_manifests/filter_grid/{manifest}', 'Waybill_manifestsController@filter_grid');
Route::post('/waybill_manifests/add_batch', 'Waybill_manifestsController@add_batch');
Route::post('/waybill_manifests/remove_batch', 'Waybill_manifestsController@remove_batch');
