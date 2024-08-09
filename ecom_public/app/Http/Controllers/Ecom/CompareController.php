<?php

namespace App\Http\Controllers\Ecom;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use DB;
use DataTables;
use Carbon\Carbon;

use App\Models\Compare;

class CompareController extends Controller
{
    public function index(){
        $data['data'] = Compare::with('master_produk')->where('user_id', auth()->user()->id)->get();
        return view('ecom.compare', $data);
    }

    public function store($master_produk_id){
        $compare = Compare::where('user_id', auth()->user()->id)->count();
        if($compare > 2){
            return [
                'status' => 300,
                'message' => 'Data yang dicompare maksimal 3 barang',
            ];
        }

        Compare::updateOrCreate(['user_id' => auth()->user()->id, 'master_produk_id' => $master_produk_id],[
            'user_id' => auth()->user()->id,
            'master_produk_id' => $master_produk_id,
        ] );

        return [
            'status' => 200,
            'data' => Compare::where(['user_id' => auth()->user()->id])->count(),
            'message' => 'Anda berhasil menambahkan compare'
        ];
    }

    public function delete($master_produk_id){
        Compare::where(['user_id' => auth()->user()->id, 'master_produk_id' => $master_produk_id])->delete();

        return [
            'status' => 200,
            'data' => Compare::where(['user_id' => auth()->user()->id])->count(),
            'message' => 'Anda berhasil menghapus compare'
        ];
    }
}
