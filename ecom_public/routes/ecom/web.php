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

Route::middleware(['cors'])->group(function () {
    Route::get('/login','LoginController@index')->name('login');
    Route::get('/register','LoginController@index_register')->name('register');
    Route::post('/login','LoginController@login');
    Route::post('/register','LoginController@register');
    Route::get('/logout','LoginController@logout');

    Route::get('/reset-password','ResetPasswordController@index');
    Route::post('/reset-password','ResetPasswordController@reset_password');
    Route::get('/reset-password/change-password','ResetPasswordController@change_password');
    Route::post('/reset-password/change-password','ResetPasswordController@change_password_action');

    Route::get('/login-telepon','LoginTeleponController@index');
    Route::post('/login-telepon','LoginTeleponController@login');
    Route::post('/login-telepon/send-whatsapp','LoginTeleponController@send_whatsapp');

    Route::prefix('syarat-ketentuan')->group(function () {
        Route::view('/', 'ecom.profile.profile-syarat-ketentuan');
    });

    Route::prefix('kebijakan-privasi')->group(function () {
        Route::view('/', 'ecom.profile.profile-kebijakan-privasi');
    });

    Route::get('/', 'Ecom\HomeController@index')->name('home');
    Route::get('/coba-email', 'Ecom\HomeController@coba_email');
    Route::get('/search/{keyword}/{package_slug?}', 'Ecom\HomeController@search');

    Route::prefix('banner')->group(function () {
        Route::get('/detail/{title_slug}', 'Ecom\BannerController@detail');
    });

    Route::get('/category/{package_slug}/{kategori_slug}','Ecom\ProdukController@get_category');

    Route::get('/produk-filter', 'Ecom\ProdukController@produk_filter');
    Route::prefix('produk')->group(function () {
        Route::get('/', 'Ecom\ProdukController@index');
        Route::get('/{slug_master_produk}', 'Ecom\ProdukController@detail');
    });

    Route::group(['middleware' => 'cek_login'], function () {
        //ACTION
        Route::prefix('wishlist')->group(function () {
            Route::get('/', 'Ecom\WishlistController@index');
            Route::get('/store/{master_produk_id}', 'Ecom\WishlistController@store');
            Route::delete('/delete/{master_produk_id}', 'Ecom\WishlistController@delete');
        });

        Route::prefix('cart')->group(function () {
            Route::get('/', 'Ecom\CartController@index');
            Route::get('/list', 'Ecom\CartController@list');
            Route::post('/store', 'Ecom\CartController@store');
            Route::post('/checkout', 'Ecom\CartController@checkout');
            Route::delete('/delete/{id}', 'Ecom\CartController@delete');

            Route::post('/check-potongan-harga-grosir', 'Ecom\CartController@check_potongan_harga_grosir');
        });

        Route::prefix('checkout')->group(function () {
            Route::get('/', 'Ecom\CheckoutController@index');

            Route::post('/transaksi', 'Ecom\CheckoutController@transaksi');
            Route::post('/check-voucher', 'Ecom\CheckoutController@check_voucher');
            Route::post('/check-potongan-harga-grosir', 'Ecom\CheckoutController@check_potongan_harga_grosir');
            Route::post('/check-poin', 'Ecom\CheckoutController@check_poin');
        });

        Route::prefix('pembayaran')->group(function () {
            Route::get('/{uuid}', 'Ecom\PembayaranController@index');
            Route::get('/bayar/{uuid}', 'Ecom\PembayaranController@pembayaran');
        });

        Route::prefix('compare')->group(function () {
            Route::get('/', 'Ecom\CompareController@index');
            Route::get('/store/{master_produk_id}', 'Ecom\CompareController@store');
            Route::delete('/delete/{master_produk_id}', 'Ecom\CompareController@delete');
        });

        //PROFILE
        Route::prefix('profile')->group(function () {
            Route::get('/', 'Ecom\Profile\ProfileController@index')->name('profile');
            Route::get('/detail/{id}/{tipe_customer}', 'Ecom\Profile\ProfileController@detail');
            Route::post('/store-update', 'Ecom\Profile\ProfileController@store_update');

            Route::prefix('upgrade')->group(function () {
                Route::get('/', 'Ecom\Profile\UpgradeController@index');
                Route::get('/detail', 'Ecom\Profile\UpgradeController@detail');
                Route::post('/', 'Ecom\Profile\UpgradeController@upgrade');
            });

            Route::prefix('transaksi-belanja')->group(function () {
                Route::get('/', 'Ecom\Profile\TransaksiBelanjaController@index');

                Route::get('/invoice/{uuid}', 'Ecom\Profile\TransaksiBelanjaController@invoice');
                Route::get('/cancel-pesanan/{uuid}', 'Ecom\Profile\TransaksiBelanjaController@cancel_pesanan');
                Route::get('/terima-pesanan/{uuid}', 'Ecom\Profile\TransaksiBelanjaController@terima_pesanan');
                Route::get('/tracking-order/{uuid}', 'Ecom\Profile\TransaksiBelanjaController@tracking_order');
            });

            Route::prefix('voucher')->group(function () {
                Route::get('/', 'Ecom\Profile\VoucherController@index');
                Route::get('/detail/{kode_voucher}', 'Ecom\Profile\VoucherController@detail');
                Route::get('/action-kode-voucher/{kode_voucher}', 'Ecom\Profile\VoucherController@action_kode_voucher');
            });

            Route::prefix('alamat-pengiriman')->group(function () {
                Route::get('/', 'Ecom\Profile\AlamatPengirimanController@index');
                Route::get('/detail/{id}', 'Ecom\Profile\AlamatPengirimanController@detail');
                Route::post('/store-update', 'Ecom\Profile\AlamatPengirimanController@store_update');
                Route::delete('/delete/{id}', 'Ecom\Profile\AlamatPengirimanController@delete');

                Route::get('/change-alamat-utama/{id}', 'Ecom\Profile\AlamatPengirimanController@change_alamat_utama');
            });

            Route::get('/struk-belanja/{id}/{tipe_customer}', 'Ecom\Profile\StrukBelanjaOfflineController@index');
            Route::prefix('struk-belanja-offline')->group(function () {
                Route::post('/store', 'Ecom\Profile\StrukBelanjaOfflineController@store');
            });

            Route::prefix('notifikasi')->group(function () {
                Route::get('/', 'Ecom\Profile\NotifikasiController@index');
            });

            Route::prefix('penilaian')->group(function () {
                Route::get('/{uuid}', 'Ecom\Profile\PenilaianController@detail');
                Route::post('/store', 'Ecom\Profile\PenilaianController@store');
            });

            Route::prefix('history-poin')->group(function (){
                Route::get('/', 'Ecom\Profile\PoinHistoryController@index');
            });

            Route::prefix('syarat-ketentuan')->group(function () {
                Route::view('/', 'ecom.profile.profile-syarat-ketentuan');
            });

            Route::prefix('kebijakan-privasi')->group(function () {
                Route::view('/', 'ecom.profile.profile-kebijakan-privasi');
            });

            Route::prefix('hubungi-kami')->group(function () {
                Route::view('/', 'ecom.profile.profile-hubungi-kami');
            });
        });
    });
});







