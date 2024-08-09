<?php

namespace App\Http\Controllers\Admin\Produk;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use App\Imports\CsvDataImport;
use Illuminate\Support\Facades\Storage;

use DB;
use Excel;
use Image;
use DataTables;
use Carbon\Carbon;

use App\Libraries\QueryLibraries;
use App\Helpers\Convert;

use App\Models\MasterProduk;
use App\Models\MasterKategori;
use App\Models\MasterSubkategori;
use App\Models\MasterProperties;
use App\Models\MasterProdukSubkategori;
use App\Models\MasterProdukProperties;
use App\Models\MasterProdukHargaGrosir;
use App\Models\MasterProdukLog;

class SettingImageController extends Controller
{
    public function index($id){
        $data['data'] = MasterProduk::find($id);
        return view('admin.produk.produk.setting-image', $data);
    }

    public function store(request $request){
        $array = [];
        foreach($request->urutan_image as $key => $item){
            $array[(int) $item] = $request->image[$key];
        }

        ksort($array);

        $array_image = [];
        foreach($array as $item){
            $array_image[] = $item;
        }

        MasterProduk::where('id', $request->id)->update(['url_image' => json_encode($array_image)]);

        return [
            'status' => '201',
            'link' => '/admin/produk/produk/setting-image/' . $request->id,
            'message' => 'Data berhasil dirubah'
        ];

    }
}
