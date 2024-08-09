<?php

namespace App\Http\Controllers\Admin\Apps;

use App\Http\Controllers\Controller;
use App\Mail\TransaksiCancel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use App\Helpers\Convert;

use DB;
use Barryvdh\DomPDF\Facade\Pdf;
use DataTables;
use Carbon\Carbon;

use App\Mail\TransaksiDikemas;
use App\Mail\TransaksiDikirim;
use App\Mail\TransaksiKonfirmasiAdmin;
use App\Mail\TransaksiSelesai;

use App\Models\Transaksi;
use App\Models\MasterGlobal;
use App\Models\MasterProduk;
use App\Models\AsalPengiriman;
use App\Models\KodeVoucher;
use App\Models\PoinLog;
use App\Models\User;
use App\Models\Notification;
use App\Models\MasterProdukLog;

class TransaksiController extends Controller
{
    public function index(){
        $transaksi = Transaksi::all();

        $data['count_semua'] = $transaksi->count();
        $data['count_belum_bayar'] = $transaksi->where('status', Transaksi::BELUM_BAYAR)->count();
        $data['count_konfirmasi_admin'] = $transaksi->where('status', Transaksi::KONFIRMASI_ADMIN)->count();
        $data['count_dikemas'] = $transaksi->where('status', Transaksi::DIKEMAS)->count();
        $data['count_dikirim'] = $transaksi->where('status', Transaksi::DIKIRIM)->count();
        $data['count_selesai'] = $transaksi->where('status', Transaksi::SELESAI)->count();
        $data['count_cancel'] = $transaksi->where('status', Transaksi::CANCEL)->count();
        return view('admin.apps.transaksi.index', $data);
    }

    public function datatables(request $request){
        $data = Transaksi::with('user.tipe_customer')->latest()->get();

        if($request->status == 'belum_bayar'){
            $data = $data->where('status', Transaksi::BELUM_BAYAR);
        }elseif($request->status == 'konfirmasi_admin'){
            $data = $data->where('status', Transaksi::KONFIRMASI_ADMIN);
        }elseif($request->status == 'dikemas'){
            $data = $data->where('status', Transaksi::DIKEMAS);
        }elseif($request->status == 'dikirim'){
            $data = $data->where('status', Transaksi::DIKIRIM);
        }elseif($request->status == 'selesai'){
            $data = $data->where('status', Transaksi::SELESAI);
        }elseif($request->status == 'cancel'){
            $data = $data->where('status', Transaksi::CANCEL);
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function detail($uuid){
        $data['data'] = Transaksi::with('user','alamat_pengiriman', 'transaksi_produk.master_produk')->where('uuid', $uuid)->first();
        $data['kode_voucher'] = KodeVoucher::where('kode_voucher', $data['data']->kode_voucher)->first();
        return view('admin.apps.transaksi.transaksi-detail', $data);
    }

    public function cetak_invoice_pdf($uuid){
        $data['data'] = Transaksi::with('user','alamat_pengiriman', 'transaksi_produk.master_produk')->where('uuid', $uuid)->first();
        $data['kode_voucher'] = KodeVoucher::where('kode_voucher', $data['data']->kode_voucher)->first();
        return view('admin.apps.transaksi.transaksi-invoice-pdf',$data);
    }

    public function approval($id, $status, $resi_pengiriman = null, $jasa_pengiriman_code = null, $type = null){

         $transaksi = Transaksi::with('user', 'transaksi_produk')->where('id', $id)->first();

        DB::beginTransaction();

		try{

			if($status == Transaksi::DIKIRIM){
                Transaksi::where('id', $id)->update(['status' => $status, 'resi_pengiriman' => $resi_pengiriman, 'jasa_pengiriman_code' => $jasa_pengiriman_code]);

                if($type == 'edit'){
                    DB::commit();
                    return [
                        'status' => 200,
                        'message' => 'Data pengiriman berhasil dirubah'
                    ];
                }

            }else{
                Transaksi::where('id', $id)->update(['status' => $status]);
            }

            if($status == Transaksi::CANCEL){
                $message = 'Data berhasil ditolak';

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

                    //MASTER PRODUK LOG
                    $tipe = '+';
                    $keterangan = 'Penambahan stock dari transaksi ' . $transaksi->no_invoice . ' yang di cancel atau tolak';
                    $quantity = $transaksi_produk->quantity;

                    MasterProdukLog::create([
                        'master_produk_id' => $master_produk->id,
                        'tipe' => $tipe,
                        'quantity' => $quantity,
                        'harga' => $master_produk->harga_beli,
                        'keterangan' => $keterangan,
                    ]);
                }

                $data = [
                    'nama' => $transaksi->user->nama,
                    'no_invoice' => $transaksi->no_invoice,
                    'total_harga' => $transaksi->total_harga,
                ];
                $email = $transaksi->user->email;
                Mail::to($email)->send(new TransaksiCancel($data));

                //KIRIM PERSEORANGAN
                Http::post(env('URL_WA_SERVER').'/chats/send?id=notifications', [
                    'receiver' =>  Convert::convert_telepon_to_whatsapp($transaksi->user->no_telepon),
                    'message'  => [ 'text' => "Maaf transaksimu $transaksi->no_invoice kami batalin nih karena melewati masa pembayaran atau pembayaranmu kami tolak :( Terimakasih sudah berbelanja di SIMANHURA" ]
                ]);

                Transaksi::where('id', $transaksi->id)->update(['status' => '5']);

            }else{
                $message = 'Data berhasil dikonfirmasi';
            }

            $transaksi_all = Transaksi::all();
            $data['count_semua'] = $transaksi_all->count();
            $data['count_belum_bayar'] = $transaksi_all->where('status', Transaksi::BELUM_BAYAR)->count();
            $data['count_konfirmasi_admin'] = $transaksi_all->where('status', Transaksi::KONFIRMASI_ADMIN)->count();
            $data['count_dikemas'] = $transaksi_all->where('status', Transaksi::DIKEMAS)->count();
            $data['count_dikirim'] = $transaksi_all->where('status', Transaksi::DIKIRIM)->count();
            $data['count_selesai'] = $transaksi_all->where('status', Transaksi::SELESAI)->count();
            $data['count_cancel'] = $transaksi_all->where('status', Transaksi::CANCEL)->count();

            if($status == Transaksi::SELESAI){
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
            }

            //NOTIFICATION
            $notification_type = '';
            switch ($status) {
                case Transaksi::KONFIRMASI_ADMIN:

                    //NOTIF MOBILE
                    $pengumuman = "Pembayaranmu untuk transaksi $transaksi->no_invoice sudah kami terima. Selanjutnya pesananmu akan kami proses ya";

                    $data = [
                        'nama' => $transaksi->user->nama,
                        'no_invoice' => $transaksi->no_invoice,
                        'total_harga' => $transaksi->total_harga,
                    ];
                    $email = $transaksi->user->email;
                    Mail::to($email)->send(new TransaksiKonfirmasiAdmin($data));

                    $notification_type = 'transaksi_approve';

                    //KIRIM PERSEORANGAN
                    Http::post(env('URL_WA_SERVER').'/chats/send?id=notifications', [
                    	'receiver' =>  Convert::convert_telepon_to_whatsapp($transaksi->user->no_telepon),
                    	'message'  => [ 'text' => "Pembayaranmu untuk transaksi $transaksi->no_invoice sudah kami terima. Selanjutnya pesananmu akan kami proses ya :) Terimakasih sudah berbelanja di SIMANHURA" ]
                    ]);

                    break;
                case Transaksi::DIKEMAS:

                    //NOTIF MOBILE
                    $pengumuman = "Transaksi $transaksi->no_invoice sedang kami kemas";

                    $data = [
                        'nama' => $transaksi->user->nama,
                        'no_invoice' => $transaksi->no_invoice,
                    ];
                    $email = $transaksi->user->email;
                    Mail::to($email)->send(new TransaksiDikemas($data));

                    $notification_type = 'transaksi_dikemas';

                    //KIRIM PERSEORANGAN
                    Http::post(env('URL_WA_SERVER').'/chats/send?id=notifications', [
                    	'receiver' =>  Convert::convert_telepon_to_whatsapp($transaksi->user->no_telepon),
                    	'message'  => [ 'text' => "Transaksi $transaksi->no_invoice sedang kami kemas :) Terimakasih sudah berbelanja di SIMANHURA" ]
                    ]);

                    break;
                case Transaksi::DIKIRIM:

                    //NOTIF MOBILE
                    $pengumuman = "Transaksi $transaksi->no_invoice sedang kami kirim dengan nomor resi $resi_pengiriman";

                    $data = [
                        'nama' => $transaksi->user->nama,
                        'no_invoice' => $transaksi->no_invoice,
                        'no_resi' => $resi_pengiriman,
                    ];
                    $email = $transaksi->user->email;
                    Mail::to($email)->send(new TransaksiDikirim($data));

                    $notification_type = 'transaksi_dikirim';

                    //KIRIM PERSEORANGAN
                    Http::post(env('URL_WA_SERVER').'/chats/send?id=notifications', [
                    	'receiver' =>  Convert::convert_telepon_to_whatsapp($transaksi->user->no_telepon),
                    	'message'  => [ 'text' => "Transaksi $transaksi->no_invoice sedang kami kirim dengan nomor resi $resi_pengiriman :) Terimakasih sudah berbelanja di SIMANHURA" ]
                    ]);

                    break;
                case Transaksi::SELESAI:

                    //NOTIF MOBILE
                    $pengumuman = "Transaksi $transaksi->no_invoice sudah selesai jangan lupa berikan penilaian ya";

                    $data = [
                        'nama' => $transaksi->user->nama,
                        'no_invoice' => $transaksi->no_invoice,
                    ];
                    $email = $transaksi->user->email;
                    Mail::to($email)->send(new TransaksiSelesai($data));

                    $notification_type = 'transaksi_selesai';

                    //KIRIM PERSEORANGAN
                    Http::post(env('URL_WA_SERVER').'/chats/send?id=notifications', [
                    	'receiver' =>  Convert::convert_telepon_to_whatsapp($transaksi->user->no_telepon),
                    	'message'  => [ 'text' => "Transaksi $transaksi->no_invoice sudah selesai jangan lupa berikan penilaian ya :) Terimakasih sudah berbelanja di SIMANHURA" ]
                    ]);

                    break;
                case Transaksi::CANCEL:

                    //NOTIF MOBILE
                    $pengumuman = "Maaf transaksimu $transaksi->no_invoice kami batalin nih karena melewati masa pembayaran atau pembayaranmu kami tolak";

                    $data = [
                        'nama' => $transaksi->user->nama,
                        'no_invoice' => $transaksi->no_invoice,
                    ];
                    $email = $transaksi->user->email;
                    Mail::to($email)->send(new TransaksiCancel($data));

                    $notification_type = 'transaksi_cancel';

                    //KIRIM PERSEORANGAN
                    Http::post(env('URL_WA_SERVER').'/chats/send?id=notifications', [
                    	'receiver' =>  Convert::convert_telepon_to_whatsapp($transaksi->user->no_telepon),
                    	'message'  => [ 'text' => "Maaf transaksimu $transaksi->no_invoice kami batalin nih karena melewati masa pembayaran atau pembayaranmu kami tolak. Salam Hangat SIMANHURA" ]
                    ]);

                    break;
            }

            //NOTIFICATION ONE SIGNAL
            $content = array(
                "en" => $pengumuman,
                );

            $filters[] = [
                'field' => 'tag',
                'key' => 'userId',
                "relation" => "=",
                "value" => $transaksi->user->id,
            ];

            $fields = array(
                'app_id' => "6346f95b-1fb8-4a4d-849a-890bffe607c2",
                'filters' => $filters,
                'contents' => $content
            );
            $fields = json_encode($fields);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                                    'Authorization: Basic NGNlNTE2NDQtMjBiNi00ODMzLWJhZWUtNTVjNTk1YWFiMWM1'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

            $response = curl_exec($ch);
            curl_close($ch);

            //NOTIFICATION
            if($notification_type != ''){
                $transaksi = Transaksi::find($id);
                Notification::create([
                    'user_id' => $transaksi->user_id,
                    'transaksi_id' => $transaksi->id,
                    'notification_type' => $notification_type,
                ]);
            }

			DB::commit();

			return [
                'status' => 200,
                'message' => $message,
                'data' => $data,
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

    public function cetak_resi_pengiriman($id){

        $data['transaksi'] = Transaksi::with('alamat_pengiriman', 'transaksi_produk.master_produk')->where('id', $id)->first();
        $data['asal_pengiriman'] = AsalPengiriman::where('id', 1)->first();

        $pdf = Pdf::loadview('pdf.resi-pengiriman',$data);
        $pdf->setPaper("A4","potrait");

        return [
            'status' => 200,
            'data' => [
                'base64' => 'data:application/pdf;base64,'.base64_encode($pdf->stream()),
                'filename' => 'Resi Pengiriman Invoice ' . $data['transaksi']->no_invoice ,
            ],
        ];
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
            return view('errors.resi-tidak-ditemukan');
            // return [
            //     'status' => 300,
            //     'message' => $err,
            // ];
        }

        $response = json_decode($response, true);

        if($response['rajaongkir']['status']['code'] == 400){
            return view('errors.resi-tidak-ditemukan');
            // return [
            //     'status' => 300,
            //     'message' => 'Data belum tersedia'
            // ];
        }

        $response = collect($response['rajaongkir']['result']);

        if(count($response) == 0){
            return view('errors.resi-tidak-ditemukan');
        }

        $data['transaksi'] = $transaksi;
        $data['data'] = $response;

        return view('admin.apps.transaksi.track-order', $data);
    }
}
