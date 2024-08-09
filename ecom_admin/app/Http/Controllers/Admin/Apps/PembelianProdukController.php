<?php

namespace App\Http\Controllers\Admin\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Helpers\Convert;

use DB;
use DataTables;
use Carbon\Carbon;

use App\Models\MasterProduk;
use App\Models\PembelianProduk;
use App\Models\PembayaranProduk;
use App\Models\MasterProdukLog;
use App\Models\PembelianProdukDetail;

class PembelianProdukController extends Controller
{
    public function index(){
        $pembelian_hutang = PembelianProduk::where(['is_cash' => PembelianProduk::IS_HUTANG, 'status' => PembelianProduk::BELUM_LUNAS])->sum('total_pembelian') - PembelianProduk::where(['is_cash' => PembelianProduk::IS_HUTANG, 'status' => PembelianProduk::BELUM_LUNAS])->sum('total_pembayaran');
        $pembelian_lunas = PembelianProduk::where(['status' => '2'])->sum('total_pembelian') + PembelianProduk::where(['is_cash' => PembelianProduk::IS_HUTANG, 'status' => PembelianProduk::BELUM_LUNAS])->sum('total_pembayaran');

        $data['pembelian_hutang'] = "Rp " . number_format($pembelian_hutang,0,',','.');
        $data['pembelian_lunas'] = "Rp " . number_format($pembelian_lunas,0,',','.');

        return view('admin.apps.pembelian-produk.index', $data);
    }

    public function detail($uuid){
        $data['data'] = PembelianProduk::where('uuid', $uuid)->first();
        return view('admin.apps.pembelian-produk.detail', $data);
    }

    public function datatables(){
        $data = PembelianProduk::with('master_supplier')->orderBy('status', 'ASC')->orderBy('id', 'DESC')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function store_update(request $request){
        $validator = Validator::make($request->all(), [
            'master_supplier_id' => 'required',
            'no_dokumen' => 'required',
            'tanggal' => 'required',
            'is_cash' => 'required',
        ]);

        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        if($request->type != 'update'){
            $request->request->add(['uuid' => Str::uuid()]);
        }
        PembelianProduk::updateOrCreate(['id' => $request->id],$request->all() );

        return [
            'status' => 200, // SUCCESS
            'message' => 'Data berhasil disimpan'
        ];

    }

    // =================

    public function detail_lock(request $request){
        $validator = Validator::make($request->all(), [
            'pembelian_produk_id' => 'required',
        ]);

        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        DB::beginTransaction();

		try{

			$pembelian_produk_detail = PembelianProdukDetail::where('pembelian_produk_id', $request->pembelian_produk_id)->get();
            $total_pembelian = 0;
            foreach($pembelian_produk_detail as $item){
                $total_pembelian += $item->quantity * $item->harga_beli;

                //MASTER PRODUK
                $master_produk = MasterProduk::where('id', $item->master_produk_id)->first();
                MasterProduk::updateOrCreate(['id' => $item->master_produk_id],[
                    'harga_beli' => $item->harga_beli,
                    'harga_jual_b2c' => $item->harga_jual_b2c,
                    'harga_jual_b2b' => $item->harga_jual_b2b,
                    'diskon' => $item->diskon == 0 ? null : $item->diskon,
                    'is_publish' => $item->is_publish,
                    'stock' => $master_produk->stock + $item->quantity,
                ]);

                //MASTER PRODUK LOG
                $tipe = '+';
                $keterangan = 'Penambahan stock dari pembelian produk ' . $request->no_dokumen;
                $quantity = $item->quantity;

                MasterProdukLog::create([
                    'master_produk_id' => $master_produk->id,
                    'tipe' => $tipe,
                    'quantity' => $quantity,
                    'harga' => $item->harga_beli,
                    'keterangan' => $keterangan,
                ]);

            }

            $pembelian_produk = PembelianProduk::where('id', $request->pembelian_produk_id)->first();
            $status = $pembelian_produk->is_cash == 1 ? 2 : 1;
            PembelianProduk::where('id', $request->pembelian_produk_id)->update([
                'total_pembelian' => $total_pembelian,
                'status' => $status,
            ]);

			DB::commit();

			return [
                'status' => 201, // SUCCESS
                'link' => '/admin/apps/pembelian-produk',
                'message' => 'Data berhasil disimpan'
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

    public function detail_produk($id){
        return PembelianProdukDetail::find($id);
    }

    public function detail_datatables(request $request){
        $data = PembelianProdukDetail::with('pembelian_produk')->where('pembelian_produk_id', $request->pembelian_produk_id)->orderBy('id', 'DESC')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function detail_store_update(request $request){
        $validator = Validator::make($request->all(), [
            'pembelian_produk_id' => 'required',
            'master_produk_id' => 'required',
            'is_publish' => 'required',
            'diskon' => 'required',
            'harga_beli' => 'required',
            'harga_jual_b2c' => 'required',
            'harga_jual_b2b' => 'required',
            'quantity' => 'required',
        ]);

        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $request->merge(['harga_beli' => Convert::convert_to_double($request->harga_beli) ]);
        $request->merge(['harga_jual_b2c' => Convert::convert_to_double($request->harga_jual_b2c) ]);
        $request->merge(['harga_jual_b2b' => Convert::convert_to_double($request->harga_jual_b2b) ]);

        // $pembelian_produk = PembelianProduk::find($request->pembelian_produk_id);
        // $total_belanja = $pembelian_produk->total_belanja + ($request->harga_beli * $request->quantity);
        // PembelianProduk::where('id', $request->pembelian_produk_id)->update([
        //     'total_belanja' => $total_belanja,
        // ]);
        PembelianProdukDetail::updateOrCreate(['id' => $request->id],$request->all() );

        return [
            'status' => 200, // SUCCESS
            'message' => 'Data berhasil disimpan'
        ];

    }

    public function detail_delete($id){
        $delete = PembelianProdukDetail::find($id);

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
    // =================

    public function pembayaran(){
        return view('admin.apps.pembelian-produk.pembayaran');
    }


    public function pembayaran_datatables(){
        $data = PembayaranProduk::with('pembelian_produk.master_supplier')->orderBy('id', 'DESC')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function pembayaran_store(request $request){
        $validator = Validator::make($request->all(), [
            'pembelian_produk_id.*' => 'required',
            'pembayaran.*' => 'required',
        ]);

        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        DB::beginTransaction();

		try{

			foreach($request->pembelian_produk_id as $key => $item){
                PembayaranProduk::create([
                    'pembelian_produk_id' => $item,
                    'pembayaran' => Convert::convert_to_double($request->pembayaran[$key]),
                ]);

                $pembelian_produk = PembelianProduk::find($item);
                $total_pembayaran = $pembelian_produk->total_pembayaran ?? 0;
                PembelianProduk::where('id', $item)->update([
                    'total_pembayaran' => Convert::convert_to_double($request->pembayaran[$key]) + $total_pembayaran,
                ]);
            }


			DB::commit();

			return [
				'status' => 200, // SUCCESS
				'message' => 'Data berhasil disimpan'
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
