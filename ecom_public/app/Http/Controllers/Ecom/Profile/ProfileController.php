<?php

namespace App\Http\Controllers\Ecom\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;

use DB;
use DataTables;
use Carbon\Carbon;

use App\Libraries\QueryLibraries;

use App\Models\User;
use App\Models\Transaksi;
use App\Models\Notification;

use App\Mail\TransaksiCancel;

class ProfileController extends Controller
{
    public function index(){
        //CANCEL TRANSAKSI YANG MELEWATI BATAS PEMBAYARAN
        QueryLibraries::transaksi_cancel();

        $data['data'] = User::find(auth()->user()->id);
        return view('ecom.profile.profile', $data);
    }

    public function detail($id, $tipe_customer){
        $data['data'] = User::find(auth()->user()->id);
        return view('ecom.profile.profile-edit', $data);
    }

    public function store_update(request $request){
        $array_validation = [
            'id' => 'required',
            'email' => 'required|email:rfc,dns|unique:users,email,'.$request->id.',id,deleted_at,NULL',
            'nama' => 'required',
            'no_telepon' => 'required|min:10|max:12',
            'alamat' => 'required',
            'new_password' => 'nullable|min:6',
            'upload_image' => 'sometimes|mimes:jpg,png,jpeg|max:2048',
        ];

        if(!empty($request->new_password)){
            $array_validation['new_password'] = 'required|min:6';
            $array_validation['retype_new_password'] = 'required|same:new_password';

            $request->request->add(['password' => Hash::make($request->new_password)]);
        }

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

        if(!empty($request->file('upload_image'))){
            $file = $request->file('upload_image');

            $place_image = 'berkas/ecom/profile/';
            $name_image =  time()."_".$file->getClientOriginalName();

            $file->move($place_image, $name_image);
            $database_file = $place_image . $name_image;

            $request->request->add(['url_image' => $database_file]);
        }

        $request->request->remove('upload_image');
        User::updateOrCreate(['id' => $request->id],$request->all() );

        return [
            'status' => 201, // SUCCESS
            'link' => '/profile',
            'message' => 'Data berhasil diubah'
        ];

    }

}
