<?php

namespace App\Http\Controllers\Admin\DataMaster;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

use DB;
use DataTables;
use Image;
use Carbon\Carbon;

use App\Models\MasterInstagram;

class MasterInstagramController extends Controller
{
    public function index(){
        return view('admin.data-master.master-instagram.index');
    }

    public function detail($id){
        return MasterInstagram::find($id);
    }

    public function datatables(){
        $data = MasterInstagram::orderBy('id','DESC')->get();

        return DataTables::of($data)
                    ->addIndexColumn()
                    ->make(true);
    }

    public function store_update(request $request){
        $array_validation = [
            'upload_image' => 'sometimes|mimes:jpg,png,jpeg,webp|max:2048',
            'tipe' => 'required',
            'link' => 'required',
        ];

        if($request->type != 'update'){
            $array_validation['upload_image'] = 'required|mimes:jpg,png,jpeg,webp|max:2048';
        }

        $validator = Validator::make($request->all(), $array_validation);

		if($validator->fails()) {
			return [
				'status' => 300,
				'message' => $validator->errors()->first()
			];
		}

        if(!empty($request->file('upload_image'))){
            $file = $request->file('upload_image');

            $name_image =  md5(time()."_".$file->getClientOriginalName()).".".$file->getClientOriginalExtension();

            $img = Image::make($file);
            // $img->rotate(-90);
            $img->resize(650, null, function ($constraint) {
                $constraint->aspectRatio();
            });

            //detach method is the key! Hours to find it... :/
            $resource = $img->stream()->detach();

            Storage::disk('s3')->put('master-sosial-media/' . $name_image, $resource);

            $request->request->add(['url_image' => 'https://'. env('AWS_BUCKET') .'.s3.'. env('AWS_DEFAULT_REGION') .'.amazonaws.com/master-sosial-media/' . $name_image]);
        }

        $request->request->add(['title_slug' => Str::slug($request->title, '-') ]);
        MasterInstagram::updateOrCreate(['id' => $request->id],$request->all() );


        return [
            'status' => 200, // SUCCESS
            'message' => 'Data berhasil disimpan'
        ];

    }

    public function delete($id){
        $delete = MasterInstagram::find($id);

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
