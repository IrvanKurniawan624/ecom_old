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

class PembeliTerbaikController extends Controller
{
    public function index(){
        return view('admin.report.pembeli-terbaik.index');
    }

    public function datatables(){
        $data = Transaksi::select(DB::raw("SUM((total_harga-harga_pengiriman)) as total_pembelian"),'status','created_at','user_id')->with('user.tipe_customer')->where(['status' => Transaksi::SELESAI])->groupBy('user_id')->orderBy('total_pembelian', 'DESC')->get();

         return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('tanggal_pendaftaran', function($item) {
                        return \Carbon\Carbon::parse( $item->user->created_at )->isoFormat('D MMMM Y');
                    })
                    ->make(true);
    }

    public function datatables_history(request $request){
        $user_id = $request->user_id;
        $data = TransaksiProduk::with('transaksi.user.tipe_customer', 'master_produk')->whereHas('transaksi', function($query) use ($user_id){
            $query->where(['status' => Transaksi::SELESAI, 'user_id' => $user_id]);
        })->latest()->get();

         return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('produk_image', function($item) {
                return '<img class="mr-3 rounded" width="55" src="https://seller.SIMANHURA.com/'. $item->master_produk->url_image[0] .'" alt="product">';
            })
            ->addColumn('total_harga', function($item) {
                return $item->quantity * $item->harga;
            })
            ->rawColumns(['produk_image'])
            ->make(true);
    }
}
