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

class RekapPembelianController extends Controller
{
    public function index(){
        return view('admin.report.rekap-pembelian.index');
    }

    public function datatables(request $request){

        $data = TransaksiProduk::with('transaksi.user.tipe_customer', 'master_produk.master_kategori')->whereHas('transaksi', function($query){
            $query->where('status', Transaksi::SELESAI)->orWhere('seller_id', auth()->user()->id);
        });

        if(!empty($request->tanggal_mulai)){
            $data = $data->whereBetween('created_at',[$request->tanggal_mulai, $request->tanggal_selesai]);
        }

        $data = $data->select('*', DB::raw('SUM(quantity) AS total_quantity'))->groupBy('master_produk_id')->orderBy('total_quantity','DESC')->get();

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
