<?php

namespace App\Libraries;

use DB;
use Carbon\Carbon;

use App\Models\MasterSubkategori;

class QueryLibraries{

    public static function data_urutan_subkategori_by_id($subkategori_id){
        $array = [];
        $subkategori_first = MasterSubkategori::find($subkategori_id);
        $subkategori = MasterSubkategori::where('level', '<', $subkategori_first->level)->where('master_kategori_id', $subkategori_first->master_kategori_id)->get();

        $temp_parent = $subkategori_id;
        if($subkategori_first->level == '1'){
            $array[] = [
                'id' => $subkategori_first->id,
                'subkategori' => $subkategori_first->subkategori,
            ];
        }else{
            for($i = 1; $i <= $subkategori_first->level; $i++){
                $master_subkategori = MasterSubkategori::find($temp_parent);
                $temp_parent = $master_subkategori->parent_id;

                $array[] = [
                    'id' => $master_subkategori->id,
                    'subkategori' => $master_subkategori->subkategori,
                ];
            }
        }


        return array_reverse($array);
    }

}
