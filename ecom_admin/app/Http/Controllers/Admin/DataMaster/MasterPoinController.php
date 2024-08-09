<?php

namespace App\Http\Controllers\Admin\DataMaster;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

use App\Helpers\Convert;
use DB;
use DataTables;
use Carbon\Carbon;

use App\Models\MasterGlobal;
use App\Models\Notification;
use App\Models\MasterPoin;
use App\Models\PoinLog;
use App\Models\User;

class MasterPoinController extends Controller
{
    public function index(){
        $data['bonus_pembelian'] = MasterGlobal::where('tipe', 'bonus_poin_pembelian')->first();
        $data['minimal_use_poin'] = MasterGlobal::where('tipe', 'minimal_use_poin')->first();
        return view('admin.data-master.master-poin.index', $data);
    }

    public function detail($id){
        return MasterPoin::find($id);
    }

    public function datatables(){
        $data = MasterPoin::orderBy('status','DESC')->orderBy('id','DESC')->get();

        return DataTables::of($data)
                    ->addIndexColumn()
                    ->make(true);
    }

    public function store_update(request $request){
        $array_validation = [
            'title' => 'required',
            'poin' => 'required',
        ];

        $validator = Validator::make($request->all(), $array_validation);

		if($validator->fails()) {
			return [
				'status' => 300,
				'message' => $validator->errors()->first()
			];
		}

        $request->merge(['poin' => Convert::convert_to_double($request->poin) ]);

        MasterPoin::updateOrCreate(['id' => $request->id],$request->all() );

        return [
            'status' => 200,
            'message' => 'Data berhasil disimpan',
        ];
    }

    public function store_pendapatan_belanja(request $request){
        $array_validation = [
            'akumulasi_pembelian' => 'required',
            'pendapatan_belanja_poin' => 'required',
        ];

        $validator = Validator::make($request->all(), $array_validation);

		if($validator->fails()) {
            return [
                'status' => 300,
				'message' => $validator->errors()->first()
			];
		}

        MasterGlobal::where('tipe', 'bonus_poin_pembelian')->update([
            'value1' => Convert::convert_to_double($request->akumulasi_pembelian),
            'value2' => $request->pendapatan_belanja_poin
        ]);

        return [
            'status' => 200,
            'message' => 'Data variable global berhasil diperbaharui'
        ];
    }

    public function store_minimal_use_poin(request $request){
        $array_validation = [
            'minimal_pembelian' => 'required',
            'presentase' => 'required',
        ];

        $validator = Validator::make($request->all(), $array_validation);
		if($validator->fails()) {
            return [
                'status' => 300,
				'message' => $validator->errors()->first()
			];
		}

        MasterGlobal::where('tipe', 'minimal_use_poin')->update([
            'value1' => Convert::convert_to_double($request->minimal_pembelian),
            'value2' => $request->presentase
        ]);

        return [
            'status' => 200,
            'message' => 'Data variable global berhasil diperbaharui'
        ];
    }
}
