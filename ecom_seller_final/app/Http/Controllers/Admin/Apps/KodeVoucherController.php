<?php

namespace App\Http\Controllers\Admin\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use DB;
use DataTables;
use Carbon\Carbon;

use App\Helpers\Convert;

use App\Models\Transaksi;
use App\Models\KodeVoucher;

class KodeVoucherController extends Controller
{
    public function index(){
        return view('admin.apps.kode-voucher.index');
    }

    public function detail($id){
        return KodeVoucher::with('master_package', 'user')->find($id);
    }

    public function datatables(){
        $data = KodeVoucher::with('master_package', 'user')->orderBy('id','desc')->orderBy('status', 'asc')->get();

        return DataTables::of($data)
                    ->addIndexColumn()
                    ->make(true);
    }

    public function datatables_history(request $request){
        $data = Transaksi::with('user.tipe_customer')->where(['kode_voucher' => $request->kode_voucher, 'status' => '4'])->get();

        return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('total_harga_belanja', function($item) {
                        return $item->total_harga - $item->harga_pengiriman;
                    })
                    ->make(true);
    }

    public function store_update(request $request){
        $array_validation = [
            'tipe' => 'required',
            'kode_voucher' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
            'kode_voucher' => 'required',
            'is_claim' => 'required',
            'keterangan' => 'required',
            'maksimal_penggunaan' => 'required',
        ];

        if($request->tipe == 'persen'){
            $array_validation = [
                'persen_presentase_potongan' => 'required',
                'persen_minimal_pembelian' => 'required',
                'persen_maksimal_potongan' => 'required',
            ];

            $request->merge(['persen_minimal_pembelian' => Convert::convert_to_double($request->persen_minimal_pembelian) ]);
            $request->merge(['persen_maksimal_potongan' => Convert::convert_to_double($request->persen_maksimal_potongan) ]);

            $request->merge(['master_produk_id_beli' => null]);
            $request->merge(['minimal_produk_beli' => null]);
            $request->merge(['master_produk_id_bonus' => null]);
            $request->merge(['jumlah_produk_bonus' => null]);
        }else{

            $array_validation  = [
                'master_produk_id_beli' => 'required',
                'minimal_produk_beli' => 'required',
                'master_produk_id_bonus' => 'required',
                'jumlah_produk_bonus' => 'required',
            ];

            $request->merge(['persen_presentase_potongan' => null]);
            $request->merge(['persen_minimal_pembelian' => null]);
            $request->merge(['persen_maksimal_potongan' => null]);
        }

        $validator = Validator::make($request->all(), $array_validation);

		if($validator->fails()) {
			return [
				'status' => 300,
				'message' => $validator->errors()->first()
			];
		}

        if($request->tanggal_mulai > $request->tanggal_selesai){
            return [
                'status' => 300,
                'message' => 'Oops! tanggal kurang sesuai harap cek terlebih dahulu'
            ];
        }


        if($request->voucher_spesifikasi_user == 'N'){
            $request->request->remove('user_id');
        }

        KodeVoucher::updateOrCreate(['id' => $request->id],$request->all() );

        return [
            'status' => 200, // SUCCESS
            'message' => 'Data berhasil disimpan'
        ];
    }

    public function delete($id){
        $delete = KodeVoucher::find($id);

        if($delete <> ""){
            $delete->delete();
            return [
                'status' => 200,
                'message' => 'Data berhasil dihapus'
            ];
        }

        return [
            'status' => 300,
            'message' => 'Data tidak ditemukan'
        ];
    }
}
