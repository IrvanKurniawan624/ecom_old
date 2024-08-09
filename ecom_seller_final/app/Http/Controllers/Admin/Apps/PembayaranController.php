<?php

namespace App\Http\Controllers\Admin\Apps;

use App\Http\Controllers\Controller;
use App\Models\MasterSeller;
use File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index(){
        $data['data'] = MasterSeller::select('no_rekening', 'qris', 'no_telepon_pembayaran')->where('id', auth()->user()->id)->get();
        return view('admin.apps.pembayaran.index', $data);
    }

    public function qris(Request $request){
        $check = MasterSeller::select('qris')->where('id', auth()->user()->id)->get();
        if(!empty($check)){
            File::delete($check[0]->qris);
        }
        $file = $request->file('qris');
        $place_image = 'berkas/qris/';
        $name_image =  md5(md5(time()."_".$file->getClientOriginalName()).".".$file->getClientOriginalExtension()).".".$file->getClientOriginalExtension();
        
        $file->move($place_image, $name_image);
        $database_file = $place_image . $name_image;

        $request->request->add(['qris_image' => $database_file]);
        MasterSeller::where('id', auth()->user()->id)->update(["qris" => $request->qris_image]);


        return [
            'status' => 200, // SUCCESS
            'message' => 'Data berhasil disimpan',
            'link' => "/admin/apps/pembayaran/",
        ];
    }

    public function no_rekening(Request $request){
        MasterSeller::where('id', auth()->user()->id)->update(["no_rekening" => $request->no_rekening]);
        return [
            'status' => 200, // SUCCESS
            'message' => 'Data berhasil disimpan',
            'data' => $request->no_rekening,
        ];
    }

    public function no_telepon(Request $request){
        $validator = Validator::make($request->all(), [
            'no_telepon_pembayaran' => 'required|min:10|max:12',
		]);

		if($validator->fails()) {
            return [
                'status' => 300,
				'message' => $validator->errors()->first()
			];
		}

        if(substr($request->no_telepon_pembayaran, 0, 2) != '08'){
            return [
                'status' => 300,
                'message' => 'Nomer harus dimulai dari 08xxx',
            ];
        }
        MasterSeller::where('id', auth()->user()->id)->update(["no_telepon_pembayaran" => $request->no_telepon_pembayaran]);
        return [
            'status' => 200, // SUCCESS
            'message' => 'Data berhasil disimpan',
            'data' => $request->no_telepon_pembayaran,
        ];
    }
}
