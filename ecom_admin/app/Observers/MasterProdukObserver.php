<?php

namespace App\Observers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use App\Blameable;
use File;

use App\Models\Cart;
use App\Models\Wishlist;
use App\Models\Compare;
use App\Models\CheckoutTemp;
use App\Models\MasterProduk;
use App\Models\MasterProdukLog;

class MasterProdukObserver
{
    public function updating(MasterProduk $masterProduk)
    {
      if($masterProduk->isDirty('harga_beli')){
        //has changed
        $new_harga = $masterProduk->harga_beli;
        $old_harga = $masterProduk->getOriginal('harga_beli');

        //MASTER PRODUK LOG
        $keterangan = "Perubahan harga beli dari ". "Rp " . number_format($old_harga,0,',','.') ." ke " . "Rp " . number_format($new_harga,0,',','.');

        MasterProdukLog::create([
            'jenis_log' => 'harga',
            'master_produk_id' => $masterProduk->id,
            'keterangan' => $keterangan,
        ]);
      }

      if($masterProduk->isDirty('harga_jual_b2c')){
        //has changed
        $new_harga = $masterProduk->harga_jual_b2c;
        $old_harga = $masterProduk->getOriginal('harga_jual_b2c');

        //MASTER PRODUK LOG
        $keterangan = "Perubahan harga jual B2C dari ". "Rp " . number_format($old_harga,0,',','.') ." ke " . "Rp " . number_format($new_harga,0,',','.');

        MasterProdukLog::create([
            'jenis_log' => 'harga',
            'master_produk_id' => $masterProduk->id,
            'keterangan' => $keterangan,
        ]);
      }

      if($masterProduk->isDirty('harga_jual_b2b')){
        //has changed
        $new_harga = $masterProduk->harga_jual_b2b;
        $old_harga = $masterProduk->getOriginal('harga_jual_b2b');

        //MASTER PRODUK LOG
        $keterangan = "Perubahan harga jual B2B dari ". "Rp " . number_format($old_harga,0,',','.') ." ke " . "Rp " . number_format($new_harga,0,',','.');

        MasterProdukLog::create([
            'jenis_log' => 'harga',
            'master_produk_id' => $masterProduk->id,
            'keterangan' => $keterangan,
        ]);
      }
    }

    public function updated(MasterProduk $masterProduk)
    {
        Cart::where('quantity','>',$masterProduk->stock)->where('master_produk_id', $masterProduk->id)->update(['quantity' => $masterProduk->stock]);
        CheckoutTemp::where('quantity','>',$masterProduk->stock)->where('master_produk_id', $masterProduk->id)->update(['quantity' => $masterProduk->stock]);
    }

    public function deleted(MasterProduk $masterProduk)
    {
        Cart::where('master_produk_id', $masterProduk->id)->delete();
        Wishlist::where('master_produk_id', $masterProduk->id)->delete();
        Compare::where('master_produk_id', $masterProduk->id)->delete();
        CheckoutTemp::where('master_produk_id', $masterProduk->id)->delete();
    }
}
