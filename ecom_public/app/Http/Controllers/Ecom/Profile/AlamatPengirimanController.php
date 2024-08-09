<?php

namespace App\Http\Controllers\Ecom\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use DB;
use DataTables;
use Carbon\Carbon;

use App\Models\AlamatPengiriman;

class AlamatPengirimanController extends Controller
{
    public function index(){
        $data['count_alamat_pengiriman'] = AlamatPengiriman::where('user_id', auth()->user()->id)->count();
        return view('ecom.profile.profile-alamat-pengiriman', $data);
    }

    public function detail($id){
        return AlamatPengiriman::find($id);
    }

    public function store_update(request $request){
        $array_validation = [
            'penerima' => 'required',
            'no_telepon' => 'required',
            'provinsi' => 'required',
            'kota' => 'required',
            'provinsi_id' => 'required',
            'kota_id' => 'required',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
            'kode_pos' => 'required',
            'alamat' => 'required',
        ];

        $validator = Validator::make($request->all(), $array_validation);

		if($validator->fails()) {
			return [
				'status' => 300,
				'message' => $validator->errors()->first()
			];
		}

        $request->request->add(['user_id' => auth()->user()->id]);

        $count_alamat_pengiriman = AlamatPengiriman::where('user_id', $request->user_id)->count();
        if($count_alamat_pengiriman == 0){
            $request->request->add(['alamat_utama' => '1']);
        }

        AlamatPengiriman::updateOrCreate(['id' => $request->id],$request->all() );

        return [
            'status' => 200, // SUCCESS
            'message' => 'Data berhasil disimpan'
        ];

    }

    public function delete($id){
        $delete = AlamatPengiriman::find($id);

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

    public function change_alamat_utama($id){
        $alamat_pengiriman = AlamatPengiriman::where('id', $id)->update(['alamat_utama' => '1']);
        AlamatPengiriman::where('user_id', auth()->user()->id)->WhereNotIn('id', [$id])->update(['alamat_utama' => '0']);

        return [
            'status' => 200,
            'message' => 'Alamat Utama berhasil dirubah'
        ];
    }

}
