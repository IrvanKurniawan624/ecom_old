<?php

namespace App\Http\Controllers\Admin\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Helpers\Convert;

use DB;
use DataTables;
use Carbon\Carbon;

use App\Models\User;
use App\Models\PoinLog;
use App\Models\PoinStrukOffline;
use App\Models\Notification;

class PointStrukOfflineController extends Controller
{
    public function index(){
        return view('admin.apps.point-struk-offline.index');
    }

    public function datatables(){
        $data = PoinStrukOffline::with('user.tipe_customer')->orderBy('id','DESC')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->rawColumns(['status_badge'])
            ->make(true);
    }

    public function detail($id){
        $data['data'] = PoinStrukOffline::where('id', $id)->with('user.tipe_customer')->first();
        return view('admin.apps.point-struk-offline.detail', $data);
    }

    public function approve(request $request){

        $poin_struk_offline = PoinStrukOffline::find($request->id);

        DB::beginTransaction();

		try{

            $message = 'Data berhasil ditolak';
            if($request->type == 1){
                $message = 'Data berhasil diterima';
                $request->merge(['poin' => Convert::convert_to_number($request->poin) ]);

                $user = User::where('id', $poin_struk_offline->user_id)->first();
                $old_poin = $user->poin;
                $user->poin = $old_poin + $request->poin;
                $user->save();

                
                PoinLog::create([
                    'user_id' => $poin_struk_offline->user_id,
                    'status' => '+',
                    'nominal' => $request->poin,
                    'sisa_poin' => $user->poin,
                    'keterangan' => 'Penambahan poin dari struk belanja total ' . "Rp " . number_format($poin_struk_offline->nominal_belanja,0,',','.'),
                ]);

                Notification::create([
                    'user_id' => $poin_struk_offline->user_id,
                    'judul' => 'Yeay! Anda mendapatkan bonus poin dari struk offline',
                    'pengumuman' => 'Selamat anda mendapatkan bonus sejumlah ' . number_format($request->poin,0,',','.') . ' poin dari struk belanja anda',
                    'notification_type' => 'bonus_poin',
                ]);

                PoinStrukOffline::where('id', $request->id)->update(['status' => $request->type, 'poin' => $request->poin]);
            }

            PoinStrukOffline::where('id', $request->id)->update(['status' => $request->type]);

			DB::commit();

            return [
                'status' => 200,
                'message' => $message
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
