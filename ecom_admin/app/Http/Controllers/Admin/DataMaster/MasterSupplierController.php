<?php

namespace App\Http\Controllers\Admin\DataMaster;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

use DB;
use DataTables;
use Carbon\Carbon;

use App\Models\MasterSupplier;

class MasterSupplierController extends Controller
{
    public function index(){
        return view('admin.data-master.master-supplier.index');
    }

    public function detail($id){
        return MasterSupplier::find($id);
    }

    public function datatables(){
        $data = MasterSupplier::orderby('id','desc')->get();

        return DataTables::of($data)
                    ->addIndexColumn()
                    ->make(true);
    }

    public function store_update(request $request){
        $array_validation = [
            'nama' => 'required',
        ];

        $validator = Validator::make($request->all(), $array_validation);

		if($validator->fails()) {
			return [
				'status' => 300,
				'message' => $validator->errors()->first()
			];
		}

        MasterSupplier::updateOrCreate(['id' => $request->id],$request->all() );
        return [
            'status' => 200, // SUCCESS
            'message' => 'Data berhasil disimpan'
        ];
    }

    public function delete($id){
        $delete = MasterSupplier::find($id);

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
