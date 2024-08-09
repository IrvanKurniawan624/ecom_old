<?php

namespace App\Http\Controllers\Admin\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use DB;
use DataTables;
use Carbon\Carbon;

use App\Models\AsalPengiriman;
use App\Models\JasaPengiriman;

class JasaPengirimanController extends Controller
{
    public function index(){
        return view('admin.apps.jasa-pengiriman.index');
    }

    public function datatables(){
        $data = JasaPengiriman::orderBy('id','desc')->orderBy('status', 'asc')->get();

        return DataTables::of($data)
                    ->addIndexColumn()
                    ->make(true);
    }

    public function datatables2(){
        $data = AsalPengiriman::with('master_seller')->orderBy('id','desc')->get();

        return DataTables::of($data)
                    ->addIndexColumn()
                    ->make(true);
    }

    public function detail($id){
        return AsalPengiriman::find($id);
    }

    public function delete($id){
        $delete = AsalPengiriman::find($id);
        
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

    public function action($id, $status){
        JasaPengiriman::where('id', $id)->update(['status' => $status]);

        if($status == 1){
            $message = 'Data berhasil diaktifkan';
        }else{
            $message = 'Data berhasil dinon-aktifkan';

        }

        return [
            'status' => 200,
            'message' => $message
        ];
    }

    public function store_update(request $request){
        $validator = Validator::make($request->all(), [
            'provinsi_id' => 'required',
            'provinsi' => 'required',
            'kota_id' => 'required',
            'kota' => 'required',
        ]);

        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        AsalPengiriman::where('id', '1')->update($request->all());

        return [
            'status' => 201,
            'link' => '/admin/apps/jasa-pengiriman',
            'message' => 'Data Asal Pengiriman berhasil dirubah'
        ];

    }
}
