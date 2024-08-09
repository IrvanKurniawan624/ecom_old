<?php

namespace App\Http\Controllers\Ecom;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;

use DB;
use DataTables;
use Carbon\Carbon;

use App\Models\MasterPackage;
use App\Models\MasterBanner;
use App\Models\MasterProduk;
use App\Models\MasterKategori;
use App\Models\MasterInstagram;
use App\Models\MasterDictionary;

class HomeController extends Controller
{
    public function index(){
        $data['banner'] = MasterBanner::active()->get();
        $data['instagram'] = MasterInstagram::all();
        $data['package'] = MasterPackage::all();


        $array = [];
        foreach($data['package'] as $item){
            $array[$item->id] = MasterProduk::active()->whereIn('master_kategori_id', MasterKategori::where('master_package_id', $item->id)->pluck('id'))->latest()->limit(8)->get();
        }

        $data['package_produk'] = $array;


        return view('ecom.home', $data);
    }

    public function search($keyword, $package_slug = null){

        $master_dictionary = MasterDictionary::select('kata_kunci')->where('dictionary', 'like', "%$keyword%")->first()->kata_kunci ?? '-';
        $master_produk = MasterProduk::with('master_kategori.master_package')->select('nama_produk','kata_kunci','is_publish', 'harga_jual_b2b', 'harga_jual_b2c', 'master_kategori_id')->where(['is_publish' => '1'])->where(function($query) use ($keyword){
            $query->where('nama_produk', 'like', "%$keyword%")->Orwhere('kata_kunci', 'like', "%$keyword%");
        });

        if(!empty($master_dictionary)){
            $master_produk = $master_produk->orWhere('kata_kunci', 'like', "%$master_dictionary%");
        }

        if($package_slug != null || !empty(session('package_slug'))){
            $master_produk = $master_produk->whereHas('master_kategori.master_package', function($query) use ($package_slug){
                $query->where('package_slug', $package_slug);
            });
        }

        $master_produk = $master_produk->get();

        $array = [];
        foreach($master_produk as $item){
            $explode = explode('|',$item->kata_kunci);
            foreach($explode as $kata_kunci){
                if(stripos($kata_kunci, $keyword) !== FALSE || stripos($kata_kunci, $master_dictionary) !== FALSE){
                    $array[$kata_kunci] = $item->master_kategori->master_package->package_slug;
                }
            }

            $array[$item->nama_produk] = $item->master_kategori->master_package->package_slug;
        }

        return $array;
    }
}
