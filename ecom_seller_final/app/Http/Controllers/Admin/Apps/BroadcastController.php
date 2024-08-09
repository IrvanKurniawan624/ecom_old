<?php

namespace App\Http\Controllers\Admin\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use DB;
use DataTables;
use Carbon\Carbon;

use App\Models\Notification;
use App\Models\User;

class BroadcastController extends Controller
{
    public function index(){
        return view('admin.apps.broadcast.index');
    }

    public function datatables(){
        $data = Notification::where(['notification_type' => 'pengumuman'])->groupBy('judul')->orderBy('id','desc')->get();

        return DataTables::of($data)
                    ->addIndexColumn()
                    ->make(true);
    }

    public function create(request $request){
        $user = User::active();
        if($request->tipe_broadcast == 'B2B'){
            $user = $user->where('tipe_customer_id',3);
        }elseif($request->tipe_broadcast == 'B2C'){
            $user = $user->where('tipe_customer_id',2);
        }

        $user = $user->get();
        $request->request->add(['notification_type' => 'pengumuman']);
        $request->request->add(['is_new' => '1']);
        $request->request->add(['status' => '1']);

        DB::beginTransaction();

		try{

			foreach($user as $item){
                $request->request->add(['user_id' => $item->id]);
                Notification::create($request->all());
            }

			DB::commit();

			return [
				'status' => 200, // SUCCESS
				'message' => 'Broadcast berhasil dikirim'
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
