<?php

namespace App\Http\Controllers\Admin\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use DB;
use DataTables;
use Carbon\Carbon;

use App\Models\MasterProduk;
use App\Models\MarketplaceTransaksi;
use App\Models\MarketplaceTransaksiProduk;
use App\Models\Transaksi;
use App\Models\TransaksiProduk;

class SyncMarketplaceController extends Controller
{
    public function index(){
        return view('admin.apps.sync-marketplace.index');
    }

    public function data_header_marketplace(){
        $data['pendapatan_pending_shopee'] = MarketplaceTransaksiProduk::whereHas('marketplace_transaksi', function($query){
            $query->whereNull('deleted_at')->where(['tipe' => 'shopee', 'status' => '0']);
        })->sum('harga');

        $data['pendapatan_shopee'] = MarketplaceTransaksiProduk::whereHas('marketplace_transaksi', function($query){
            $query->whereNull('deleted_at')->where(['tipe' => 'shopee', 'status' => '1']);
        })->sum('harga');

        $data['pendapatan_pending_tokopedia'] = MarketplaceTransaksiProduk::whereHas('marketplace_transaksi', function($query){
            $query->whereNull('deleted_at')->where(['tipe' => 'tokopedia', 'status' => '0']);
        })->sum('harga');

        $data['pendapatan_tokopedia'] = MarketplaceTransaksiProduk::whereHas('marketplace_transaksi', function($query){
            $query->whereNull('deleted_at')->where(['tipe' => 'tokopedia', 'status' => '1']);
        })->sum('harga');

        $data['pendapatan_pending_shopee'] = "Rp " . number_format($data['pendapatan_pending_shopee'],0,',','.') ;
        $data['pendapatan_shopee'] = "Rp " . number_format($data['pendapatan_shopee'],0,',','.') ;
        $data['pendapatan_pending_tokopedia'] = "Rp " . number_format($data['pendapatan_pending_tokopedia'],0,',','.') ;
        $data['pendapatan_tokopedia'] = "Rp " . number_format($data['pendapatan_tokopedia'],0,',','.') ;

        return $data;
    }

    public function datatables(){
        $data = MarketplaceTransaksi::orderBy('status', 'ASC')->orderBy('tanggal_transaksi', 'ASC')->orderBy('status', 'ASC')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('select_item', static function ($data) {
                return '<input type="checkbox" name="produk_item" id="produk_item" value="'.$data->id.'"/>';
            })
            ->rawColumns(['select_item'])
            ->make(true);
    }

    public function delete($id){

        DB::beginTransaction();

		try{
			
            MarketplaceTransaksi::where('id', $id)->delete();

            //RESTORE STOCK MASTER PRODUK
            $marketplace_transaksi_produk = MarketplaceTransaksiProduk::where('marketplace_transaksi_id', $id)->get();
            foreach($marketplace_transaksi_produk as $item){
                $master_produk = MasterProduk::find($item->master_produk_id);
                $old_stock = $master_produk->stock;
    
                $master_produk->stock = $old_stock + $item->quantity;
                $master_produk->save();
            }
    
            MarketplaceTransaksiProduk::where('marketplace_transaksi_id', $id)->delete();
    
			DB::commit();


            return [
                'status' => 201,
                'link' => '/admin/apps/sync-marketplace',
                'message' => 'Data berhasil dihapus'
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

    public function create(request $request){

        $validator = Validator::make($request->all(), [
            'master_produk_harga.*' => 'required',
            'tipe' => 'required',
            'tanggal_transaksi' => 'required',
            'no_invoice' => 'required',
            'master_produk_id' => 'required',
            'master_produk_id.*' => 'required',
            'master_produk_nama_produk.*' => 'required',
            'master_produk_sisa_produk.*' => 'required',
            'quantity.*' => 'required',
        ]);

        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        DB::beginTransaction();

		try{

			$total_harga = 0;
            foreach($request->master_produk_harga as $item){
                $total_harga += $item;
            }

            $marketplace_transaksi = MarketplaceTransaksi::create([
                'tipe' => $request->tipe,
                'tanggal_transaksi' => $request->tanggal_transaksi,
                'uuid' => Str::uuid(),
                'no_invoice' => $request->no_invoice,
                'total_harga' => $total_harga,
            ]);

            //CEK STOCK PRODUCT
            foreach($request->master_produk_id as $key => $item){
                $master_produk_stock = MasterProduk::active()->where('id', $item)->first()->stock;

                if($master_produk_stock < $request->quantity[$key]){
                    return [
                        'status' => 300,
                        'message' => 'Terdapat produk ' . $request->master_produk_nama_produk[$key] .  ' yang hanya tersisa ' . $master_produk_stock,
                    ];
                }

                MarketplaceTransaksiProduk::create([
                    'marketplace_transaksi_id' => $marketplace_transaksi->id,
                    'master_produk_id' => $item,
                    'quantity' => $request->quantity[$key],
                    'harga' => $request->master_produk_harga[$key],
                ]);

                MasterProduk::where('id', $item)->update([
                    'stock' => $master_produk_stock - $request->quantity[$key],
                ]);
            }

			DB::commit();

			return [
				'status' => 201, // SUCCESS
                'link' => '/admin/apps/sync-marketplace',
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

    public function action_selected(request $request){
        if($request->tipe == 'approved'){
            DB::beginTransaction();

            //1 = USER SHOPEE
            //2 = USER TOKOPEDIA

            try{
                $marketplace_transaksi_new = MarketplaceTransaksi::with('marketplace_transaksi_produk')->whereIn('id', $request->array)->get();

                foreach($marketplace_transaksi_new as $key => $item){                

                    if($item->status == 0){
                        //CLONE TO TRANSAKSI

                        $user_id = $item->tipe == 'shopee' ? 1 : 2;

                        $transaksi = Transaksi::create([
                            'uuid' => $item->uuid,
                            'no_invoice' => $item->no_invoice,
                            'user_id' => $user_id,
                            'datetime_batas_pembayaran' => Carbon::now(),
                            'status' => Transaksi::SELESAI,
                            'jasa_pengiriman' => '-',
                            'harga_pengiriman' => 0,
                            'total_berat' => 0,
                            'total_harga' => $item->total_harga,
                            'created_at' => $item->tanggal_transaksi,
                        ]);

                        foreach($item->marketplace_transaksi_produk as $detail){
                            TransaksiProduk::create([
                                'transaksi_id' => $transaksi->id,
                                'master_produk_id' => $detail->master_produk_id,
                                'quantity' => $detail->quantity,
                                'harga' => $detail->harga,
                                'status' => 0,
                            ]);
                        }

                        MarketplaceTransaksi::whereIn('id', $request->array)->update(['status' => 1]);
                        MarketplaceTransaksiProduk::whereIn('marketplace_transaksi_id', $request->array)->update(['status' => 1]);
                    }else{
                        return [
                            'status' => 300,
                            'message' => 'Invoice '. $item->no_invoice .' sudah status approved'
                        ];
                    }
                }

                DB::commit();

                return [
                    'status' => 200, // SUCCESS
                    'message' => 'Data Berhasil diupdate'
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
}
