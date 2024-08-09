<?php

namespace App\Http\Controllers\Admin\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use DB;
use DataTables;
use Carbon\Carbon;

use App\Models\TransaksiProduk;

class UlasanPelangganController extends Controller
{
    public function index(){
        return view('admin.apps.ulasan-pelanggan.index');
    }

    public function detail($id){
        $data['data'] = TransaksiProduk::with('master_produk', 'transaksi.user')->find($id);
        return view('admin.apps.ulasan-pelanggan.detail', $data);
    }

    public function datatables(){
        $data = TransaksiProduk::with('master_produk', 'transaksi.user')->where('seller_id', auth()->user()->id)->whereNotNull('bintang')->where('status', '<>', '3')->orderBy('status', 'asc')->orderBy('id','desc')->get();

        return DataTables::of($data)
                    ->addIndexColumn()
                    ->make(true);
    }

    public function approve(request $request){
        TransaksiProduk::where('id', $request->id)->update([
            'status' => $request->type,
            'bintang' => $request->bintang,
            'komentar' => $request->komentar,
        ]);

        $message = 'Ulasan produk berhasil ditolak';
        if($request->type == 1){
            $message = 'Ulasan produk berhasil diterima';
        }

        return [
            'status' => 200,
            'message' => $message
        ];
    }
}
