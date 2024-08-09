<?php

namespace App\Http\Controllers\Admin\DataMaster;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;

use DB;
use DataTables;
use Carbon\Carbon;

use App\Models\MasterPackage;

class MasterPackageController extends Controller
{
    public function index(){
        return view('admin.data-master.master-package.index');
    }

    public function detail($id){
        return MasterPackage::find($id);
    }

    public function datatables(){
        $data = MasterPackage::orderby('id','desc')->get();

        return DataTables::of($data)
                    ->addIndexColumn()
                    ->make(true);
    }

    public function store_update(request $request){
        $array_validation = [
            'package' => 'required',
            'upload_image' => 'sometimes|mimes:svg,png,webp|max:2048',
        ];

        if($request->type != 'update'){
            $array_validation['upload_image'] = 'required|mimes:svg,png,webp|max:2048';
        }

        $validator = Validator::make($request->all(), $array_validation);

		if($validator->fails()) {
			return [
				'status' => 300,
				'message' => $validator->errors()->first()
			];
		}

        DB::beginTransaction();

		try{
			if(!empty($request->file('upload_image'))){
                $file = $request->file('upload_image');

                $place_image = 'berkas/master-package/';
                $name_image =  md5(time()."_".$file->getClientOriginalName()).".".$file->getClientOriginalExtension();

                $file->move($place_image, $name_image);
                $database_file = $place_image . $name_image;
                if($request->type == 'update'){
                    $delete = MasterPackage::find($request->id);
                    File::delete($delete->url_image);
                }

                $request->request->add(['url_image' => $database_file]);
            }

            $request->request->add(['package_slug' => Str::slug($request->package, '-') ]);
			MasterPackage::updateOrCreate(['id' => $request->id],$request->all() );

            DB::commit();

        return [
            'status' => 200, // SUCCESS
            'message' => 'Data berhasil disimpan'
        ];

		} catch(\Exception $e){

			DB::rollback();

			return [
				'status' 	=> 300, // GAGAL
				'message'       => (env('APP_DEBUG', 'true') == 'true')? $e->getMessage() : 'Operation error'
			];

		}
    }

    public function delete($id){
        $delete = MasterPackage::find($id);

        if($delete <> ""){
            $delete->delete();
            File::delete($delete->url_image);
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
