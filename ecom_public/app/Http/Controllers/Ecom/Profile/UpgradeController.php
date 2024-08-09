<?php

namespace App\Http\Controllers\Ecom\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;

use DB;
use DataTables;
use Carbon\Carbon;

use App\Models\User;
use App\Models\Transaksi;
use App\Models\Notification;

use App\Mail\TransaksiCancel;

class UpgradeController extends Controller
{
    public function index(){
        $data['data'] = User::with('tipe_customer')->where('id', auth()->user()->id)->first();
        $data['total_belanja'] = Transaksi::where(['status' => 4, 'user_id' => auth()->user()->id])->select(DB::raw("SUM((total_harga-harga_pengiriman)) as total_pembelian"),'status','created_at','user_id')->first();

        return view('ecom/profile/profile-upgrade-b2b', $data);
    }

    public function detail(){
        return view('ecom/profile/profile-upgrade');
    }

    public function upgrade(request $request){
        $array_validation = [
            'id' => 'required',
            'npwp' => 'required|digits_between:10,15',
            'lat' => 'required',
            'lng' => 'required',
        ];

        $validator = Validator::make($request->all(), $array_validation);

        //NOTIFICATION
        Notification::create([
            'user_id' => $request->id,
            'notification_type' => 'permintaan_upgrade_pending',
        ]);

		if($validator->fails()) {
			return [
				'status' => 300,
				'message' => $validator->errors()->first()
			];
		}

        User::where('id', $request->id)->update([
            'npwp' => $request->npwp,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'status_upgrade' => '0',
        ]);

        return [
            'status' => 201,
            'link' => '/profile',
            'message' => 'Upgrade berhasil dilakukan'
        ];
    }

}
