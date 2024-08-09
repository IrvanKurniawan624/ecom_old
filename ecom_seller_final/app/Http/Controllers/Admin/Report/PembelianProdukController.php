<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use DB;
use DataTables;
use Carbon\Carbon;

use App\Models\Transaksi;
use App\Models\TransaksiProduk;

class PembelianProdukController extends Controller
{
    public function index(){
        return view('admin.report.pembelian-produk.index');
    }

    public function datatables(){
        
        $data = TransaksiProduk::with('transaksi.user.tipe_customer', 'master_produk')->whereHas('transaksi', function($query){
            $query->where('status', Transaksi::SELESAI)->where('seller_id', auth()->user()->id);
        })->latest()->get();

         return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('produk_image', function($item) {
                        return '<img class="mr-3 rounded" width="55" src="/berkas/master-produk/'. $item->master_produk->url_image[0] .'" alt="product">';
                    })
                    ->addColumn('total_harga', function($item) {
                        return $item->quantity * $item->harga;
                    })
                    ->rawColumns(['produk_image'])
                    ->make(true);
    }
}
