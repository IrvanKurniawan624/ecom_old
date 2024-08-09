<?php

namespace App\Http\Controllers\Admin\Produk;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;

use DB;
use DataTables;
use Carbon\Carbon;

use App\Models\MasterSubkategori;

class SubkategoriProdukController extends Controller
{
    public function index(){
        return view('admin.produk.subkategori.index');
    }

    public function detail($id){
        return MasterSubkategori::find($id);
    }

    public function datatables(){
        $data = MasterSubkategori::with('master_kategori','parent')->orderBy('master_kategori_id','ASC')->orderBy('parent_id','ASC')->orderBy('level','ASC')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('parent_desc',function($item) {
                return $item->parent->subkategori ?? 'HEAD';
            })
            ->make(true);
    }

    public function store_update(request $request){
        $array_validation = [
            'master_kategori_id' => 'required',
            'subkategori' => 'required',
            'level' => 'required',
            'parent_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $array_validation);

		if($validator->fails()) {
			return [
				'status' => 300,
				'message' => $validator->errors()->first()
			];
		}

        $request->request->add(['subkategori_slug' => Str::slug($request->subkategori, '-') ]);
		$master_subkategori = MasterSubkategori::updateOrCreate(['id' => $request->id],$request->all() );

        if($request->parent_id == 0){
            MasterSubkategori::where('id', $master_subkategori->id)->update(['parent_id' => $master_subkategori->id]);
        }


        return [
            'status' => 200, // SUCCESS
            'message' => 'Data berhasil disimpan'
        ];

    }

    public function delete($id){
        $delete = MasterSubkategori::find($id);

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
