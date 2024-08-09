<?php

use Illuminate\Support\Facades\Route;

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

// });

Route::get('wa/scan', 'WaController@scan');
Route::get('wa/send-chat', 'WaController@sendChat');

Route::get('/','LoginController@index')->name('login');
Route::post('/login','LoginController@login');
Route::get('/logout','LoginController@logout');

Route::group(['middleware' => ['cek_login']], function () {

    Route::prefix('dashboard')->group(function () {
        Route::get('/','Admin\DashboardController@index')->name('dashboard');
        Route::get('/datatables-safety-stock','Admin\DashboardController@datatable_safety_stock');

        Route::get('/chart','Admin\DashboardController@chart');
    });

    Route::prefix('change-password')->group(function () {
        Route::get('/','LoginController@change_password');
        Route::post('/action-change-password','LoginController@action_change_password');
    });

    Route::prefix('master')->group(function () {
        Route::get('/get-data-all/{model}','DataMasterController@get_data_all');
        Route::get('/get-data-all-active/{model}','DataMasterController@get_data_all_active');
        Route::get('/get-data-by-id/{model}/{id}','DataMasterController@get_data_by_id');
        Route::get('/get-data-where-field-id_get/{model}/{where_field}/{id}','DataMasterController@get_data_where_field_id_get');
        Route::get('/get-data-where-field-id_first/{model}/{where_field}/{id}','DataMasterController@get_data_where_field_id_first');

        Route::get('/data-urutan-subkategori-by-id/{subkategori_id}','DataMasterController@data_urutan_subkategori_by_id');
        Route::get('/data-master-properties-by-kategori/{master_kategori_id}','DataMasterController@data_master_properties_by_kategori');
        Route::get('/data-user-customer-all','DataMasterController@data_user_customer_all');
        Route::get('/data-master-produk-active','DataMasterController@data_master_produk_active');
        Route::get('/data-master-produk-active-by-master-package/{master_package_id}','DataMasterController@data_master_produk_active_by_master_package');

        Route::get('/data-statistik-pesanan-dashboard/{tipe}','DataMasterController@data_statistik_pesanan_dashboard');

        Route::get('api-provinsi','DataMasterController@api_get_province');
        Route::get('api-city-by-provinsi/{provinsi_id}','DataMasterController@api_get_city_by_province');
        Route::get('api-kecamatan-by-city/{city_id}','DataMasterController@api_get_kecamatan_by_city');

        Route::get('/datatables-subkategori-by-kategori/{master_kategori_id}','DataMasterController@datatables_subkategori_by_kategori');
        Route::get('/datatables-master-produk','DataMasterController@datatable_master_produk');
        Route::get('/datatables-master-produk-active','DataMasterController@datatable_master_produk_active');
        Route::get('/datatables-marketplace-transaksi-produk-by-transaksi/{id}','DataMasterController@datatables_marketplace_transaksi_produk_by_transaksi');
        Route::get('/datatables-pembelian-produk-hutang-belum-lunas','DataMasterController@datatables_pembelian_produk_hutang_belum_lunas');

    });

    Route::prefix('error')->group(function () {
        Route::view('/401', 'errors.404');
        Route::view('/404', 'errors.404');
        Route::view('/under-maintenance', 'errors.under-maintenance');
    });
});

