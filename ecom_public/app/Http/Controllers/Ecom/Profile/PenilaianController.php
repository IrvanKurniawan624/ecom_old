<?php

namespace App\Http\Controllers\Ecom\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use DB;
use DataTables;
use Carbon\Carbon;

use App\Models\Transaksi;
use App\Models\TransaksiProduk;
use App\Models\UlasanPelanggan;

class PenilaianController extends Controller
{
    public function detail($uuid){
        $data['data'] = TransaksiProduk::with('master_produk','transaksi')->whereHas('transaksi', function($query) use ($uuid){
            $query->where('uuid', $uuid);
        })->get();
        $data['transaksi'] = Transaksi::where('uuid', $uuid)->first();

        return view('ecom.profile.profile-penilaian', $data);
    }

    public function store(request $request){
        $validator = Validator::make($request->all(), [
            'transaksi_id' => 'required',
            'id.*' => 'required',
            'bintang.*' => 'required',
            'komentar.*' => 'required',
        ]);

        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        DB::beginTransaction();

		try{

			foreach($request->id as $key => $item){
                TransaksiProduk::where(['id' => $item, 'transaksi_id' => $request->transaksi_id])->update([
                    'bintang' => $request->bintang[$key],
                    'status' => 1,
                    'komentar' => $request->komentar[$key],
                ]);
            }

			DB::commit();

			return [
				'status' => 201, // SUCCESS
				'link' => '/profile/transaksi-belanja?status=penilaian',
				'message' => 'Komentar berhasil diberikan terimakasih atas feedbacknya'
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
