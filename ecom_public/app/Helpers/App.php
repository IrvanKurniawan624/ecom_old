<?php
namespace App\Helpers;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;
use App\Models\MasterPackage;
use App\Models\MasterSubkategori;
use App\Models\Wishlist;
use App\Models\Cart;
use App\Models\Compare;
use App\Models\Transaksi;
use App\Models\Notification;
use App\Models\TransaksiProduk;

class App {

    public static function get_master_package(){
        return MasterPackage::all();
    }

    public static function count_notification(){
        return !empty(auth()->user()) ? Notification::where(['user_id' => auth()->user()->id, 'is_new' => '1'])->count() : 0;
    }

    public static function get_data_notification(){
        return !empty(auth()->user()) ? Notification::where('user_id', auth()->user()->id)->latest()->get() : 'null';
    }

    public static function count_wishlist(){
        return !empty(auth()->user()) ? Wishlist::where('user_id', auth()->user()->id)->count() : 0;
    }

    public static function count_cart(){
        return !empty(auth()->user()) ? Cart::where('user_id', auth()->user()->id)->sum('quantity') : 0;
    }

    public static function get_data_cart(){
        return !empty(auth()->user()) ? Cart::with('master_produk')->where('user_id', auth()->user()->id)->get() : 'null';
    }

    public static function count_compare(){
        return !empty(auth()->user()) ? Compare::where('user_id', auth()->user()->id)->count() : 0;
    }

    public static function count_menunggu_pembayaran(){
        return !empty(auth()->user()) ? Transaksi::where(['user_id' => auth()->user()->id, 'status' => Transaksi::BELUM_BAYAR ])->count() : 0;
    }

    public static function count_dikemas(){
        return !empty(auth()->user()) ? Transaksi::where(['user_id' => auth()->user()->id, 'status' => Transaksi::DIKEMAS ])->count() : 0;
    }

    public static function count_dikirim(){
        return !empty(auth()->user()) ? Transaksi::where(['user_id' => auth()->user()->id, 'status' => Transaksi::DIKIRIM ])->count() : 0;
    }

    public static function count_selesai(){
        return !empty(auth()->user()) ? Transaksi::where(['user_id' => auth()->user()->id, 'status' => Transaksi::SELESAI ])->count() : 0;
    }

    public static function count_beri_penilaian(){
        if(!auth()->check()){
            return 0;
        }else{
            return TransaksiProduk::whereHas('transaksi', function($query){
                $query->where('user_id', auth()->user()->id);
            })->whereNull('bintang')->groupBy('transaksi_id')->count();
        }
    }
    
    
    public static function gantiformat($nomorhp){
        
        $nomorhp = trim($nomorhp);
        $nomorhp = strip_tags($nomorhp);     
        $nomorhp= str_replace(" ","",$nomorhp);
        $nomorhp= str_replace("(","",$nomorhp);
        $nomorhp= str_replace(".","",$nomorhp); 
   
        if(!preg_match('/[^+0-9]/',trim($nomorhp))){
            if(substr(trim($nomorhp), 0, 3)=='+62'){
                $nomorhp= trim($nomorhp);
            }
           elseif(substr($nomorhp, 0, 1)=='0'){
                $nomorhp= '+62'.substr($nomorhp, 1);
            }
        }

        return $nomorhp;

    }
}
?>
