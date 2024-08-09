<?php
namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Auth;

use App\Models\MasterMenu;

class App {

    public static function get_master_menu(){
        $master_menu = MasterMenu::where('parent_id', '0')->whereIn('id', session()->get('json_menu'))->orderBy('index','asc')->get();
        $prepared_master_menu = MasterMenu::orderBy('index','asc')->whereIn('id', session()->get('json_menu'))->get();

        $array = [];
        foreach($master_menu as $key => $value){
            $array[$key]['nama'] = $value->nama_menu;
            $array[$key]['icon'] = $value->icon;
            $array[$key]['link'] = $value->link;
            $array[$key]['menu'] = $value->menu;
            
            $sub_menu = $prepared_master_menu->where('parent_id', $value->id);
            foreach($sub_menu as $value2){
                $array[$key]['submenu'][] = [
                    'nama' => $value2->nama_menu,
                    'icon' => $value2->icon,
                    'link' => $value2->link,
                    'menu' => $value2->menu,
                    'submenu' => $value2->submenu,
                ];
            }
        }

        return $array;
    }
}
?>