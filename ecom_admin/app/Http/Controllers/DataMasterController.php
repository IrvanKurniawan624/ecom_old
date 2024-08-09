<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

use DataTables;
use Carbon\Carbon;
use DB;

use App\Models\PembelianProduk;
use App\Models\Transaksi;
use App\Models\MasterSubkategori;
use App\Models\MasterProperties;
use App\Models\MasterProduk;
use App\Models\User;

use App\Helpers\ApiFormatter;
use App\Libraries\QueryLibraries;
use App\Models\MarketplaceTransaksiProduk;

class DataMasterCOntroller extends Controller
{
    public function get_data_all($model){

        $model = 'App\\Models\\' . $model;
        $data = $model::all();

        return ApiFormatter::getResponse($data);
    }

    public function get_data_all_active($model){

        $model = 'App\\Models\\' . $model;
        $data = $model::active()->get();

        return ApiFormatter::getResponse($data);
    }

    public function get_data_by_id($model, $id){

        $model = 'App\\Models\\' . $model;
        $data = $model::find($id);

        return ApiFormatter::getResponse($data);
    }

    public function get_data_where_field_id_get($model, $where_field, $id){

        $model = 'App\\Models\\' . $model;
        $data = $model::where($where_field, $id)->get();

        return ApiFormatter::getResponse($data);
    }

    public function get_data_where_field_id_first($model, $where_field, $id){

        $model = 'App\\Models\\' . $model;
        $data = $model::where($where_field, $id)->first();

        return ApiFormatter::getResponse($data);
    }
    #================ DATA =====================#

    public function data_master_produk_active(){
        $data = MasterProduk::active()->get();

        return ApiFormatter::getResponse($data);
    }

    public function data_master_produk_active_by_master_package($master_package_id){
        $data = MasterProduk::active()->whereHas('master_kategori', function($q) use ($master_package_id){
            $q->where('master_package_id', $master_package_id);
        })->get();

        return ApiFormatter::getResponse($data);
    }

    public function data_user_customer_all(){
        $data = User::customerAll()->get();

        return ApiFormatter::getResponse($data);
    }

    public function data_urutan_subkategori_by_id($subkategori_id){
       return QueryLibraries::data_urutan_subkategori_by_id($subkategori_id);
    }

    public function data_master_properties_by_kategori($master_kategori_id){
        $data = MasterProperties::where('master_kategori_id', $master_kategori_id)->get();

        return ApiFormatter::getResponse($data);
    }

    public function data_statistik_pesanan_dashboard($tipe){
        if($tipe == 'bulanan'){
            $transaksi = Transaksi::whereMonth('updated_at', Carbon::now()->format('m'))->whereNotIn('status', [Transaksi::BELUM_BAYAR, Transaksi::CANCEL])->get();
        }else{
            $transaksi = Transaksi::whereYear('updated_at', Carbon::now()->format('Y'))->whereNotIn('status', [Transaksi::BELUM_BAYAR, Transaksi::CANCEL])->get();
        }

        $array['konfirmasi_admin'] = $transaksi->where('status', Transaksi::KONFIRMASI_ADMIN)->count();
        $array['dikemas'] = $transaksi->where('status', Transaksi::DIKEMAS)->count();
        $array['dikirim'] = $transaksi->where('status', Transaksi::DIKIRIM)->count();
        $array['selesai'] = $transaksi->where('status', Transaksi::SELESAI)->count();
        $array['total_pesanan'] = $transaksi->count();

        return $array;
    }


    #================ API RAJA ONKIR ===============#

    public function api_get_province(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://pro.rajaongkir.com/api/province",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "key:7021b582cede2d3c37dbe64f18d6c29b"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return [
                'status' => 300,
                'message' => $err,
            ];
        }

        $response = json_decode($response, true);
        $response = collect($response['rajaongkir']['results']);

        return ApiFormatter::getResponse($response);
    }

    public function api_get_city_by_province($province_id){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://pro.rajaongkir.com/api/city?province=" . $province_id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "key:7021b582cede2d3c37dbe64f18d6c29b"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        if ($err) {
            return [
                'status' => 300,
                'message' => $err,
            ];
        }

        $response = json_decode($response, true);
        $response = collect($response['rajaongkir']['results']);

        return ApiFormatter::getResponse($response);
    }
    

    #================ DATATABLES ===============#

    public function datatables_subkategori_by_kategori($master_kategori_id){
        $data = MasterSubkategori::where('master_kategori_id', $master_kategori_id)->with('master_kategori','parent')->orderBy('master_kategori_id','ASC')->orderBy('parent_id','ASC')->orderBy('level','ASC')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('parent_desc',function($item) {
                return $item->parent->subkategori ?? 'HEAD';
            })
            ->make(true);
    }

    public function datatable_master_produk(){
        $data = MasterProduk::with('master_kategori', 'master_subkategori')->orderBy('master_kategori_id')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatable_master_produk_active(){
        $data = MasterProduk::with('master_kategori', 'master_subkategori')->active()->orderBy('master_kategori_id')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_marketplace_transaksi_produk_by_transaksi($id){
        $data = MarketplaceTransaksiProduk::with('marketplace_transaksi', 'master_produk')->where('id', $id)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_pembelian_produk_hutang_belum_lunas(){
        $data = PembelianProduk::with('master_supplier')->where(['is_cash' => PembelianProduk::IS_HUTANG, 'status' => PembelianProduk::BELUM_LUNAS])->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

}
