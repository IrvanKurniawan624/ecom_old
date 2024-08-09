<?php

namespace App\Http\Controllers\Ecom\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use DB;
use DataTables;
use Carbon\Carbon;

use App\Models\KodeVoucher;
use App\Models\KodeVoucherUser;

class VoucherController extends Controller
{
    public function index(){
        $data['data'] = KodeVoucher::active()->get();
        return view('ecom.profile.profile-voucher', $data);
    }

    public function detail($kode_voucher){
        $data['data'] = KodeVoucher::where('kode_voucher', $kode_voucher)->first();
        return view('ecom.profile.profile-voucher-detail',$data);
    }

    public function action_kode_voucher($kode){

        $kode_voucher = KodeVoucher::active()->where('kode_voucher', $kode)->first();

        if(!empty($kode_voucher)){
            if(!empty($kode_voucher)){
                return [
                    'status' => 300,
                    'message' => 'Voucher telah anda claim',
                ];
            }
        }else{
            $kode_voucher = KodeVoucher::mustClaim()->where('kode_voucher', $kode)->first();
            if(empty($kode_voucher)){
                return [
                    'status' => 300,
                    'message' => 'Kode Voucher tidak ditemukan',
                ];
            }

            $kode_voucher_user = KodeVoucherUser::where(['user_id' => auth()->user()->id, 'kode_voucher_id' => $kode_voucher->id])->first();
            if(!empty($kode_voucher_user)){
                return [
                    'status' => 300,
                    'message' => 'Voucher telah anda claim'
                ];
            }
        }

        if($kode_voucher->maksimal_penggunaan <= $kode_voucher->total_penggunaan){
            return [
                'status' => 300,
                'message' => 'Kode Voucher sudah limit penggunaan',
            ];
        }

        $kode_voucher_user = KodeVoucherUser::create([
            'user_id' => auth()->user()->id,
            'kode_voucher_id' => $kode_voucher->id,
        ]);

        return [
            'status' => 200,
            'message' => 'Voucher berhasil di claim',
            'data' => KodeVoucherUser::with('kode_voucher')->find($kode_voucher_user->id),
        ];

    }
}
