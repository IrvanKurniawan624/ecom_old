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

use App\Libraries\QueryLibraries;
use App\Mail\TransaksiCancel;

use App\Models\MasterGlobal;
use App\Models\Transaksi;
use App\Models\PoinLog;
use App\Models\KodeVoucher;
use App\Models\Notification;
use App\Models\User;
use App\Models\MasterProduk;

class TransaksiBelanjaController extends Controller
{
    public function index(){
        $transaksi = Transaksi::with('transaksi_produk.master_produk', 'alamat_pengiriman')->where('user_id', auth()->user()->id)->latest()->get();
        $data['data'] = $transaksi;
        $data['belum_bayar'] = $transaksi->where('status', Transaksi::BELUM_BAYAR);
        $data['konfirmasi_admin'] = $transaksi->where('status', Transaksi::KONFIRMASI_ADMIN);
        $data['dikemas'] = $transaksi->where('status', Transaksi::DIKEMAS);
        $data['dikirim'] = $transaksi->where('status', Transaksi::DIKIRIM);
        $data['selesai'] = $transaksi->where('status', Transaksi::SELESAI);
        $data['cancel'] = $transaksi->where('status', Transaksi::CANCEL);

        return view('ecom.profile.profile-transaksi-belanja', $data);
    }

    public function invoice($uuid){
        $data['data'] = Transaksi::with('user','alamat_pengiriman', 'transaksi_produk.master_produk')->where('uuid', $uuid)->first();
        $data['kode_voucher'] = KodeVoucher::where('kode_voucher', $data['data']->kode_voucher)->first();

        return view('ecom.profile.profile-invoice', $data);
    }

    public function cancel_pesanan($uuid){
        DB::beginTransaction();

		try{

			$transaksi = Transaksi::with('user')->where(['uuid' => $uuid, 'status' => Transaksi::BELUM_BAYAR])->first();
            if(!empty($transaksi)){
                $poin_log = PoinLog::where(['transaksi_id' => $transaksi->id, 'status' => '-'])->first();
                    if(!empty($poin_log)){
                        PoinLog::create([
                            'user_id' => $transaksi->user->id,
                            'transaksi_id' => $transaksi->id,
                            'status' => '+',
                            'nominal' => $poin_log->nominal,
                            'sisa_poin' => $transaksi->user->poin + $poin_log->nominal,
                            'keterangan' => 'pengembalian poin',
                        ]);
                        User::where('id', $transaksi->user->id)->update(['poin' => $transaksi->user->poin + $poin_log->nominal]);
                    }

                    Notification::create([
                        'user_id' => $transaksi->user->id,
                        'transaksi_id' => $transaksi->id,
                        'notification_type' => 'transaksi_cancel',
                        'is_new' => '1',
                        'status' => '1',
                    ]);

                    //MENGEMBALIKAN STOCK PRODUCT
                    foreach($transaksi->transaksi_produk as $transaksi_produk){
                        $master_produk = MasterProduk::find($transaksi_produk->master_produk_id);
                        $stock_lama = $master_produk->stock;
                        $master_produk->stock = $transaksi_produk->quantity + $stock_lama;
                        $master_produk->save();
                    }

                    $data = [
                        'nama' => $transaksi->user->nama,
                        'no_invoice' => $transaksi->no_invoice,
                        'total_harga' => $transaksi->total_harga,
                    ];
                    $email = $transaksi->user->email;
                    Mail::to($email)->send(new TransaksiCancel($data));

                    Transaksi::where('id', $transaksi->id)->update(['status' => '5']);

                    DB::commit();

                    return [
                        'status' => 201,
                        'link' => '/profile/transaksi-belanja?status=Semua',
                        'message' => 'Pesananmu berhasil dicancel',
                    ];
            }else{
                return [
                    'status' => 301,
                    'link' => '/errors/transaksi-tidak-ditemukan',
                    'message' => 'Oops! Transaksimu tidak ditemukan'
                ];
            }
		}

		catch(\Exception $e){

			DB::rollback();

			return [
				'status' 	=> 300, // GAGAL
				'message'       => (env('APP_DEBUG', 'true') == 'true')? $e->getMessage() : 'Operation error'
			];

		}
    }

    public function terima_pesanan($uuid){
        DB::beginTransaction();

		try{

			$transaksi = Transaksi::with('user')->where(['uuid' => $uuid, 'status' => Transaksi::DIKIRIM])->first();
            if(!empty($transaksi)){
                //POIN HARGA UNIQUE
                $poin = $transaksi->user->poin + $transaksi->harga_unique;
                PoinLog::create([
                    'user_id' => $transaksi->user->id,
                    'transaksi_id' => $transaksi->id,
                    'status' => '+',
                    'nominal' => $transaksi->harga_unique,
                    'sisa_poin' => $poin,
                    'keterangan' => 'ajustment kode unique',
                ]);

                //POIN BONUS PEMBELIAN
                if($transaksi->point_bonus > 0){
                    $poin += $transaksi->point_bonus;
                    PoinLog::create([
                        'user_id' => $transaksi->user->id,
                        'transaksi_id' => $transaksi->id,
                        'status' => '+',
                        'nominal' => $transaksi->point_bonus,
                        'sisa_poin' => $poin,
                        'keterangan' => 'Bonus pembelian',
                    ]);
                }

                if($transaksi->point > 0){
                    //POIN
                    $poin += $transaksi->point;
                    PoinLog::create([
                        'user_id' => $transaksi->user->id,
                        'transaksi_id' => $transaksi->id,
                        'status' => '+',
                        'nominal' => $transaksi->point,
                        'sisa_poin' => $poin,
                        'keterangan' => 'penambahan poin',
                    ]);
                }
                User::where('id', $transaksi->user->id)->update(['poin' => $poin]);

                $transaksi->status = Transaksi::SELESAI;
                $transaksi->save();

                DB::commit();

                return [
                    'status' => 201,
                    'link' => '/profile/penilaian/' . $uuid,
                    'message' => 'Transaksi berhasil diselesaikan'
                ];
            }else{
                return [
                    'status' => 301,
                    'link' => '/errors/transaksi-tidak-ditemukan',
                    'message' => 'Oops! Transaksimu tidak ditemukan'
                ];
            }
		}

		catch(\Exception $e){

			DB::rollback();

			return [
				'status' 	=> 300, // GAGAL
				'message'       => (env('APP_DEBUG', 'true') == 'true')? $e->getMessage() : 'Operation error'
			];

		}

    }

    public function tracking_order($uuid){
        $transaksi = Transaksi::where('uuid', $uuid)->first();
        $waybill = $transaksi->resi_pengiriman;
        $courier = $transaksi->jasa_pengiriman_code;

        if(empty($waybill) || empty($courier)){
            return view('errors.resi-tidak-ditemukan');
        }

        //CURL API RAJAONGKIR
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://pro.rajaongkir.com/api/waybill",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "waybill=$waybill&courier=$courier",
        CURLOPT_HTTPHEADER => array(
            "content-type: application/x-www-form-urlencoded",
            "key: 7021b582cede2d3c37dbe64f18d6c29b"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return [
                'status' => 300,
                'message' => $err,
            ];
        }

        $response = json_decode($response, true);

        if($response['rajaongkir']['status']['code'] == 400){
            return view('errors.resi-tidak-ditemukan');
        }

        $response = collect($response['rajaongkir']['result']);


        $data['transaksi'] = $transaksi;
        $data['data'] = $response;

        return view('ecom.profile.profile-pengiriman', $data);
    }
}
