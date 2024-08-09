<?php

namespace App\Http\Controllers\Ecom;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use DB;
use DataTables;
use Carbon\Carbon;

use App\Models\MasterPackage;
use App\Models\MasterBanner;

class BannerController extends Controller
{
    public function index(){

    }

    public function detail($title_slug){
        $data['banner'] = MasterBanner::where('title_slug', $title_slug)->first();
        return view('ecom.banner-detail', $data);
    }
}
