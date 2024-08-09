<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use App\Helpers\Convert;

use \Carbon\Carbon;

use App\Libraries\QueryLibraries;
use App\Helpers\App;

use App\Models\User;
use App\Models\Transaksi;
use App\Models\Notification;

use App\Mail\TransaksiCancel;

class LoginTeleponController extends Controller
{
    public function index()
    {
        session(['url_previous' => url()->previous()]);

        if (Auth::check()) {
            return redirect()->route('profile');
        }

        return view('login.login-telepon');
    }

    public function send_whatsapp(request $request){

        $user = User::where('no_telepon', $request->no_telepon)->count();
        if($user == 0){
            return [
                'status' => 300,
                'message' => 'No Telepon tidak ditemukan didalam sistem kami',
            ];
        }

        $random = random_int(100000, 999999);

        User::where('no_telepon', $request->no_telepon)->update([
            'password_otp' => $random,
        ]);

        //KIRIM PERSEORANGAN
        Http::post(env('URL_WA_SERVER').'/chats/send?id=notifications', [
            'receiver' =>  Convert::convert_telepon_to_whatsapp($request->no_telepon),
            'message'  => [ 'text' => "Kode OTP anda adalah " . $random . " Gunakan kode tersebut untuk login ke SIMANHURA" ]
        ]);

        return [
            'status' => 200,
            'message' => 'Kode otp berhasil dikirim ke whatsapp anda'
        ];
    }

    public function login(Request $request){
        $rules = [
            'no_telepon' => 'required',
            'otp' => 'required'
        ];

        $messages = [
            'no_telepon.required'   => 'No Telepon wajib diisi',
            'otp.required'     => 'OTP wajib diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $user = User::where(['no_telepon' => $request->no_telepon, 'password_otp' => $request->otp])->first();
        if(empty($user)){
            return [
                'status' => 300,
                'message' => 'OTP tidak valid, silahkan coba lagi',
            ];
        }

        Auth::login($user);

        if (Auth::check()) { // true sekalian session field di users nanti bisa dipanggil via Auth

            //CANCEL TRANSAKSI YANG MELEWATI BATAS PEMBAYARAN
            QueryLibraries::transaksi_cancel();

            Session::put('filter', 'all');
            $explode_url = explode("//",session('url_previous'));
            if(Session::has('url_previous') && (session('url_previous') == 'https://SIMANHURA.com/login' || session('url_previous') == 'https://SIMANHURA.com/null' || strpos($explode_url[1], 'SIMANHURA.com') === FALSE || session('url_previous') == 'https://SIMANHURA.com/register')){
                $link = '/profile';
            }else{
                $link = session('url_previous');
            }

            User::where('no_telepon', $request->no_telepon)->update([
                'password_otp' => null,
            ]);

            return [
                'status' => 201,
                'message' => 'Anda berhasil login',
                'link' => $link,
            ];
        }else{

            return [
                'status' => 300,
                'message' => 'Username atau password anda salah silahkan coba lagi'
            ];
        }
    }


}
