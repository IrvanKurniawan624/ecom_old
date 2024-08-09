<?php

namespace App\Http\Controllers\Ecom;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use DB;
use DataTables;
use Carbon\Carbon;

use App\Models\Cart;
use App\Models\AlamatPengiriman;
use App\Models\MasterProduk;
use App\Models\MasterProdukHargaGrosir;

class CartController extends Controller
{

    public function index(){

        // $data['cart'] = Cart::with('master_produk.master_kategori.master_package', 'master_seller')->where('user_id', auth()->user()->id)->orderBy('seller_id')->get();

        $data['package'] = Cart::all();
        $array = [];
        foreach($data['package'] as $item){
            $array[$item->seller_id] = Cart::with('master_produk.master_kategori.master_package', 'master_seller')->where('seller_id', $item->seller_id)->where('user_id', auth()->user()->id)->get();
        }

        $data['cart'] = $array;

        $data['alamat_pengiriman'] = AlamatPengiriman::active()->get();
        $data['alamat_pengiriman_utama'] = AlamatPengiriman::orderBy('alamat_utama','DESC')->first();

        return view('ecom.cart', $data);
    }

    public function checkout(request $request){

        if(empty($request->master_produk_id) || count($request->master_produk_id) == 0){
            return [
                'status' => 300,
                'message' => 'Harap pilih produk terlebih dahulu'
            ];
        }

        $alamat_pengiriman = AlamatPengiriman::first();
        if(empty($alamat_pengiriman)){
            return [
                'status' => 301,
                'message' => 'Oops! proses tidak dapat dilanjutkan. Anda belum membuat alamat pengirimannya',
                'link' => '/profile/alamat-pengiriman'
            ];
        }

        $arr = [];
        $produk_seller = MasterProduk::where('seller_id', $request->seller_id)->get();
        foreach ($produk_seller as $ps){
            $arr[] = $ps->id;
        }

        foreach($request->master_produk_id as $produk){
            if(!in_array($produk, $arr)){
                return [
                    'status' => 300,
                    'message' => "Hanya Dapat Melakukan Checkout Pada Produk dengan Seller yang sama..."
                ];
            }
        }

        $validator = Validator::make($request->all(), [
            'master_produk_id.*' => 'required',
            'cart_quantity.*' => 'required',
        ]);

        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        DB::beginTransaction();

        //DELETE CHECKOUT TEMP
        Cart::where('user_id', auth()->user()->id)->update(['is_checkout' => '0']);

		try{
			foreach($request->master_produk_id as $key => $item){
                if($request->cart_quantity[$key] > 0){
                    $master_produk = MasterProduk::where('id', $item)->first();
                    if($master_produk->minimal_order > $request->cart_quantity[$key]){
                        return [
                            'status' => 300,
                            'message' => 'Minimal pembelian produk ' . $master_produk->nama_produk_desc . ' adalah ' . $master_produk->minimal_order . " " . $master_produk->satuan,
                        ];
                    }

                    if($master_produk->stock < $request->cart_quantity[$key]){
                        return [
                            'status' => 300,
                            'message' => 'Stock produk ' . $master_produk->nama_produk_desc . ' hanya tersisa ' . $master_produk->stock . ' ' . $master_produk->satuan,
                        ];
                    }

                    Cart::where(['user_id' => auth()->user()->id,'master_produk_id' => $item])->update([
                        'quantity' => $request->cart_quantity[$key],
                        'is_checkout' => '1',
                    ]);
                }
            }

			DB::commit();

			return [
				'status' => 201, // SUCCESS
				'link' => '/checkout',
				'message' => 'Horray! selangkah lagi mendapatkan barang impianmu'
			];


		}

		catch(\Exception $e){

			DB::rollback();

			return [
				'status' 	=> 300, // GAGAL
				'message'       => (env('APP_DEBUG', 'true') == 'true')? $e->getMessage() : 'Operation error'
			];

		}
    }

    public function store(request $request){

        try {
            $quantity = $request->quantity;
            $cart = Cart::where(['user_id' => auth()->user()->id, 'master_produk_id' => $request->id])->first();
            if(!empty($cart)){
                $quantity = $cart->quantity + $request->quantity;
            }

            $seller_id = MasterProduk::where('id', $request->id)->first();

            Cart::updateOrCreate(['user_id' => auth()->user()->id, 'master_produk_id' => $request->id],[
                'user_id' => auth()->user()->id,
                'master_produk_id' => $request->id,
                'quantity' => $quantity,
                'seller_id' => $seller_id['seller_id'],
            ]);

            return [
                'status' => 200,
                'total_quantity' => Cart::where('user_id', auth()->user()->id)->sum('quantity'),
                'data' => Cart::with('master_produk.master_kategori.master_package')->where('user_id', auth()->user()->id)->get(),
                'message' => 'Anda berhasil menambahkan cart'
            ];

        } catch (\Exception $e) {

            return [
                'status' => 300,
                'message' => 'Oops Terjadi Kesalahan mohon Hubungi admin (' . $e->getMessage() . ')',
            ];
        }
    }

    function list(){

        if(!empty(auth()->user())){

            $data = Cart::with('master_produk.master_kategori.master_package')->where('user_id', auth()->user()->id)->get();
            return [
                'status' => 200,
                'data' => $data,
            ];
        }
    }

    function delete($id){
        $cart = Cart::find($id);

        $total_harga = $cart->master_produk->harga_jual * $cart->quantity;
        $total_quantity = $cart->quantity;

        $cart->delete();

        return [
            'status' => 200,
            'total_harga' => $total_harga,
            'total_quantity' => $total_quantity,
            'id' => $id,
            'message' => 'Produk berhasil dihapus dari cart'
        ];
    }
}
