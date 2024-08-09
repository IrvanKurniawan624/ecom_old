<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

use DataTables;
use Carbon\Carbon;

use App\Models\PoinStrukOffline;
use App\Models\User;

use App\Helpers\ApiFormatter;
use App\Libraries\QueryLibraries;
use App\Helpers\Convert;

class ApiController extends Controller
{
    public function store_upload_struk_belanja(request $request){
        $array_validation = [
            'nominal_belanja' => 'required',
            'upload_image' => 'sometimes|mimes:jpg,png,jpeg|max:10048',
            'token' => 'required',
        ];

        $validator = Validator::make($request->all(), $array_validation);

		if($validator->fails()) {
			return ApiFormatter::createApi(300, $validator->errors()->first());
		}

        if($request->token != 'MamnkSZFLvYGOX7BYgly5Dc2kxVKAfxX9I19KmOG'){
            return ApiFormatter::createApi(401, 'Unauthorize');
        }

        if(!empty($request->file('upload_image'))){
            $file = $request->file('upload_image');

            $place_image = 'berkas/struk-belanja-offline/';
            $name_image =  md5(time()."_".$file->getClientOriginalName()).".".$file->getClientOriginalExtension();

            $file->move($place_image, $name_image);
            $database_file = $place_image . $name_image;

            $request->request->add(['url_image' => $database_file]);
        }

        $request->request->add(['user_id' => $request->user_id]);
        $request->merge(['nominal_belanja' => Convert::convert_to_number($request->nominal_belanja) ]);

        PoinStrukOffline::create($request->all());

        return ApiFormatter::createApi(200, 'Struk berhasil diupload untuk admin review');
    }

    public function detail_user(request $request){

        $array_validation = [
            'id' => 'required',
            'token' => 'required',
        ];

        $validator = Validator::make($request->all(), $array_validation);
        if($validator->fails()) {
			return ApiFormatter::createApi(300, $validator->errors()->first());
		}

        $data = User::find($request->id);
        if(!empty($data)){
            return ApiFormatter::createApi(200, 'Data berhasil diload', $data);
        }else{
            return ApiFormatter::createApi(300, 'Data tidak ditemukan');
        }
    }

    public function update_user(request $request){
        $array_validation = [
            'id' => 'required',
            'token' => 'required',
            'email' => 'required|email:rfc,dns|unique:users,email,'.$request->id.',id,deleted_at,NULL',
            'nama' => 'required',
            'no_telepon' => 'required|min:10|max:12',
            'alamat' => 'required',
            'upload_image' => 'sometimes|mimes:jpg,png,jpeg|max:10048',
        ];

        if(!empty($request->new_password)){
            $array_validation['new_password'] = 'required|min:6';
            $array_validation['retype_new_password'] = 'required|same:new_password';

            $request->request->add(['password' => Hash::make($request->new_password)]);
        }

        $validator = Validator::make($request->all(), $array_validation);

		if($validator->fails()) {
			return ApiFormatter::createApi(300, $validator->errors()->first());
		}

        if($request->token != 'MamnkSZFLvYGOX7BYgly5Dc2kxVKAfxX9I19KmOG'){
            return ApiFormatter::createApi(401, 'Unauthorize');
        }

        if(substr($request->no_telepon, 0, 2) != '08'){
            return ApiFormatter::createApi(300, 'Nomer harus dimulai dari 08xxx');
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

        return ApiFormatter::createApi(200, 'Data profile berhasil diupdate');
    }
}
