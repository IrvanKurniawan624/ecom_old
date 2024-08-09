<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPassword;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;

use \Carbon\Carbon;
use DB;

use App\Libraries\QueryLibraries;
use App\Helpers\App;

use App\Models\User;
use App\Models\Transaksi;
use App\Models\Notification;

use App\Mail\TransaksiCancel;

class ResetPasswordController extends Controller
{
    public function index(){
        return view('login.reset-password');
    }

    public function reset_password(request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email:rfc,dns',
		]);

		if($validator->fails()) {
            return [
                'status' => 300,
				'message' => $validator->errors()->first()
			];
		}

        $user = User::where('email', $request->email)->first();
        if(empty($user)){
            return [
                'status' => 300,
                'message' => 'Email tidak ditemukan dalam sistem kami'
            ];
        }

        if(!empty($user->social_id)){
            return [
                'status' => 300,
                'message' => 'Anda login menggunakan google atau facebook tidak dapat direset'
            ];
        }

        $token = Str::random(64);
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        $data = [
            'nama' => $user->nama,
            'link' => URL::to('/') . '/reset-password/change-password?token=' . $token,
            'link_hubungi_kami' => URL::to('/') . '/errors/hubungi-kami',
        ];

        $email = $user->email;
        Mail::to($email)->send(new ResetPassword($data));

        return [
            'status' => 201,
            'link' => '/login',
            'message' => 'Link reset password sudah dikirim ke email anda'
        ];
    }

    public function change_password(request $request){

        $password_resets = DB::table('password_resets')->where(['token' => $request->token])->first();
        if(empty($password_resets)){
            return view('errors/404');
        }

        $data['data'] = $password_resets;
        return view('login.change-password', $data);
    }

    public function change_password_action(request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'token' => 'required',
            'password' => 'required| min:6',
            'ulangi_password' => 'required|same:password',
		]);

		if($validator->fails()) {
            return [
                'status' => 300,
				'message' => $validator->errors()->first()
			];
		}

        User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);
        DB::table('password_resets')->where('email', $request->email)->delete();


        return [
            'status' => 201,
            'link' => '/login',
            'message' => 'Password berhasil direset silahkan login menggunakan password baru'
        ];
    }
}
