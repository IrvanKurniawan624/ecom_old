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

            Route::prefix('master-package')->group(function () {
                Route::get('/','Admin\DataMaster\MasterPackageController@index');
                Route::get('/detail/{id}','Admin\DataMaster\MasterPackageController@detail');
                Route::get('/datatables','Admin\DataMaster\MasterPackageController@datatables');
                Route::post('/store-update','Admin\DataMaster\MasterPackageController@store_update');
                Route::delete('/delete/{id}','Admin\DataMaster\MasterPackageController@delete');
            });

            Route::prefix('master-dictionary')->group(function () {
                Route::get('/','Admin\DataMaster\MasterDictionaryController@index');
                Route::get('/detail/{id}','Admin\DataMaster\MasterDictionaryController@detail');
                Route::get('/datatables','Admin\DataMaster\MasterDictionaryController@datatables');
                Route::post('/store-update','Admin\DataMaster\MasterDictionaryController@store_update');
                Route::delete('/delete/{id}','Admin\DataMaster\MasterDictionaryController@delete');
            });

            Route::prefix('master-banner')->group(function () {
                Route::get('/','Admin\DataMaster\MasterBannerController@index');
                Route::get('/detail/{id}','Admin\DataMaster\MasterBannerController@detail');
                Route::get('/datatables','Admin\DataMaster\MasterBannerController@datatables');
                Route::post('/store-update','Admin\DataMaster\MasterBannerController@store_update');
                Route::delete('/delete/{id}','Admin\DataMaster\MasterBannerController@delete');
            });

            Route::prefix('master-user')->group(function () {
                Route::get('/','Admin\DataMaster\MasterUserController@index');
                Route::get('/detail/{id}','Admin\DataMaster\MasterUserController@detail');
                Route::get('/datatables','Admin\DataMaster\MasterUserController@datatables');
                Route::post('/store-update','Admin\DataMaster\MasterUserController@store_update');
                Route::delete('/delete/{id}','Admin\DataMaster\MasterUserController@delete');

                Route::get('/reset-password/{id}','Admin\DataMaster\MasterUserController@reset_password');
            });

            Route::prefix('master-sosial-media')->group(function () {
                Route::get('/','Admin\DataMaster\MasterInstagramController@index');
                Route::get('/detail/{id}','Admin\DataMaster\MasterInstagramController@detail');
                Route::get('/datatables','Admin\DataMaster\MasterInstagramController@datatables');
                Route::post('/store-update','Admin\DataMaster\MasterInstagramController@store_update');
                Route::delete('/delete/{id}','Admin\DataMaster\MasterInstagramController@delete');
            });

            Route::prefix('master-poin')->group(function () {
                Route::get('/','Admin\DataMaster\MasterPoinController@index');
                Route::get('/detail/{id}','Admin\DataMaster\MasterPoinController@detail');
                Route::get('/datatables','Admin\DataMaster\MasterPoinController@datatables');
                Route::post('/store-update','Admin\DataMaster\MasterPoinController@store_update');

                Route::post('/store-pendapatan-belanja','Admin\DataMaster\MasterPoinController@store_pendapatan_belanja');
                Route::post('/store-minimal-use-poin','Admin\DataMaster\MasterPoinController@store_minimal_use_poin');
            });

            Route::prefix('master-supplier')->group(function () {
                Route::get('/','Admin\DataMaster\MasterSupplierController@index');
                Route::get('/detail/{id}','Admin\DataMaster\MasterSupplierController@detail');
                Route::get('/datatables','Admin\DataMaster\MasterSupplierController@datatables');
                Route::post('/store-update','Admin\DataMaster\MasterSupplierController@store_update');
            });
        });

        Route::prefix('produk')->group(function () {
            Route::prefix('kategori-produk')->group(function () {
                Route::get('/','Admin\Produk\KategoriProdukController@index');
                Route::get('/detail/{id}','Admin\Produk\KategoriProdukController@detail');
                Route::get('/datatables','Admin\Produk\KategoriProdukController@datatables');
                Route::post('/store-update','Admin\Produk\KategoriProdukController@store_update');
                Route::delete('/delete/{id}','Admin\Produk\KategoriProdukController@delete');
            });

            Route::prefix('subkategori')->group(function () {
                Route::get('/','Admin\Produk\SubkategoriProdukController@index');
                Route::get('/detail/{id}','Admin\Produk\SubkategoriProdukController@detail');
                Route::get('/datatables','Admin\Produk\SubkategoriProdukController@datatables');
                Route::post('/store-update','Admin\Produk\SubkategoriProdukController@store_update');
                Route::delete('/delete/{id}','Admin\Produk\SubkategoriProdukController@delete');
            });
        });

        Route::prefix('pelanggan')->group(function () {
            Route::prefix('tipe-pelanggan')->group(function () {
                Route::get('/','Admin\Pelanggan\TipePelangganController@index');
                Route::get('/add','Admin\Pelanggan\TipePelangganController@add');
                Route::get('/detail/{id}','Admin\Pelanggan\TipePelangganController@detail');
                Route::get('/datatables','Admin\Pelanggan\TipePelangganController@datatables');
                Route::post('/store-update','Admin\Pelanggan\TipePelangganController@store_update');
                Route::delete('/delete/{id}','Admin\Pelanggan\TipePelangganController@delete');
            });

            Route::prefix('data-pelanggan')->group(function () {
                Route::get('/','Admin\Pelanggan\PelangganController@index');
                Route::get('/add','Admin\Pelanggan\PelangganController@add');
                Route::get('/detail/{id}','Admin\Pelanggan\PelangganController@detail');
                Route::get('/datatables','Admin\Pelanggan\PelangganController@datatables');
                Route::post('/store-update','Admin\Pelanggan\PelangganController@store_update');
                Route::get('/action/{id}/{status}','Admin\Pelanggan\PelangganController@action');

                Route::get('/export-excel','Admin\Pelanggan\PelangganController@export_excel');
                Route::post('/import-excel','Admin\Pelanggan\PelangganController@import_excel');
            });
        });

        Route::prefix('apps')->group(function () {

            Route::prefix('point')->group(function () {
                Route::get('/','Admin\Apps\PointController@index');
                Route::get('/datatables','Admin\Apps\PointController@datatables');

                Route::post('/add-poin', 'Admin\Apps\PointController@add_poin');
                Route::get('/datatables-history','Admin\Apps\PointController@datatables_history');
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
                Route::get('/datatables2','Admin\Apps\JasaPengirimanController@datatables2');
                Route::get('/detail/{id}','Admin\Apps\JasaPengirimanController@detail');
                Route::get('/delete/{id}','Admin\Apps\JasaPengirimanController@delete');

                Route::get('/action/{id}/{status}','Admin\Apps\JasaPengirimanController@action');
            });

            Route::prefix('point-struk-offline')->group(function () {
                Route::get('/','Admin\Apps\PointStrukOfflineController@index');
                Route::get('/datatables','Admin\Apps\PointStrukOfflineController@datatables');
                Route::get('/detail/{id}','Admin\Apps\PointStrukOfflineController@detail');

                Route::post('/approve','Admin\Apps\PointStrukOfflineController@approve');
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

            Route::prefix('mutasi-keuangan')->group(function () {
                Route::get('/','Admin\Report\MutasiKeuanganController@index');
                Route::get('/datatables','Admin\Report\MutasiKeuanganController@datatables');
            });
        });

    });
});






