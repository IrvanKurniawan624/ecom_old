<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Kavist\RajaOngkir\Facades\RajaOngkir;

use DataTables;
use Carbon\Carbon;

use App\Models\MasterPackage;
use App\Models\AsalPengiriman;
use App\Models\MasterSubkategori;
use App\Models\MasterProperties;
use App\Models\MasterProduk;
use App\Models\KodeVoucher;
use App\Models\JasaPengiriman;
use App\Models\User;

use App\Helpers\ApiFormatter;
use App\Libraries\QueryLibraries;

class DataMasterCOntroller extends Controller
{
    public function get_data_all($model){

        $model = 'App\\Models\\' . $model;
        $data = $model::all();

        return ApiFormatter::getResponse($data);
    }

    public function get_data_by_id($model, $id){

        $model = 'App\\Models\\' . $model;
        $data = $model::find($id);

        return ApiFormatter::getResponse($data);
    }

    public function get_data_where_field_id($model, $where_field, $id){

        $model = 'App\\Models\\' . $model;
        $data = $model::where($where_field, $id)->first();

        return ApiFormatter::getResponse($data);
    }
    #================ DATA =====================#

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

    public function api_get_kecamatan_by_city($city_id){
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://pro.rajaongkir.com/api/subdistrict?city=' . $city_id,
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

    public function api_get_ongkos_kirim($tujuan_id, $berat, $seller_id){
        $asal_id = AsalPengiriman::where('seller_id',$seller_id)->first()->kota_id;
        $jasa_pengiriman = JasaPengiriman::active()->where('kode','!=','staff')->where('kode', '!=', 'mandiri')->get();

        $array = [];
        foreach($jasa_pengiriman as $item){
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pro.rajaongkir.com/api/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=$asal_id&originType=city&destination=$tujuan_id&destinationType=subdistrict&weight=$berat&courier=$item->kode",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key:7021b582cede2d3c37dbe64f18d6c29b"
            ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            $response = json_decode($response, true);
            $data = collect($response['rajaongkir']['results']);

            if(count($data)){
                foreach($data[0]['costs'] as $value){
                    $array[] = [
                        'nama' => "[".strtoupper($data[0]['code']) ."] ". $value['service'],
                        'harga' => $value['cost'][0]['value'],
                        'estimasi' => $value['cost'][0]['etd'],
                    ];
                }
            }
        }

        //KURIR KHARISMA
        // if($tujuan_id == '2998' || $tujuan_id == '2999' || $tujuan_id == '3000' || $tujuan_id == '3001' || $tujuan_id == '3002' || $tujuan_id == '3003'){
        //     $kurir_kharisma = JasaPengiriman::active()->where('kode', 'staff')->first();
        //     if(!empty($kurir_kharisma)){

        //         if($berat <= 2000){
        //             $harga = 10000;
        //         }else{
        //             $berat_kharisma = $berat - 2000;
        //             $berat_kharisma = round($berat_kharisma, -3);
        //             $berat_kharisma = $berat_kharisma / 1000;

        //             $harga = 10000 + ($berat_kharisma * 10000);
        //         }

        //         $array[] = [
        //             'nama' => "[STAF KHARISMA] - KHUSUS KOTA KUPANG",
        //             'harga' => $harga,
        //             'estimasi' => 1,
        //         ];
        //     }
        // }

        return ApiFormatter::getResponse($array);
    }

    public function api_get_waybill($courier, $waybill){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://pro.rajaongkir.com/api/waybill',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "waybill=$waybill&courier=$courier",
        CURLOPT_HTTPHEADER => array(
            "content-type: application/x-www-form-urlencoded",
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
        $response = collect($response['rajaongkir']['result']);

        return ApiFormatter::getResponse($response);
    }

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

    public function data_kode_voucher_claim_active_by_user_id(){
        $user_id = auth()->user()->id;

        $data_voucher = KodeVoucher::with('master_produk_id_beli', 'master_produk_id_bonus')->active()->get();

        $data_voucher_claim = KodeVoucher::with('master_produk_id_beli', 'master_produk_id_bonus')->mustClaim()->whereHas('kode_voucher_user', function($q) use ($user_id){
            $q->active();
        })->get();

        $allItems = new \Illuminate\Database\Eloquent\Collection;
        $allItems = $allItems->merge($data_voucher);
        $allItems = $allItems->merge($data_voucher_claim);

        //MENCARI VOUCHER YANG MASIH DAPAT DIGUNAKAN
        $array = [];
        foreach($allItems as $item){
            if($item->maksimal_penggunaan > $item->total_penggunaan){
                $array[] = $item;
            }
        }

        return ApiFormatter::getResponse($array);
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

}
