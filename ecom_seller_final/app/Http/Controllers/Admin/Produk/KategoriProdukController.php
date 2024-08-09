<?php

namespace App\Http\Controllers\Admin\Produk;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

use DB;
use DataTables;
use Carbon\Carbon;

use App\Models\MasterKategori;

class KategoriProdukController extends Controller
{
    public function index(){
        return view('admin.produk.kategori-produk.index');
    }

    public function detail($id){
        return MasterKategori::find($id);
    }

    public function datatables(){
        $data = MasterKategori::with('master_package')->orderby('id','desc')->get();

        return DataTables::of($data)
                    ->addIndexColumn()
                    ->make(true);
    }

    public function store_update(request $request){
        $array_validation = [
            'master_package_id' => 'required',
            'upload_image' => 'sometimes|mimes:svg,png,webp|max:2048',
            'kategori' => 'required',
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

                $place_image = 'berkas/kategori-produk/';
                $name_image =  md5(time()."_".$file->getClientOriginalName()).".".$file->getClientOriginalExtension();

                $file->move($place_image, $name_image);
                $database_file = $place_image . $name_image;

                $request->request->add(['url_image' => $database_file]);
            }

            $request->request->add(['kategori_slug' => Str::slug($request->kategori, '-') ]);
			MasterKategori::updateOrCreate(['id' => $request->id],$request->all() );

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
        $delete = MasterKategori::find($id);

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
