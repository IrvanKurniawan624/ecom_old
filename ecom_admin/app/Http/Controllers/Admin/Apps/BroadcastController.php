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

            if($request->tipe_broadcast == 'ALL'){
                $content = array(
                    "en" => $request->pengumuman,
                    );

                $fields = array(
                    'app_id' => "6346f95b-1fb8-4a4d-849a-890bffe607c2",
                    'included_segments' => array('Subscribed Users'),
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
            }else{

                $content = array(
                    "en" => $request->pengumuman,
                    );

                $filters[] = array(
                        'field' => 'tag',
                        'key' => 'tipeCustomer',
                        "relation" => "=",
                        "value" => $request->tipe_broadcast,
                );

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
