<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use DB;
use DataTables;
use Carbon\Carbon;

use App\Models\TransaksiProduk;

class ProdukTerbaikController extends Controller
{
    public function index(){
        return view('admin.report.produk-terbaik.index');
    }

    public function datatables(){
        $data = TransaksiProduk::select(DB::raw("SUM(quantity) as total_terjual"), 'status', 'master_produk_id')->with('master_produk.master_kategori')->whereHas('transaksi', function($query){
            $query->where('status', 5);
        })->orderBy('total_terjual','DESC')->groupBy('master_produk_id')->get();

         return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('produk_image', function($item) {
                        if(str_contains($item->master_produk, 'api-kharisma.s3')) {
                            return '<img class="mr-3 rounded" width="55" src="'. $item->master_produk->url_image[0] .'" alt="product">';
                        }else{
                            return '<img class="mr-3 rounded" width="55" src="https://seller.SIMANHURA.com/'. $item->master_produk->url_image[0] .'" alt="product">';
                        }
                    })
                    ->rawColumns(['produk_image'])
                    ->make(true);
    }
}
