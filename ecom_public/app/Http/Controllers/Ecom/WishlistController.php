<?php

namespace App\Http\Controllers\Ecom;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use DB;
use DataTables;
use Carbon\Carbon;

use App\Models\Cart;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    public function index(){
        $data['data'] = Wishlist::with('master_produk')->where('user_id', auth()->user()->id)->get();
        return view('ecom.wishlist', $data);
    }

    public function store($master_produk_id){
        try {

            Wishlist::updateOrCreate(['user_id' => auth()->user()->id, 'master_produk_id' => $master_produk_id],[
                'user_id' => auth()->user()->id,
                'master_produk_id' => $master_produk_id,
            ] );

            return [
                'status' => 200,
                'data' => Wishlist::where(['user_id' => auth()->user()->id])->count(),
                'message' => 'Anda berhasil menambahkan wishlist'
            ];

        } catch (\Exception $e) {

            return [
                'status' => 300,
                'message' => 'Oops Terjadi Kesalahan mohon Hubungi admin kharisma (' . $e->getMessage() . ')',
            ];
        }
    }

    public function delete($master_produk_id){
        Wishlist::where(['user_id' => auth()->user()->id, 'master_produk_id' => $master_produk_id])->delete();

        return [
            'status' => 200,
            'data' => Wishlist::where(['user_id' => auth()->user()->id])->count(),
            'message' => 'Anda berhasil menghapus wishlist'
        ];
    }
}
