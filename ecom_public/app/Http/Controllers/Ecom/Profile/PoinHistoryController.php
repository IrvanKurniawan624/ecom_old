<?php

namespace App\Http\Controllers\Ecom\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;

use DB;
use DataTables;
use Carbon\Carbon;

use App\Models\User;
use App\Models\PoinLog;

class PoinHistoryController extends Controller
{
    public function index(){
        $data['user'] = User::where('id', auth()->user()->id)->first();
        $data['data'] = PoinLog::with('user')->where('user_id', auth()->user()->id)->orderBy('created_at', 'DESC')->get();
        return view('ecom.profile.profile-poin-history', $data);
    }
}
