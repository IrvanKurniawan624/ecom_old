<?php

namespace App\Http\Controllers\Admin\DataMaster;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use App\Helpers\Convert;
use App\Models\MasterSeller;
use DB;
use DataTables;
use Carbon\Carbon;

use App\Models\User;

class MasterUserController extends Controller
{
    public function index(){
        return view('admin.data-master.master-user.index');
    }

    public function detail($id){
        return MasterSeller::find($id);
    }

    public function datatables(){
        $data = MasterSeller::where('id', '!=', 0)->get();

        return DataTables::of($data)
                    ->addIndexColumn()
                    ->make(true);
    }

    public function store_update(request $request){
        $array_validation = [
            'nama' => 'required',
            'no_telepon' => 'required|min:10|max:12',
            'email' => 'required|email:rfc,dns',
        ];

        $validator = Validator::make($request->all(), $array_validation);

		if($validator->fails()) {
			return [
				'status' => 300,
				'message' => $validator->errors()->first()
			];
		}

        if(substr($request->no_telepon, 0, 2) != '08'){
            return [
                'status' => 300,
                'message' => 'Nomer harus dimulai dari 08xxx',
            ];
        }

        $request->request->add(['password' =>Hash::make('newuser')]);

        MasterSeller::updateOrCreate(['id' => $request->id],$request->all() );

        return [
            'status' => 200, // SUCCESS
            'message' => 'Data berhasil disimpan'
        ];
    }

    public function delete($id){
        $delete = User::find($id);

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

    public function reset_password($id){
        MasterSeller::where('id', $id)->update(['password' => Hash::make('passworddefault')]);

        // $user = User::where('id', $id)->first();
        //KIRIM PERSEORANGAN
        // Http::post(env('URL_WA_SERVER').'/chats/send?id=notifications', [
        //     'receiver' =>  Convert::convert_telepon_to_whatsapp($user->no_telepon),
        //     'message'  => [ 'text' => "Informasi untuk anda. Password anda telah dirubah oleh admin menjadi 'passworddefault'. segera lakukan pergantian password dari menu profile SIMANHURA.com :)" ]
        // ]);

        return [
            'status' => 200,
            'message' => 'Password berhasil dirubah menjadi password default',
        ];
    }

}
