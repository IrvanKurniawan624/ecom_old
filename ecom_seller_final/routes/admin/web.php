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

Route::middleware(['cors','cek_login'])->group(function () {
    Route::prefix('admin')->group(function () {

        Route::get('/','Admin\DashboardController@index');

        Route::prefix('data-master')->group(function () {

            Route::prefix('master-sosial-media')->group(function () {
                Route::get('/','Admin\DataMaster\MasterInstagramController@index');
                Route::get('/detail/{id}','Admin\DataMaster\MasterInstagramController@detail');
                Route::get('/datatables','Admin\DataMaster\MasterInstagramController@datatables');
                Route::post('/store-update','Admin\DataMaster\MasterInstagramController@store_update');
                Route::delete('/delete/{id}','Admin\DataMaster\MasterInstagramController@delete');
            });
        });

        Route::prefix('produk')->group(function () {

            Route::prefix('produk')->group(function () {
                Route::get('/','Admin\Produk\ProdukController@index');
                Route::get('/add','Admin\Produk\ProdukController@add');
                Route::get('/detail/{id}','Admin\Produk\ProdukController@detail');
                Route::get('/datatables','Admin\Produk\ProdukController@datatables');
                Route::post('/store-update','Admin\Produk\ProdukController@store_update');
                Route::delete('/delete/{id}','Admin\Produk\ProdukController@delete');

                Route::get('/clone/{id}','Admin\Produk\ProdukController@clone');
                Route::post('store-image', 'Admin\Produk\ProdukController@store_image');
                Route::post('action-selected', 'Admin\Produk\ProdukController@action_selected');

                Route::post('import-excel', 'Admin\Produk\ProdukController@import_excel');
                Route::get('export-excel', 'Admin\Produk\ProdukController@export_excel');

                Route::get('/setting-image/{produk_id}','Admin\Produk\SettingImageController@index');
                Route::post('/setting-image/store','Admin\Produk\SettingImageController@store');
            });
        });

        Route::prefix('apps')->group(function () {

            Route::prefix('point')->group(function () {
                Route::get('/','Admin\Apps\PointController@index');
                Route::get('/datatables','Admin\Apps\PointController@datatables');

                Route::post('/add-poin', 'Admin\Apps\PointController@add_poin');
                Route::get('/datatables-history','Admin\Apps\PointController@datatables_history');
            });

            Route::prefix('pembayaran')->group(function () {
                Route::get('/','Admin\Apps\PembayaranController@index');
                Route::post('/qris','Admin\Apps\PembayaranController@qris');
                Route::post('/no-rekening','Admin\Apps\PembayaranController@no_rekening');
                Route::post('/no-telepon','Admin\Apps\PembayaranController@no_telepon');
            });

            Route::prefix('ulasan-pelanggan')->group(function () {
                Route::get('/','Admin\Apps\UlasanPelangganController@index');
                Route::get('/detail/{id}','Admin\Apps\UlasanPelangganController@detail');
                Route::get('/datatables','Admin\Apps\UlasanPelangganController@datatables');
                Route::post('/approve','Admin\Apps\UlasanPelangganController@approve');
            });

            Route::prefix('kode-voucher')->group(function () {
                Route::get('/','Admin\Apps\KodeVoucherController@index');
                Route::get('/detail/{id}','Admin\Apps\KodeVoucherController@detail');
                Route::get('/datatables','Admin\Apps\KodeVoucherController@datatables');
                Route::post('/store-update','Admin\Apps\KodeVoucherController@store_update');
                Route::delete('/delete/{id}','Admin\Apps\KodeVoucherController@delete');

                Route::get('/datatables-history','Admin\Apps\KodeVoucherController@datatables_history');
            });

            Route::prefix('transaksi')->group(function () {
                Route::get('/','Admin\Apps\TransaksiController@index');
                Route::get('/datatables','Admin\Apps\TransaksiController@datatables');
                Route::get('/{uuid}', 'Admin\Apps\TransaksiController@detail');

                Route::get('/approval/{id}/{status}/{resi_pengiriman?}/{jasa_pengiriman_code?}/{type?}', 'Admin\Apps\TransaksiController@approval');
                Route::get('/cetak-resi-pengiriman/{id}', 'Admin\Apps\TransaksiController@cetak_resi_pengiriman');
                Route::get('/cetak-invoice-pdf/{uuid}', 'Admin\Apps\TransaksiController@cetak_invoice_pdf');
                Route::get('/tracking-order/{uuid}', 'Admin\Apps\TransaksiController@tracking_order');
            });

            Route::prefix('jasa-pengiriman')->group(function () {
                Route::get('/','Admin\Apps\JasaPengirimanController@index');
                Route::get('/datatables','Admin\Apps\JasaPengirimanController@datatables');

                Route::get('/action/{id}/{status}','Admin\Apps\JasaPengirimanController@action');

                Route::post('/store-update', 'Admin\Apps\JasaPengirimanController@store_update');
            });

            Route::prefix('broadcast')->group(function () {
                Route::get('/','Admin\Apps\BroadcastController@index');
                Route::get('/datatables','Admin\Apps\BroadcastController@datatables');
                Route::post('/create','Admin\Apps\BroadcastController@create');
            });

            Route::prefix('log')->group(function () {
                Route::get('/','Admin\Apps\LogController@index');
                Route::get('/datatables','Admin\Apps\LogController@datatables');
                Route::get('/datatables-poin','Admin\Apps\LogController@datatables_poin');
            });
        });

        Route::prefix('report')->group(function () {
            Route::prefix('history-pembelian')->group(function () {
                Route::get('/','Admin\Report\PembelianProdukController@index');
                Route::get('/datatables','Admin\Report\PembelianProdukController@datatables');
            });

            Route::prefix('rekap-pembelian')->group(function () {
                Route::get('/','Admin\Report\RekapPembelianController@index');
                Route::get('/datatables','Admin\Report\RekapPembelianController@datatables');
            });

            Route::prefix('produk-terbaik')->group(function () {
                Route::get('/','Admin\Report\ProdukTerbaikController@index');
                Route::get('/datatables','Admin\Report\ProdukTerbaikController@datatables');
            });

            Route::prefix('pembeli-terbaik')->group(function () {
                Route::get('/','Admin\Report\PembeliTerbaikController@index');
                Route::get('/datatables','Admin\Report\PembeliTerbaikController@datatables');

                Route::get('/datatables-history','Admin\Report\PembeliTerbaikController@datatables_history');
            });

            Route::prefix('stok-produk')->group(function () {
                Route::get('/','Admin\Report\StokProdukController@index');
                Route::get('/datatables','Admin\Report\StokProdukController@datatables');
            });
        });

    });
});




