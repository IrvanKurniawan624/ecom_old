<?php

use Illuminate\Support\Facades\Route;
use App\Models\Cart;

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
// Route::group(['middleware' => ['cek_login', 'cek_authorize']], function () {

// })

// Route::get('log-viewers', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

//QUERY FROM HELPER
Route::get('count_cart', function () {
    return !empty(auth()->user()) ? Cart::where('user_id', auth()->user()->id)->sum('quantity') : 0;
});

Route::get('get_data_cart', function () {
    return !empty(auth()->user()) ? Cart::with('master_produk')->where('user_id', auth()->user()->id)->get() : 'null';
});

Route::prefix('master')->group(function () {
    Route::get('/get-data-all/{model}','DataMasterController@get_data_all');
    Route::get('/get-data-by-id/{model}/{id}','DataMasterController@get_data_by_id');
    Route::get('/get-data-where-field-id/{model}/{where_field}/{id}','DataMasterController@get_data_where_field_id');

    Route::get('/data-urutan-subkategori-by-id/{subkategori_id}','DataMasterController@data_urutan_subkategori_by_id');
    Route::get('/data-master-properties-by-kategori/{master_kategori_id}','DataMasterController@data_master_properties_by_kategori');
    Route::get('/data-user-customer-all','DataMasterController@data_user_customer_all');
    Route::get('/data-master-produk-active','DataMasterController@data_master_produk_active');
    Route::get('/data-master-produk-active-by-master-package/{master_package_id}','DataMasterController@data_master_produk_active_by_master_package');
    Route::get('/data-kode-voucher-claim-active-by-user-id','DataMasterController@data_kode_voucher_claim_active_by_user_id');

    Route::get('/datatables-subkategori-by-kategori/{master_kategori_id}','DataMasterController@datatables_subkategori_by_kategori');

    Route::get('api-provinsi','DataMasterController@api_get_province');
    Route::get('api-city-by-provinsi/{provinsi_id}','DataMasterController@api_get_city_by_province');
    Route::get('api-kecamatan-by-city/{city_id}','DataMasterController@api_get_kecamatan_by_city');
    Route::get('api-ongkos-kirim/{kota_tujuan_id}/{berat}/{seller_id}','DataMasterController@api_get_ongkos_kirim');
    Route::get('api-waybill/{courier}/{waybill}','DataMasterController@api_get_waybill');
});

Route::prefix('errors')->group(function () {
    Route::view('/401', 'errors.404');
    Route::view('/404', 'errors.404');
    Route::view('/maintenance', 'errors.maintenance');
    Route::view('/transaksi-berhasil', 'errors.transaksi-berhasil');
    Route::view('/upgrade-berhasil', 'errors.upgrade-berhasil');
    Route::view('/checkout-gagal', 'errors.checkout-gagal');
    Route::view('/resi-tidak-ditemukan', 'errors.resi-tidak-ditemukan');
    Route::view('/sudah-bayar', 'errors.sudah-bayar');
    Route::view('/no-internet', 'errors.no-internet');
    Route::view('/transaksi-tidak-ditemukan', 'errors.transaksi-tidak-ditemukan');
    Route::view('/hubungi-kami', 'errors.hubungi-kami');
});

Route::get('/', function () {
    return view('welcome');
});
