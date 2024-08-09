<?php

namespace App\Http\Controllers\Admin\DataMaster;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use DB;
use DataTables;
use Carbon\Carbon;

use App\Models\MasterDictionary;

class MasterDictionaryController extends Controller
{
    public function index(){
        return view('admin.data-master.master-dictionary.index');
    }

    public function detail($id){
        return MasterDictionary::find($id);
    }

    public function datatables(){
        $data = MasterDictionary::latest()->get();

        return DataTables::of($data)
                    ->addIndexColumn()
                    ->make(true);
    }

    public function store_update(request $request){
        $array_validation = [
            'kata_kunci' => 'required',
            'dictionary' => 'required',
            'dictionary.*' => 'required',
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

            $request->merge(['dictionary' => json_encode($request->dictionary)]);

			MasterDictionary::updateOrCreate(['id' => $request->id],$request->all() );

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
        $delete = MasterDictionary::find($id);

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
