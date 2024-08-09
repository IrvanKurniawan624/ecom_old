<?php

namespace App\Http\Controllers\Admin\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use DB;
use DataTables;
use Carbon\Carbon;

use App\Models\TipeCustomer;

class TipePelangganController extends Controller
{
    public function index(){
        return view('admin.pelanggan.tipe-pelanggan.index');
    }

    public function detail($id){
        return TipeCustomer::find($id);
    }

    public function datatables(){
        $data = TipeCustomer::orderby('id','desc')->get();

        return DataTables::of($data)
                    ->addIndexColumn()
                    ->make(true);
    }

    public function store_update(request $request){

        if(empty($request->id)){
            return [
                'status' => 300,
                'message' => 'Oops! Menu ini tidak dapat menambahkan item'
            ];
        }

        $array_validation = [
            'customer' => 'required',
        ];

        $validator = Validator::make($request->all(), $array_validation);

		if($validator->fails()) {
			return [
				'status' => 300,
				'message' => $validator->errors()->first()
			];
		}

        TipeCustomer::updateOrCreate(['id' => $request->id],$request->all() );

        return [
            'status' => 200, // SUCCESS
            'message' => 'Data berhasil disimpan'
        ];

    }

    public function delete($id){
        $delete = TipeCustomer::find($id);

        if($delete <> ""){
            $delete->delete();
            return [
                'status' => 200,
                'message' => 'Data berhasil dihapus'
            ];
        }

        return [
            'status' => 300,
            'message' => 'Data tidak ditemukan'
        ];
    }

}
