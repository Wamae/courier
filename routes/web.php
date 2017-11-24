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
    return view('auth/login');
});

Route::group(['middleware' => ['isAdmin']], function () {
    Route::get('/package_types/grid', 'PackageTypesController@grid');
    Route::resource('/package_types', 'PackageTypesController');

    Route::get('/main_offices/grid', 'MainOfficesController@grid');
    Route::resource('/main_offices', 'MainOfficesController');

    Route::get('/clients/grid', 'ClientsController@grid');
    Route::resource('/clients', 'ClientsController');

    Route::get('/stations/grid', 'StationsController@grid');
    Route::resource('/stations', 'StationsController');

    Route::get('/payment_modes/grid', 'PaymentModesController@grid');
    Route::resource('/payment_modes', 'PaymentModesController');

	Route::get('/manifests/grid', 'ManifestsController@grid');
    Route::resource('/manifests', 'ManifestsController');
    Route::post('/manifests/dispatch_manifest', 'ManifestsController@dispatch_manifest');
    Route::get('/manifests/print_manifest/pdf', 'ManifestsController@print_manifest');
    Route::get('/manifests/manifest_no/autocomplete', 'ManifestsController@autocomplete');
    Route::get('/manifests/offload/manifest', 'ManifestsController@offload_manifest'); 
	
    Route::get('/waybill_statuses/grid', 'WaybillStatusesController@grid');
    Route::resource('/waybill_statuses', 'WaybillStatusesController');

    Route::resource('/users', 'UserController');
    Route::resource('/roles', 'RoleController');
    Route::resource('/permissions', 'PermissionController');

    Route::get('/test_tables/grid', 'TestTablesController@grid');
    Route::resource('/test_tables', 'TestTablesController');
    
    /*Reports*/
    Route::get('/user_reports/grid', 'UserReportsController@grid'); 
    Route::get('/user_reports/print_waybill/pdf', 'UserReportsController@print_waybill');
    Route::resource('/user_reports', 'UserReportsController'); 
    
    Route::resource('/station_reports', 'StationReportsController'); 
    Route::get('/station_reports/get_report_data', 'StationReportsController@get_report_data'); 
    
    Route::resource('/client_reports', 'ClientReportsController'); 
    
    Route::get('/invoices/grid', 'InvoicesController@grid'); 
    Route::get('/invoices/get_waybills/{invoice_id}', 'InvoicesController@getWaybills');  
    Route::get('/invoices/get_transactions/{invoice_id}', 'InvoicesController@getTransactions');  
    Route::resource('/invoices', 'InvoicesController');   
    Route::get('/invoices/{id}', 'InvoicesController@show');
    Route::post('/invoices/cancel_invoices', 'InvoicesController@cancelInvoices');  
    
    Route::resource('/transactions', 'TransactionsController');
    
});

Auth::routes();

Route::get('/home', 'WaybillsController@index')->name('home');

Route::get('/waybills/tracking/status', 'WaybillsController@tracking');
Route::get('/waybills/tracking/trackWaybill/{waybillNo}', 'WaybillsController@trackWaybill');

Route::group(['middleware' => ['role:staff']], function () {

    Route::get('/manifests/grid', 'ManifestsController@grid');
    Route::resource('/manifests', 'ManifestsController');
    Route::post('/manifests/dispatch_manifest', 'ManifestsController@dispatch_manifest');
    Route::get('/manifests/print_manifest/pdf', 'ManifestsController@print_manifest');
    Route::get('/manifests/manifest_no/autocomplete', 'ManifestsController@autocomplete');
    Route::get('/manifests/offload/manifest', 'ManifestsController@offload_manifest');    
    //Route::post('/manifests/manifest/offload', 'ManifestsController@offload');

    Route::get('/waybills/grid', 'WaybillsController@grid');
    Route::resource('/waybills', 'WaybillsController');
    Route::get('/waybills/print_waybill/pdf', 'WaybillsController@print_waybill');
    //Route::get('/waybills/tracking/status', 'WaybillsController@tracking');
    //Route::get('/waybills/tracking/trackWaybill/{waybillNo}', 'WaybillsController@trackWaybill');


    Route::get('/waybill_manifests/grid/{manifest}', 'WaybillManifestsController@grid');
    Route::get('/waybill_manifests', 'WaybillManifestsController@index');
    Route::get('/waybill_manifests/{manifest}', 'WaybillManifestsController@show');
    Route::get('/waybill_manifests/filters/{manifest}', 'WaybillManifestsController@filters');
    Route::get('/waybill_manifests/filter_grid/{manifest}', 'WaybillManifestsController@filter_grid');
    Route::post('/waybill_manifests/add_batch', 'WaybillManifestsController@add_batch');
    Route::post('/waybill_manifests/remove_batch', 'WaybillManifestsController@remove_batch'); 
    /*Reports*/
    Route::get('/user_reports/grid', 'UserReportsController@grid'); 
    Route::get('/user_reports/print_waybill/pdf', 'UserReportsController@print_waybill');
    Route::resource('/user_reports', 'UserReportsController'); 
    
    Route::resource('/station_reports', 'StationReportsController'); 
    Route::get('/station_reports/get_report_data/extra/', 'StationReportsController@get_report_data'); 
    
    Route::resource('/client_reports', 'ClientReportsController'); 
    
    Route::get('/invoices/grid', 'InvoicesController@grid'); 
    Route::get('/invoices/get_waybills/{invoice_id}', 'InvoicesController@getWaybills');  
    Route::get('/invoices/get_transactions/{invoice_id}', 'InvoicesController@getTransactions');
    Route::resource('/invoices', 'InvoicesController');  
    Route::get('/invoices/{id}', 'InvoicesController@show');
    Route::post('/invoices/cancel_invoices', 'InvoicesController@cancelInvoices'); 
    
    Route::resource('/transactions', 'TransactionsController');
       
    
});

