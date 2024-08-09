<?php

namespace App\Http\Controllers\Admin\Produk;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use DB;
use DataTables;
use Carbon\Carbon;

use App\Models\MasterProperties;
use App\Models\KategoriProperties;

class PropertiesController extends Controller
{
    public function index(){
        return view('admin.produk.properties.index');
    }

    public function detail($id){
        return MasterProperties::with('master_kategori')->find($id);
    }

    public function datatables(){
        $data = MasterProperties::with('master_kategori')->orderby('id','desc')->get();

        return DataTables::of($data)
                    ->addIndexColumn()
                    ->make(true);
    }

    public function store_update(request $request){
        $array_validation = [
            'master_kategori_id' => 'required',
            'properties' => 'required',
        ];

        $validator = Validator::make($request->all(), $array_validation);

		if($validator->fails()) {
			return [
				'status' => 300,
				'message' => $validator->errors()->first()
			];
		}

        DB::beginTransaction();

		try{

            $request->merge(['properties' =>strtoupper($request->properties)]);
            MasterProperties::updateOrCreate(['id' => $request->id],$request->all() );

			DB::commit();

            return [
                'status' => 200, // SUCCESS
                'message' => 'Data berhasil disimpan'
            ];
		}

		catch(\Exception $e){

			DB::rollback();

			return [
				'status' 	=> 300, // GAGAL
				'message'       => (env('APP_DEBUG', 'true') == 'true')? $e->getMessage() : 'Operation error'
			];

		}

    }

    public function delete($id){
        $delete = MasterProperties::find($id);

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
