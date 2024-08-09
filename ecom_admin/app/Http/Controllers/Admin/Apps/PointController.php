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

class PointController extends Controller
{
    public function index(){
        return view('admin.apps.point.index');
    }

    public function datatables(){
        $data = User::with('tipe_customer')->customerAll()->orderBy('tipe_customer_id','DESC')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_history(request $request){
        $data = PoinLog::where('user_id', $request->user_id)->latest('id')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function add_poin(request $request){

        $request->merge(['tambah_poin' => Convert::convert_to_double($request->tambah_poin) ]);

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'tambah_poin' => 'required|numeric|min:0',
            'poin' => 'required|numeric|min:0',
        ]);

        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $user = User::where('id', $request->id)->first();
        $old_poin = $user->poin;

        $user->poin = $old_poin + $request->tambah_poin;
        $user->save();

        //TAMBAHKAN LOG POIN
        Poinlog::create([
            'user_id' => $user->id,
            'status' => '+',
            'nominal' => $request->tambah_poin,
            'sisa_poin' => $user->poin,
            'keterangan' => 'Penambahan poin oleh admin'
        ]);

        return [
            'status' => 200,
            'message' => 'Poin berhasil ditambahkan'
        ];


    }
}
