<?php

namespace App\Http\Controllers\Ecom\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use DB;
use DataTables;
use Carbon\Carbon;

use App\Models\Notification;

class NotifikasiController extends Controller
{
    public function index(){

        Notification::where(['user_id' => auth()->user()->id, 'is_new' => '1'])->update(['is_new' => 0]);

        $data['data'] = Notification::where('user_id', auth()->user()->id)->latest()->get();

        return view('ecom.profile.profile-notifikasi', $data);
    }
}
