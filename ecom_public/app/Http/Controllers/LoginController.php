<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Str;

use \Carbon\Carbon;

use App\Libraries\QueryLibraries;
use App\Helpers\App;

use App\Models\User;
use App\Models\Transaksi;
use App\Models\PoinLog;
use App\Models\MasterPoin;

use App\Mail\TransaksiCancel;

class LoginController extends Controller
{
    public function index()
    {
        session(['url_previous' => url()->previous()]);

        if (Auth::check()) {
            return redirect()->route('profile');
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

            //CANCEL TRANSAKSI YANG MELEWATI BATAS PEMBAYARAN
            QueryLibraries::transaksi_cancel();

            Session::put('filter', 'all');
            $explode_url = explode("//",session('url_previous'));
            if(Session::has('url_previous') && (session('url_previous') == '/login' || session('url_previous') == '/null' || session('url_previous') == '/register' || Str::contains(session('url_previous'), '/reset-password/change-password'))){
                $link = '/profile';
            }else{
                $link = session('url_previous');
                if($link == '/' || $link == '/logout' || $link == null){
                    $link = '/profile';
                }
            }

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

    public function index_register(){
        return view('login.register');
    }

    public function register(request $request){
        //email:rfc,dns
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'email' => 'required|email:rfc,dns|unique:users,email,NULL,id,deleted_at,NULL',
            'no_telepon' => 'required|min:10|max:12|unique:users,no_telepon,NULL,id,deleted_at,NULL',
            'alamat' => 'required',
            'password' => 'required| min:6',
			'ulangi_password' => 'required|same:password',
		]);

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

        // if($request->status_otp == 1){
            $request->request->add(['tipe_customer_id' => '2']);
            $request->request->add(['is_active' => '1']);
            $request->request->add(['url_image' => 'berkas/ecom/default/profile-default.png']);
            $request->merge(['password' => Hash::make($request->password)]);

            $user = User::create($request->all());

            $master_poin = MasterPoin::where(['title' => 'PELANGGAN BARU', 'status' => '1'])->first();
            if(!empty($master_poin)){
                Poinlog::create([
                    'user_id' => $user->id,
                    'status' => '+',
                    'nominal' => $master_poin->poin,
                    'sisa_poin' => $master_poin->poin,
                    'keterangan' => 'Penambahan poin pengguna baru'
                ]);

                User::where('id', $user->id)->update(['poin' => $master_poin->poin]);
            }

            return [
                'status' => 201,
                'link' => '/login',
                'message' => 'User berhasil dibuat silahkan login untuk melanjutkan transaksi'
            ];
        // }else{
        //     return [
        //         'status' => 200,
        //         'no_telepon' => App::gantiformat($request->no_telepon),
        //     ];
        // }


    }

    public function change_password(){
        return view('change-password.index');
    }

    public function action_change_password(request $request){
        $validator = Validator::make($request->all(), [
			'old_password' => 'required',
			'new_password' => 'required| min:6',
			'retype_password' => 'required|same:new_password',
		]);

		if($validator->fails()) {
			return [
				'status' => 300,
				'message' => $validator->errors()->first()
			];
		}

		$user = User::where('id',Auth::user()->id)->first();

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
