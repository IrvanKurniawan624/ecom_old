<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use DB;
use DataTables;
use Carbon\Carbon;

use App\Models\MasterProduk;

class StokProdukController extends Controller
{
    public function index(){
        return view('admin.report.stok-produk.index');
    }

    public function datatables(){
        $data = MasterProduk::with('master_kategori.master_package')->get()->sortBy('safety_stock');
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('produk_image', function($item) {
                if(str_contains($item->url_image[0], 'api-kharisma.s3')) {
                    return '<img class="mr-3 rounded" width="55" src="'. $item->url_image[0] .'" alt="product">';
                }else{
                    return '<img class="mr-3 rounded" width="55" src="https://seller.SIMANHURA.com/'. $item->url_image[0] .'" alt="product">';
                }
            })
            ->rawColumns(['produk_image'])
            ->make(true);
    }
}
