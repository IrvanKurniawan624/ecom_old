<?php

namespace App\Http\Controllers\Ecom;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use App\Helpers\Convert;

use DB;
use DataTables;
use Carbon\Carbon;

use App\Models\Transaksi;
use App\Models\Notification;

use App\Libraries\QueryLibraries;

use App\Mail\TransaksiCancel;
use App\Mail\TransaksiSudahBayar;

class PembayaranController extends Controller
{
    public function index($uuid){

        //CANCEL TRANSAKSI YANG MELEWATI BATAS PEMBAYARAN
        QueryLibraries::transaksi_cancel();

        $data['data'] = Transaksi::with('transaksi_produk', 'master_seller')->where(['uuid' => $uuid, 'status' => '0'])->first();
        if(!empty($data['data'])){
            return view('ecom.pembayaran', $data);
        }else{
            return view('errors.sudah-bayar');
        }
    }

    public function pembayaran($uuid){
        DB::beginTransaction();

		try{

            $transaksi = Transaksi::where('uuid', $uuid)->with('user')->first();
            $transaksi->status = Transaksi::KONFIRMASI_ADMIN;
            $transaksi->save();

            Notification::create([
                'user_id' => $transaksi->user_id,
                'transaksi_id' => $transaksi->id,
                'notification_type' => 'sudah_bayar',
            ]);

            $data = [
                'nama' => $transaksi->user->nama,
                'no_invoice' => $transaksi->no_invoice,
                'total_harga' => $transaksi->total_harga,
            ];

            $email = $transaksi->user->email;
            // Mail::to($email)->send(new TransaksiSudahBayar($data));

            //KIRIM PERSEORANGAN
            // Http::post(env('URL_WA_SERVER').'/chats/send?id=notifications', [
            //     'receiver' =>  Convert::convert_telepon_to_whatsapp($transaksi->user->no_telepon),
            //     'message'  => [ 'text' => "Pembayaranmu untuk transaksi $transaksi->no_invoice sedang kami review. Apabila proses sudah selesai akan kami kabari ya :) Salam Hangat SIMANHURA" ]
            // ]);

            DB::commit();

            return [
                'status' => 201,
                'link' => '/errors/transaksi-berhasil',
                'message' => 'Pembayaran berhasil, selanjutnya akan kami proses dulu pembayaranmu'
            ];
		}

		catch(\Exception $e){

			DB::rollback();

			return [
				'status' 	=> 300, // GAGAL
				'message'       => (env('APP_DEBUG', 'true') == 'true')? $e->getMessage() : 'Operation error'
			];

		}
    }
}
