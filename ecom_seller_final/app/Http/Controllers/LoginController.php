<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\MasterSeller;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }
        return view('login.login');
    }

    
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email:dns',
            'password' => 'required'
        ],
        [
            'email.required' => 'Email Belum Diisi',
            'email.email' => 'Masukkan Email yang Valid',
            'password.required' => 'Password Belum Diisi'
        ]);

        if($validator->fails()){
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        if(Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])){
            $request->session()->regenerate();
            return [
                'status' => 201,
                'message' => 'Login Berhasil'
            ];
        } else {
            return [
                'status' => 300,
                'message' => 'Email / Password yang anda masukkan salah'
            ];
        }
    }

    public function change_password(){
        return view('login.change-password');
    }

    public function action_change_password(Request $request){
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

		$user = MasterSeller::where('id',Auth::user()->id)->first();

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
