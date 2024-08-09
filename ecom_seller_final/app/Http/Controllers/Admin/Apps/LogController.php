<?php

namespace App\Http\Controllers\Admin\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Helpers\Convert;

use DB;
use DataTables;
use Carbon\Carbon;

use App\Models\MasterProdukLog;
use App\Models\PoinLog;

class LogController extends Controller
{
    public function index(){
        return view('admin.apps.log.index');
    }
    
    public function datatables(){
        $data = MasterProdukLog::with('master_produk','master_seller')->where('seller_id', auth()->user()->id)->orderBy('id','DESC')->get();
        // $data = MasterProdukLog::with('master_produk', 'created_by')->orderBy('id','DESC')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    // public function datatables_poin(){
    //     $data = PoinLog::with('user')->orderBy('id','DESC')->get();

    //     return DataTables::of($data)
    //         ->addIndexColumn()
    //         ->make(true);
    // }
}
