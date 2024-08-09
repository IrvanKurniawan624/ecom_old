<?php

namespace App\Http\Controllers\Ecom;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use DB;
use DataTables;
use Carbon\Carbon;

use App\Models\MasterProduk;
use App\Models\MasterPackage;
use App\Models\MasterKategori;
use App\Models\MasterSubkategori;
use App\Models\MasterBanner;
use App\Models\TransaksiProduk;

class ProdukController extends Controller
{
    public function index(request $request){
        $package_slug = $request->package;

        session(['package_slug' => $package_slug]);

        $data['banner'] = MasterBanner::whereHas('master_package', function($query) use ($package_slug){
            $query->where('package_slug', $package_slug);
        })->get();

        $data['kategori'] = MasterKategori::whereHas('master_package', function($query) use ($request){
            $query->where('package_slug', $request->package);
        })->get();

        $master_produk = MasterProduk::active()->with('master_subkategori', 'master_kategori.master_package','master_produk_subkategori.master_subkategori');
        if($request->has('package')){
            $master_produk = $master_produk->whereHas('master_kategori.master_package', function($query) use ($package_slug){
                $query->where('package_slug', $package_slug);
            });
        }

        if($request->has('kategori')){
            $kategori = $request->kategori;
            $master_produk = $master_produk->whereHas('master_kategori', function($query) use ($kategori){
                $query->where('kategori_slug', $kategori);
            });
        }

        if($request->has('search')){
            $request->search = str_replace("+"," ",$request->search);
            $searching = $request->search;
            $master_produk = $master_produk->where(function($query) use ($searching){
                $query->where('kata_kunci','like',"%$searching%")->orWhere('nama_produk', 'like', "%$searching%");
            });
        }

        
        if($request->has('subkategori')){
            $subkategori = $request->subkategori;
            $master_produk = $master_produk->whereHas('master_produk_subkategori.master_subkategori', function($query) use ($subkategori){
                $query->where('subkategori_slug', $subkategori);
            });
        }

        if(auth()->check() && auth()->user()->tipe_customer_id == '3'){
            if($request->has('filter')){
                $filter = $request->filter;
                if($filter == 'terbaru'){
                    $master_produk = $master_produk->orderBy('updated_at', 'DESC');
                }elseif($filter == 'termurah'){
                    $master_produk = $master_produk->orderBy('harga_jual_b2b', 'ASC');
                }elseif($filter == 'termahal'){
                    $master_produk = $master_produk->orderBy('harga_jual_b2b', 'DESC');
                }
            }
        }else{
            if($request->has('filter')){
                $filter = $request->filter;
                if($filter == 'terbaru'){
                    $master_produk = $master_produk->orderBy('updated_at', 'DESC');
                }elseif($filter == 'termurah'){
                    $master_produk = $master_produk->orderBy('harga_jual_b2c', 'ASC');
                }elseif($filter == 'termahal'){
                    $master_produk = $master_produk->orderBy('harga_jual_b2c', 'DESC');
                }
            }
        }


        $data['produk'] = $master_produk->paginate(12);

        return view('ecom.package.index', $data);
    }

    public function produk_filter(request $request){
        $package_slug = $request->package;
        $master_produk = MasterProduk::active()->with('master_subkategori', 'master_kategori.master_package');
        if($request->has('package')){
            $master_produk = $master_produk->whereHas('master_kategori.master_package', function($query) use ($package_slug){
                $query->where('package_slug', $package_slug);
            });
        }

        if($request->has('kategori')){
            $kategori = $request->kategori;
            $master_produk = $master_produk->whereHas('master_kategori', function($query) use ($kategori){
                $query->where('kategori_slug', $kategori);
            });
        }

        if($request->has('search')){
            $request->search = str_replace("+"," ",$request->search);
            $master_produk = $master_produk->where('kata_kunci','like',"%$request->search%")->orWhere('nama_produk', 'like', "%$request->search%");
        }

        if($request->has('subkategori')){
            $subkategori = $request->subkategori;
            $master_produk = $master_produk->whereHas('master_produk_subkategori.master_subkategori', function($query) use ($subkategori){
                $query->where('subkategori_slug', $subkategori);
            });
        }

        if($request->has('filter')){
            $filter = $request->filter;
            if($filter == 'terbaru'){
                $master_produk = $master_produk->orderBy('updated_at', 'DESC');
            }elseif($filter == 'termurah'){
                $master_produk = $master_produk->orderBy('harga_jual_b2b', 'ASC');
            }elseif($filter == 'termahal'){
                $master_produk = $master_produk->orderBy('harga_jual_b2b', 'DESC');
            }
        }

        return $master_produk->paginate(12);
    }

    public function detail($produk_slug){
        $data['data'] = MasterProduk::active()->with(['master_seller', 'master_kategori', 'master_subkategori', 'master_produk_properties.master_properties', 'master_produk_harga_grosir' => function($query){
            $query->active();
        }])->where('nama_produk_slug', $produk_slug)->withTrashed()->first();

        if(empty($data['data'])){
            return view('errors.404');
        }

        $kata_kunci = explode('|', rtrim($data['data']->kata_kunci, "|"));
        $data['produk_suggest'] = MasterProduk::active()->with('master_subkategori', 'master_kategori.master_package','master_produk_subkategori.master_subkategori')->where('id','<>', $data['data']->id)->where(function($query) use ($kata_kunci){
            foreach($kata_kunci as $word){
                $query->orWhere('kata_kunci', 'LIKE', '%'.$word.'%');
            }            
        })->get();
        $data['ulasan'] = TransaksiProduk::with('transaksi.user')->where(['status' => TransaksiProduk::AKTIF, 'master_produk_id' => $data['data']->id])->get();

        return view('ecom.produk-detail', $data);
    }

    public function get_category($package_slug, $kategori_slug){
        $array = [];
        if($kategori_slug == 'null'){
            $sub = MasterSubKategori::where('level',1)->whereHas('master_kategori.master_package', function($query) use ($package_slug){
                $query->where('package_slug', $package_slug);
            })->get();
        }else{
            $sub = MasterSubKategori::where('level',1)->whereHas('master_kategori.master_package', function($query) use ($package_slug){
                $query->where('package_slug', $package_slug);
            })->whereHas('master_kategori', function($query) use ($kategori_slug){
                $query->where('kategori_slug', $kategori_slug);
            })->get();
        }

        foreach($sub as $r){
            $array[$r->subkategori] = $this->get_child($r->id, $package_slug);
        }

        return response()->json($array);
    }

    private function get_child($parent_id, $package_slug){
        $sub = MasterSubKategori::where('parent_id',$parent_id)->where('level','!=',1)->whereHas('master_kategori.master_package', function($query) use ($package_slug){
            $query->where('package_slug', $package_slug);
        })->get();
        $data = [];
        foreach($sub as $r){
            $data[$r->subkategori] = $this->get_child($r->id, $package_slug);
        }
        return $data;
    }
}
