<?php

namespace App\Http\Controllers\Admin\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Imports\CsvDataImport;

use Excel;
use DB;
use DataTables;
use Carbon\Carbon;

use App\Models\User;
use App\Models\PoinLog;
use App\Models\MasterPoin;

class PelangganController extends Controller
{
    public function index(){
        return view('admin.pelanggan.data-pelanggan.index');
    }

    public function add(){
        return view('admin.pelanggan.data-pelanggan.add');
    }

    public function detail($id){
        $data['data'] = User::find($id);
        return view('admin.pelanggan.data-pelanggan.add', $data);
    }

    public function datatables(){
        $data = User::customerAll()->with('tipe_customer')->orderBy('tipe_customer_id','asc')->orderBy('id','desc')->get();

        return DataTables::of($data)
                    ->addIndexColumn()
                    ->make(true);
    }

    public function store_update(request $request){
        $array_validation = [
            'tipe_customer_id' => 'required',
            'no_telepon' => 'required|min:10|max:12',
            'email' => 'required|email:rfc,dns',
            'alamat' => 'required',
        ];

        $validator = Validator::make($request->all(), $array_validation);

		if($validator->fails()) {
			return [
				'status' => 300,
				'message' => $validator->errors()->first()
			];
		}

        if(substr($request->no_telepon, 0, 2) != '08'){
            return [
                'status' => 300,
                'message' => 'Nomer harus dimulai dari 08xxx',
            ];
        }

        if($request->type != 'update'){
            $request->request->add(['password' =>Hash::make('1234567890')]);
            $request->request->add(['is_active' => 1]);
            $request->request->add(['url_image' => 'berkas/ecom/default/profile-default.png']);
        }

        User::updateOrCreate(['id' => $request->id],$request->all() );

        return [
            'status' => 200, // SUCCESS
            'message' => 'Data berhasil disimpan'
        ];
    }

    public function action($id, $status){
        User::where('id', $id)->update(['is_active' => $status]);

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

    public function export_excel(){
        $data['data'] = User::with('tipe_customer')->where('tipe_customer_id', '!=', '1')->get();
        return view('excel.data-pelanggan-excel', $data);
    }

    public function import_excel(Request $request){

		if($request->hasFile('file_excel')){

			$data = Excel::toCollection(new CsvDataImport,request()->file('file_excel'))[0];
			if($data->count()){

				foreach ($data as $key => $value) {

					if(empty($value['tipe_customer'])){
						return [
							'status'     => 300, // GAGAL
							'message'    => 'Upload Data Pelanggan Gagal, ditemukan Tipe Customer yang tidak diisi dalam file yang diupload'
						];
					}

                    if($value['tipe_customer'] != 'CUSTOMER' && $value['tipe_customer'] != 'BUSINESS'){
						return [
							'status'     => 300, // GAGAL
							'message'    => 'Upload Data Pelanggan Gagal, tipe customer yang diterima hanya CUSTOMER dan BUSINESS'
						];
					}

                    if(!empty($value['npwp'] || !empty($value['lat']) || !empty($value['lng']))){
                        if($value['tipe_customer'] != 'BUSINESS'){
                            return [
                                'status'     => 300, // GAGAL
                                'message'    => 'Upload Data Pelanggan Gagal, NPWP, LAT, LNG hanya untuk tipe BUSINESS'
                            ];
                        }
                    }

                    if(empty($value['nama']) || empty($value['no_telepon']) || empty($value['email']) || empty($value['alamat'])){
                        return [
							'status'     => 300, // GAGAL
							'message'    => 'Upload Data Pelanggan Gagal, Seluruh data selain TANGGAL LAHIR, AGAMA dan NPWP wajib di isi'
						];
                    }

                    if($value['is_active'] != '0' && $value['is_active'] != '1'){
						return [
							'status'     => 300, // GAGAL
							'message'    => 'Upload Data Pelanggan Gagal, Is Active hanya bernilai 1 dan 0'
						];
					}

                    if(substr($value['no_telepon'], 0, 2) != '08'){
                        return [
                            'status' => 300,
                            'message' => 'Upload Data Pelanggan Gagal, Nomer Telepon harus dimulai dari 08xxx',
                        ];
                    }

                    $arr[] = array(
						'tipe_customer' => $value['tipe_customer'],
						'nama' => $value['nama'],
						'no_telepon' => $value['no_telepon'],
						'email' => $value['email'],
						'alamat' => $value['alamat'],
						'is_active' => $value['is_active'],
						'tanggal_lahir' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value['tanggal_lahir']))->format('Y-m-d'),
						'agama' => $value['agama'],
						'npwp' => $value['npwp'],
                        'lat' => $value['lat'],
                        'lng' => $value['lng'],
                        'poin' => $value['poin'] ?? 0,
					);
				}

				DB::beginTransaction();

				try {
					foreach($arr as $item){

                        $tipe_customer = ($item['tipe_customer'] == 'BUSINESS') ? '3' : '2';

                        $user = User::where('email', $item['email'])->first();
                        if(!empty($user)){

                            if($item['poin'] > 0){
                                //TAMBAHKAN LOG POIN
                                Poinlog::create([
                                    'user_id' => $user->id,
                                    'status' => '+',
                                    'nominal' => $item['poin'],
                                    'sisa_poin' => $item['poin'] + $user->poin,
                                    'keterangan' => 'Penambahan poin oleh admin by excel'
                                ]);
                            }

                            User::where('email', $item['email'])->update([
                                'tipe_customer_id' => $tipe_customer,
                                'nama' => $item['nama'],
                                'no_telepon' => $item['no_telepon'],
                                'email' => $item['email'],
                                'alamat' => $item['alamat'],
                                'is_active' => $item['is_active'],
                                'tanggal_lahir' => $item['tanggal_lahir'],
                                'agama' => $item['agama'],
                                'npwp' => $item['npwp'],
                                'lat' => $item['lat'],
                                'lng' => $item['lng'],
                                'poin' => $item['poin'] + $user->poin,
                            ]);


                        }else{
                            
                            $user = User::create([
                                'tipe_customer_id' => $tipe_customer,
                                'nama' => $item['nama'],
                                'no_telepon' => $item['no_telepon'],
                                'email' => $item['email'],
                                'alamat' => $item['alamat'],
                                'is_active' => $item['is_active'],
                                'tanggal_lahir' => $item['tanggal_lahir'],
                                'url_image' => 'berkas/ecom/default/profile-default.png',
                                'password' => Hash::make('customer'),
                                'poin' => '0',
                                'agama' => $item['agama'],
                                'npwp' => $item['npwp'],
                                'lat' => $item['lat'],
                                'lng' => $item['lng'],
                                'poin' => $item['poin'],
                            ]);

                            $poin_user = 0;

                            //GLOBAL POIN
                            $master_poin = MasterPoin::where(['title' => 'PELANGGAN BARU', 'status' => 1])->first();
                            if(!empty($master_poin)){
                                $poin_user += $master_poin->poin;
                                Poinlog::create([
                                    'user_id' => $user->id,
                                    'status' => '+',
                                    'nominal' => $master_poin->poin,
                                    'sisa_poin' => $poin_user,
                                    'keterangan' => 'Penambahan poin pelanggan baru'
                                ]);
                            }

                            if($item['poin'] > 0){
                                //TAMBAHKAN LOG POIN
                                $poin_user += $item['poin'];
                                Poinlog::create([
                                    'user_id' => $user->id,
                                    'status' => '+',
                                    'nominal' => $item['poin'],
                                    'sisa_poin' => $poin_user,
                                    'keterangan' => 'Penambahan poin oleh admin by excel'
                                ]);
                            }

                            if($poin_user > 0){
                                User::where('id', $user->id)->update(['poin' => $poin_user]);
                            }
                        }
                    }


					DB::commit();

					return [
						'status' => 200, // SUCCESS AND LOAD CONTENT
						'message' => 'Data Master User berhasil diimport'
					];

				}

				catch (\Exception $e) {
					DB::rollback();
					// something went wrong
					return [
						'status' 	=> 300, // GAGAL
						'message'       => (env('APP_DEBUG', 'true') == 'true')? $e->getMessage() : 'Operation error'
					];
				}

			}

			else{
	            return [
					'status' 	=> 300,
					'message' 	=> "File Excel anda kosong"
				];
            }

		}

		else{
			return [
				'status' 	=> 300,
				'message' 	=> "File Excel tidak ditemukan"
			];
		}

	}

}
