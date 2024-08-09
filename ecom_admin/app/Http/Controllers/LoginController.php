<?php

namespace App\Http\Controllers;

use App\Models\MasterAdmin;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class LoginController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('login.index');
    }

    public function login(Request $request){
        $rules = [
            'email'            => 'required',
            'password'              => 'required'
        ];

        $messages = [
            'email.required'   => 'ID Pegawai wajib di isi',
            'password.required'     => 'Password wajib diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $data = [
            'email'     => $request->input('email'),
            'password'  => $request->input('password'),
        ];

        Auth::attempt($data);

        if (Auth::check()) { // true sekalian session field di users nanti bisa dipanggil via Auth

            return [
                'status' => 201,
                'message' => 'Anda berhasil login',
                'link' => 'dashboard',
            ];
        }else{

            return [
                'status' => 300,
                'message' => 'Username atau password anda salah silahkan coba lagi'
            ];
        }
    }

    public function change_password(){
        return view('login.change-password');
    }

    public function action_change_password(request $request){
        $validator = Validator::make($request->all(), [
			'old_password' => 'required',
			'new_password' => 'required| min:5',
			'retype_password' => 'required|same:new_password',
		]);

		if($validator->fails()) {
			return [
				'status' => 300,
				'message' => $validator->errors()->first()
			];
		}

		$user = MasterAdmin::where('id',Auth::user()->id)->first();

		if (password_verify($request->old_password, $user['password'])) {
			$user->password = hash::make($request->new_password);
			$user->save();

			return [
				'status' => 200,
				'message' => 'Password berhasil diganti'
			];

		}else{
			return [
				'status' => 300,
				'message' => 'Password lama anda salah, silahkan coba lagi'
			];
		}


    }

    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }
}
