<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

use DataTables;
use \Carbon\Carbon;
use Carbon\CarbonPeriod;

use App\Models\User;
use App\Models\Transaksi;
use App\Models\TransaksiProduk;
use App\Models\MasterProduk;
use App\Models\PoinStrukOffline;

class DashboardController extends Controller
{
    public function index(){
        $data['count_new_transaksi'] = Transaksi::where('status', Transaksi::KONFIRMASI_ADMIN)->count();
        $data['count_ulasan_baru'] = TransaksiProduk::where(['status' => 0])->whereNotNull('bintang')->count();
        $data['count_poin_struk_offline'] = PoinStrukOffline::where(['status' => 0])->count();
        $data['pelanggan_baru_bulan_ini'] = User::customerAll()->active()->whereMonth('created_at', Carbon::now())->count();
        $data['total_pelanggan'] = User::customerAll()->active()->count();
        $data['total_produk_terjual'] = TransaksiProduk::whereHas('transaksi', function($query){
                                            $query->where('status', Transaksi::SELESAI);
                                        })->sum('quantity');
        $data['keuntungan_hari_ini'] = Transaksi::where('status', Transaksi::SELESAI)->whereDate('updated_at', Carbon::today())->sum(\DB::raw('total_harga - harga_pengiriman'));
        $data['keuntungan_bulan_ini'] = Transaksi::where('status', Transaksi::SELESAI)->whereMonth('created_at', Carbon::now()->format('m'))->sum(\DB::raw('total_harga - harga_pengiriman'));
        $data['top_produk_bulan_ini'] = TransaksiProduk::with('master_produk.master_kategori.master_package')->selectRaw('*, sum(quantity) as quantity')->whereHas('transaksi', function($query){
                                            $query->where('status', Transaksi::SELESAI)->whereMonth('updated_at', Carbon::today()->format('m'));
                                        })->groupBy('master_produk_id')->orderBy('quantity', 'DESC')->get()->take(5);
        $data['top_produk_tahun_ini'] = TransaksiProduk::with('master_produk.master_kategori.master_package')->selectRaw('*, sum(quantity) as quantity')->whereHas('transaksi', function($query){
                                            $query->where('status', Transaksi::SELESAI)->whereYear('updated_at', Carbon::now()->format('Y'));
                                        })->groupBy('master_produk_id')->orderBy('quantity', 'DESC')->get()->take(5);

        return view('admin.dashboard.index', $data);
    }

    public function datatable_safety_stock(){
        $data = MasterProduk::with('master_kategori.master_package')->get()->where('safety_stock', '<', 25)->sortBy('safety_stock');
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function chart(){
        $year_month = Carbon::now()->format('Y-m');

        $startMonth = Carbon::parse($year_month)->startOfMonth()->format('Y-m-d');
        $endMonth = Carbon::parse($year_month)->endOfMonth()->format('Y-m-d');

        $result = CarbonPeriod::create($startMonth, $endMonth);

        $label = [];
        $penjualan_harian = [];
        $keuntungan_harian = [];


        foreach($result as $range_date){
            $tanggal = $range_date->format('Y-m-d');
            $label[] = $range_date->format('d');

            $penjualan = Transaksi::where('status', Transaksi::SELESAI)->whereDate('updated_at', $tanggal)->sum(\DB::raw('total_harga - harga_pengiriman'));
            $penjualan_harian[] = $penjualan;

            //KEUNTUNGAN
            $transaksi = TransaksiProduk::with('master_produk')->whereHas('transaksi', function($query) use ($tanggal){
                $query->where('status', Transaksi::SELESAI)->whereDate('updated_at', $tanggal);
            })->get();


            $keuntungan = 0;
            foreach($transaksi as $item){
                $keuntungan += ($item->harga - $item->master_produk->harga_beli) * $item->quantity;
            };

            $keuntungan_harian[] = $keuntungan;
        }

        $data['label'] = $label;
        $data['penjualan_harian'] = $penjualan_harian;
        $data['keuntungan_harian'] = $keuntungan_harian;

        return $data;

    }

}
