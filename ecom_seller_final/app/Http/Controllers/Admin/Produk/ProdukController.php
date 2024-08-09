<?php

namespace App\Http\Controllers\Admin\Produk;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use App\Imports\CsvDataImport;
use Illuminate\Support\Facades\Storage;

use DB;
use Excel;
use Image;
use DataTables;
use Carbon\Carbon;

use App\Libraries\QueryLibraries;
use App\Helpers\Convert;

use App\Models\MasterProduk;
use App\Models\MasterKategori;
use App\Models\MasterSubkategori;
use App\Models\MasterProperties;
use App\Models\MasterProdukSubkategori;
use App\Models\MasterProdukProperties;
use App\Models\MasterProdukHargaGrosir;
use App\Models\MasterProdukLog;

class ProdukController extends Controller
{
    public function index(){
        $data['data'] = MasterProduk::with('master_kategori', 'master_subkategori')->where('seller_id', auth()->user()->id)->orderby('id','desc')->get();

        return view('admin.produk.produk.index', $data);
    }

     public function add(){
        $data['title'] = 'Tambah Produk';
        return view('admin.produk.produk.add', $data);
    }

    public function detail($id){
        $data['title'] = 'Detail Produk';
        $data['master_produk'] = MasterProduk::with('master_subkategori')->find($id);
        if($data['master_produk']['seller_id'] !== auth()->user()->id){
            $param['unauthorize'] = 'Anda Tidak Mmeiliki Otoritas Untuk Mengubah Data ini';
            return redirect()->route('/admin/produk/', $param);
        }
        // $data['master_properties'] = MasterProperties::where('master_kategori_id', $data['master_produk']->master_kategori_id)->get();
        // $data['master_produk_properties'] = MasterProdukProperties::where('master_produk_id', $id)->oldest()->get();
        // $data['master_produk_harga_grosir_b2b'] = MasterProdukHargaGrosir::where(['master_produk_id' => $id, 'tipe' => 'b2b'])->orderBy('id','asc')->get();
        // $data['master_produk_harga_grosir_b2c'] = MasterProdukHargaGrosir::where(['master_produk_id' => $id, 'tipe' => 'b2c'])->orderBy('id','asc')->get();

        $color = ['danger', 'warning', 'info', 'primary', 'success'];
        $master_produk_subkategori = MasterProdukSubkategori::with('master_subkategori')->where('master_produk_id', $id)->oldest()->get();
        $array = [];
        foreach($master_produk_subkategori as $key => $item){
            $array[] = '<span class="badge badge-'.$color[$key].'"> '.$item->master_subkategori->subkategori.'</span>';
        }

        $data['subkategori_produk'] = $array;

        return view('admin.produk.produk.add', $data);
    }

    // public function clone($id){
    //     $data['title'] = 'Clone produk';
    //     $data['type'] = 'clone';
    //     $data['master_produk'] = MasterProduk::with('master_subkategori')->find($id);
    //     $data['master_properties'] = MasterProperties::where('master_kategori_id', $data['master_produk']->master_kategori_id)->get();
    //     $data['master_produk_properties'] = MasterProdukProperties::where('master_produk_id', $id)->oldest()->get();
    //     $data['master_produk_harga_grosir_b2b'] = MasterProdukHargaGrosir::where(['master_produk_id' => $id, 'tipe' => 'b2b'])->orderBy('id','asc')->get();
    //     $data['master_produk_harga_grosir_b2c'] = MasterProdukHargaGrosir::where(['master_produk_id' => $id, 'tipe' => 'b2c'])->orderBy('id','asc')->get();

    //     $color = ['danger', 'warning', 'info', 'primary', 'success'];
    //     $master_produk_subkategori = MasterProdukSubkategori::with('master_subkategori')->where('master_produk_id', $id)->oldest()->get();
    //     $array = [];
    //     foreach($master_produk_subkategori as $key => $item){
    //         $array[] = '<span class="badge badge-'.$color[$key].'"> '.$item->master_subkategori->subkategori.'</span>';
    //     }

    //     $data['subkategori_produk'] = $array;

    //     return view('admin.produk.produk.add', $data);
    // }

    public function datatables(){
        $data = MasterProduk::with('master_kategori', 'master_subkategori')->where('seller_id', auth()->user()->id)->orderby('id','desc')->get();

        return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('select_item', static function ($data) {
                        return '<input type="checkbox" name="produk_item" id="produk_item" value="'.$data->id.'"/>';
                    })
                    ->addColumn('produk_image', function($data) {
                        // if(str_contains($data->url_image[0], 'api-SIMANHURA.s3')) {
                        //     return '<a href="'. $data->url_image[0] .'" target="_blank"><img class="mr-3 rounded" width="55" src="'. $data->url_image[0] .'" alt="product"></a>';
                        // }else{}
                            return '<a href="/berkas/master-produk/'. $data->url_image[0] .'" target="_blank"><img class="mr-3 rounded" width="50" src="/berkas/master-produk/'. $data->url_image[0] .'" alt="product"></a>';
                    })
                    ->rawColumns(['select_item', 'produk_image'])
                    ->make(true);
    }

    public function store_update(request $request){
        $array_validation = [
            'master_kategori_id' => 'required',
            'master_subkategori_id' => 'required',
            'nama_produk' => 'required',
            'deskripsi_produk' => 'required',
            'satuan' => 'required',
            'minimal_order' => 'required',
            'berat' => 'required',
            'harga_jual_b2c' => 'required',
            'url_image' => 'required',
        ];

        $validator = Validator::make($request->all(), $array_validation);

		if($validator->fails()) {
            return [
                'status' => 300,
				'message' => $validator->errors()->first()
			];
		}

        $request->request->add(['seller_id' => auth()->user()->id ]);
        

        DB::beginTransaction();

		try{

            //MASTER PRODUK LOG
            $old_stock = 0;
            if($request->has('id')){
                $old_stock = MasterProduk::where('id', $request->id)->first()->stock ?? 0;
            }

            $array_url_image = json_encode(array_reverse($request->url_image));

            $request->merge(['harga_jual_b2c' => Convert::convert_to_double($request->harga_jual_b2c) ]);

            $request->merge(['url_image' => $array_url_image]);
            $request->request->add(['nama_produk_slug' => Str::slug($request->nama_produk, '-') . Str::uuid()->toString() ]);
            $master_produk = MasterProduk::updateOrCreate(['id' => $request->id],$request->all() );

            //MASTER PRODUK LOG
            if($request->has('stock')){
                if($request->stock > $old_stock){
                    $tipe = '+';
                    $keterangan = 'Penambahan stock dari master produk';
                    $quantity = $request->stock - $old_stock;

                    MasterProdukLog::create([
                        'master_produk_id' => $master_produk->id,
                        'tipe' => $tipe,
                        'quantity' => $quantity,
                        'harga' => $master_produk->harga_beli,
                        'keterangan' => $keterangan,
                        'seller_id' => auth()->user()->id,
                    ]);

                }elseif($request->stock < $old_stock){
                    $tipe = '-';
                    $keterangan = 'Pengurangan stock dari master produk';
                    $quantity = $old_stock - $request->stock;

                    MasterProdukLog::create([
                        'master_produk_id' => $master_produk->id,
                        'tipe' => $tipe,
                        'quantity' => $quantity,
                        'harga' => $master_produk->harga_beli,
                        'keterangan' => $keterangan,
                        'seller_id' => auth()->user()->id,
                    ]);
                }
            }

            //produk-subkategori
            $urutan_kategori = QueryLibraries::data_urutan_subkategori_by_id($request->master_subkategori_id);
            $array_subkategori_id = [];
            foreach($urutan_kategori as $item){
                MasterProdukSubkategori::updateOrCreate(['master_produk_id' => $master_produk->id, 'master_subkategori_id' => $item['id']],[
                    'master_produk_id' => $master_produk->id,
                    'master_subkategori_id' => $item['id'],
                ]);
                $array_subkategori_id[] = $item['id'];
            }
            MasterProdukSubkategori::where('master_produk_id', $master_produk->id)->whereNotIn('master_subkategori_id', $array_subkategori_id)->delete();

			DB::commit();

            return [
                'status' => 201, // SUCCESS
                'link' => '/admin/produk/produk/',
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

    public function store_image(request $request){

        $path = 'berkas/master-produk/';
        $file = $request->file('file');
        $name = md5(time()."_".$file->getClientOriginalName()).".".$file->getClientOriginalExtension();
        $file->move($path, $name);

        // $file = $request->file('file');
        // $name_image = md5(time()."_".$file->getClientOriginalName()).".".$file->getClientOriginalExtension();

        // $img = Image::make($file);
        // $img->resize(500, null, function ($constraint) {
        //     $constraint->aspectRatio();
        // });

        //detach method is the key! Hours to find it... :/
        // $resource = $img->stream()->detach();
        // Storage::disk('s3')->put('master-produk/' . $name_image, $resource);

        return response()->json([
            'name'          => $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    public function action_selected(request $request){
        // return $request;
        $array_validation = [
            'tipe' => 'required',
            'array' => 'required',
            'array.*' => 'required',
        ];

        $validator = Validator::make($request->all(), $array_validation);

		if($validator->fails()) {
            return [
                'status' => 300,
				'message' => $validator->errors()->first()
			];
		}

        if($request->tipe == 'unpublish'){
            MasterProduk::whereIn('id', $request->array)->update(['is_publish' => 0]);
        }elseif($request->tipe == 'publish'){

            $master_produk = MasterProduk::whereIn('id', $request->array)->where('url_image', '')->first();
            if(!empty($master_produk)){
                return [
                    'status' => 300,
                    'message' => 'Produk yang dipublish harus mempunyai foto'
                ];
            }

            MasterProduk::whereIn('id', $request->array)->update(['is_publish' => 1]);
        }elseif($request->tipe == 'hapus'){
            MasterProduk::whereIn('id', $request->array)->delete();
        }

        return [
            'status' => 200,
            'message' => 'Data berhasil diupdate'
        ];
    }

    public function clone($id){
        $data['title'] = 'Clone produk';
        $data['type'] = 'clone';
        $data['master_produk'] = MasterProduk::with('master_subkategori')->find($id);
        $data['master_produk_harga_grosir_b2c'] = MasterProdukHargaGrosir::where(['master_produk_id' => $id, 'tipe' => 'b2c'])->orderBy('id','asc')->get();

        $color = ['danger', 'warning', 'info', 'primary', 'success'];
        $master_produk_subkategori = MasterProdukSubkategori::with('master_subkategori')->where('master_produk_id', $id)->oldest()->get();
        $array = [];
        foreach($master_produk_subkategori as $key => $item){
            $array[] = '<span class="badge badge-'.$color[$key].'"> '.$item->master_subkategori->subkategori.'</span>';
        }

        $data['subkategori_produk'] = $array;

        return view('admin.produk.produk.add', $data);
    }

    public function delete($id){
        $delete = MasterProduk::find($id);

        if($delete <> ""){
            foreach($delete['url_image'] as $d){
                Storage::delete("public/berkas/master-produk/" . $d);
            }
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

    public function import_excel(Request $request){

		if($request->hasFile('file_excel')){

			$data = Excel::toCollection(new CsvDataImport,request()->file('file_excel'))[0];
			if($data->count()){

				foreach ($data as $key => $value) {

					if(empty($value['nama_produk'])){
						return [
							'status'     => 300, // GAGAL
							'message'    => 'Upload Data Master Produk Gagal, ditemukan NAMA PRODUK yang tidak diisi dalam file yang diupload'
						];
					}

                    if(empty($value['kategori'])){
						return [
							'status'     => 300, // GAGAL
							'message'    => 'Upload Data Master Produk Gagal, ditemukan KATEGORI yang tidak diisi dalam file yang diupload'
						];
					}

                    if(empty($value['subkategori'])){
						return [
							'status'     => 300, // GAGAL
							'message'    => 'Upload Data Master Produk Gagal, ditemukan SUBKATEGORI yang tidak diisi dalam file yang diupload'
						];
					}

                    if($value['is_publish'] === null){
						return [
							'status'     => 300, // GAGAL
							'message'    => 'Upload Data Master Produk Gagal, ditemukan IS PUBLISH yang tidak diisi dalam file yang diupload'
						];
					}

                    if($value['ready_stock'] === null){
						return [
							'status'     => 300, // GAGAL
							'message'    => 'Upload Data Master Produk Gagal, ditemukan READY STOCK yang tidak diisi dalam file yang diupload'
						];
					}

                    if($value['ready_stock'] != 1 && $value['ready_stock'] != 0){
                        return [
							'status'     => 300, // GAGAL
							'message'    => 'Upload Data Master Produk Gagal, format READY STOCK hanya bernilai 0 atau 1'
						];
                    }

                    if($value['is_publish'] != 1 && $value['is_publish'] != 0){
                        return [
							'status'     => 300, // GAGAL
							'message'    => 'Upload Data Master Produk Gagal, format IS PUBLISH hanya bernilai 0 atau 1'
						];
                    }

					$cek_master_kategori = MasterKategori::where('kategori', strtoupper($value['kategori']))->first();
					if(empty($cek_master_kategori)) {
						return [
							'status'     => 300, // GAGAL
							'message'    => 'Upload Data Master Produk Gagal, Kategori '.strtoupper($value['kategori']).' tidak ditemukan didalam sistem'
						];
					}

					$cek_master_subkategori =  MasterSubkategori::where(['master_kategori_id' => $cek_master_kategori->id,'subkategori' => $value['subkategori']])->first();
					if(empty($cek_master_subkategori)) {
						return [
							'status'     => 300, // GAGAL
							'message'    => 'Upload Data Master Produk Gagal, Kategori '.strtoupper($cek_master_kategori->kategori).' Subkategori '.strtoupper($value['subkategori']).' tidak ditemukan didalam sistem'
						];
					}

                    $array_harga_grosir = [];
                    if(!empty($value['harga_grosir'])){
                        $explode_harga_grosir = explode(";",$value['harga_grosir']);
                        foreach($explode_harga_grosir as $item){
                            if(!empty($item)){
                                $explode_detail = explode("_",$item);
                                $array_harga_grosir[] = [
                                    'tipe' => $explode_detail[0],
                                    'minimal_pembelian' => $explode_detail[1],
                                    'harga' => $explode_detail[2],
                                ];
                            }
                        }
                    }

                    $array_properties = [];
                    if(!empty($value['properties'])){
                        $explode_harga_properties = explode(";",$value['properties']);
                        foreach($explode_harga_properties as $item){
                            if(!empty($item)){
                                $explode_detail = explode("_",$item);
                                $cek_properties = MasterProperties::where(['master_kategori_id' => $cek_master_kategori->id, 'properties' => strtoupper($explode_detail[0])])->first();
                                if(empty($cek_properties)) {
                                    return [
                                        'status'     => 300, // GAGAL
                                        'message'    => 'Upload Data Master Produk Gagal, Properties tidak match atau Properties '.strtoupper($explode_detail[0]).' tidak ditemukan didalam sistem'
                                    ];
                                }

                                $array_properties[] = [
                                    'master_properties_id' => $cek_properties->id,
                                    'value' => $explode_detail[1],
                                ];
                            }
                        }
                    }

                    $arr[] = array(
						'nama_produk' => $value['nama_produk'],
                        'master_kategori' => $value['kategori'],
                        'master_kategori_id' => $cek_master_kategori->id,
                        'master_subkategori' => $value['subkategori'],
                        'master_subkategori_id' => $cek_master_subkategori->id,
                        'kata_kunci'  => $value['kata_kunci'],
                        'url_video' => $value['url_video'],
                        'satuan' => $value['satuan'],
                        'sku' => $value['sku'],
                        'minimal_order' => $value['minimal_order'],
                        'diskon' => $value['diskon'],
                        'berat' => $value['berat'],
                        'harga_beli' => $value['harga_beli'],
                        'harga_jual_b2c' => $value['harga_jual_b2c'],
                        'harga_jual_b2b' => $value['harga_jual_b2b'],
                        'stock' => $value['stock'],
                        'is_publish' => $value['is_publish'],
                        'ready_stock' => $value['ready_stock'],
                        'harga_grosir' => $array_harga_grosir,
                        'properties' => $array_properties,
					);
				}

				DB::beginTransaction();

				try {
					foreach ($arr as $item) {
                        $master_produk = MasterProduk::updateOrCreate([
                            'sku' => $item['sku']
                        ],[
                            'master_kategori_id' => $item['master_kategori_id'],
                            'master_subkategori_id' => $item['master_subkategori_id'],
                            'kata_kunci' => $item['kata_kunci'],
                            'nama_produk' => $item['nama_produk'],
                            'nama_produk_slug' => Str::slug($item['nama_produk'], '-') . Str::uuid()->toString(),
                            'url_video' => $item['url_video'],
                            'satuan' => $item['satuan'],
                            'sku' => $item['sku'],
                            'minimal_order' => $item['minimal_order'],
                            'diskon' => $item['diskon'],
                            'berat' => $item['berat'],
                            'harga_beli' => $item['harga_beli'],
                            'harga_jual_b2c' => $item['harga_jual_b2c'],
                            'harga_jual_b2b' => $item['harga_jual_b2b'],
                            'stock' => $item['stock'],
                            'is_ready_stock' => $item['ready_stock'],
                            'is_publish' => $item['is_publish'],
                        ]);

                        //produk-subkategori
                        $urutan_kategori = QueryLibraries::data_urutan_subkategori_by_id($item['master_subkategori_id']);
                        $array_subkategori_id = [];
                        foreach($urutan_kategori as $kategori){
                            MasterProdukSubkategori::updateOrCreate(['master_produk_id' => $master_produk->id, 'master_subkategori_id' => $kategori['id']],[
                                'master_produk_id' => $master_produk->id,
                                'master_subkategori_id' => $kategori['id'],
                            ]);
                            $array_subkategori_id[] = $kategori['id'];
                        }
                        MasterProdukSubkategori::where('master_produk_id', $master_produk->id)->whereNotIn('master_subkategori_id', $array_subkategori_id)->delete();
                        //harga-grosir
                        if(isset($item['harga_grosir'])){
                            foreach($item['harga_grosir'] as $item2){
                                MasterProdukHargaGrosir::updateOrCreate([
                                    'master_produk_id' => $master_produk->id,
                                    'tipe' => strtoupper($item2['tipe']),
                                    'minimal_pembelian' => $item2['minimal_pembelian'],
                                    'harga' => $item2['harga'],
                                ],[
                                    'master_produk_id' => $master_produk->id,
                                    'tipe' => strtoupper($item2['tipe']),
                                    'minimal_pembelian' => $item2['minimal_pembelian'],
                                    'harga' => $item2['harga'],
                                ]);
                            }
                        }

                        if(isset($item['harga_grosir'])){
                            foreach($item['properties'] as $item3){
                                MasterProdukProperties::updateOrCreate([
                                    'master_produk_id' => $master_produk->id,
                                    'master_properties_id' => $item3['master_properties_id'],
                                    'value' => $item3['value'],
                                ],[
                                    'master_produk_id' => $master_produk->id,
                                    'master_properties_id' => $item3['master_properties_id'],
                                    'value' => $item3['value'],
                                ]);
                            }
                        }
					}

					DB::commit();

					return [
						'status' => 200, // SUCCESS AND LOAD CONTENT
						'message' => 'Data Master Produk berhasil diimport'
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

    public function export_excel(){
        $data['data'] = MasterProduk::with('master_produk_harga_grosir','master_produk_properties.master_properties','master_kategori','master_subkategori')->get();
        return view('excel.master-produk-excel', $data);
    }
}
