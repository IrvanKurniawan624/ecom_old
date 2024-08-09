<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use DB;
use DataTables;
use Carbon\Carbon;

use App\Models\PoinLog;
use App\Models\MasterProdukLog;

class MutasiKeuanganController extends Controller
{
    // public function index(){
    //     return view('admin.report.mutasi-keuangan.index');
    // }

    // public function datatables(){

    //     $data = MasterProdukLog::with('master_produk')->where(['jenis_log' => 'stock'])->orderBy('id', 'ASC')->get();
    //     $array = [];
    //     $saldo = 0;
    //     foreach($data as $item){
    //         if($item->tipe == '+'){
    //             $saldo += $item->quantity * $item->harga;
    //             $array[] = [
    //                 'tanggal_format' => (int) Carbon::parse($item->created_at_format)->format('ymdHis'),
    //                 'tanggal' => $item->created_at,
    //                 'uang_masuk' => "Rp " . number_format($item->quantity * $item->harga,0,',','.'), //kredit
    //                 'uang_keluar' => '-', //debet
    //                 'keterangan' => 'Penambahan produk ' . $item->master_produk->nama_produk . ' [ '. $item->quantity .' '. $item->master_produk->satuan . ' ] ' . ' [ '. "Rp " . number_format($item->harga,0,',','.') .' ]',
    //                 'saldo' => "Rp " . number_format($saldo,0,',','.'),
    //             ];
    //         }else{
    //             $saldo -= $item->quantity * $item->harga;
    //             $array[] = [
    //                 'tanggal_format' => (int) Carbon::parse($item->created_at_format)->format('ymdHis'),
    //                 'tanggal' => $item->created_at,
    //                 'uang_masuk' => 0, //kredit
    //                 'uang_keluar' => "Rp " . number_format($item->quantity * $item->harga,0,',','.'), //debet
    //                 'keterangan' => 'Pengurangan produk ' . $item->master_produk->nama_produk . ' [ '. $item->quantity .' '. $item->master_produk->satuan . ' ] ' . ' [ '. "Rp " . number_format($item->harga,0,',','.') .' ]',
    //                 'saldo' => "Rp " . number_format($saldo,0,',','.'),
    //             ];
    //         }
    //     }

    //     $data = PoinLog::with('transaksi')->where(['status' => '-'])->orderBy('id','ASC')->get();
    //     foreach($data as $item){
    //         $saldo -= $item->nominal;
    //         $array[] = [
    //             'tanggal_format' => (int) Carbon::parse($item->created_at)->format('ymdHis'),
    //             'tanggal' => $item->created_at_desc,
    //             'uang_masuk' => 0, //kredit
    //             'uang_keluar' => "Rp " . number_format($item->nominal,0,',','.'), //debet
    //             'keterangan' => 'Poin yang digunakan untuk transaksi ' . $item->transaksi->no_invoice,
    //             'saldo' => "Rp " . number_format($saldo,0,',','.'),
    //         ];
    //     }

    //     array_multisort(array_column($array, "tanggal_format"), SORT_DESC, $array);
    //     return DataTables::of($array)
    //                 ->addIndexColumn()
    //                 ->make(true);
    // }
}
