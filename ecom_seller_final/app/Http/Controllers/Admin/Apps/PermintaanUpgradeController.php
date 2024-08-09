<?php

namespace App\Http\Controllers\Admin\Apps;

use App\Http\Controllers\Controller;
use App\Models\TipeCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use DB;
use DataTables;

use App\Mail\PermintaanUpgradeApprove;
use App\Mail\PermintaanUpgradeReject;

use App\Models\User;
use App\Models\Notification;

class PermintaanUpgradeController extends Controller
{
    public function index(){
        return view('admin.apps.permintaan-upgrade.index');
    }

    public function detail($id){
        $data['data'] = User::with('tipe_customer')->find($id);
        return view('admin.apps.permintaan-upgrade.detail', $data);
    }

    public function datatables(){
        $data = User::with('tipe_customer')->whereNotNull('status_upgrade')->latest()->get();

        return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['status_upgrade_badge'])
                    ->make(true);
    }

    public function approve(request $request){

        $user = User::find($request->id);

        if($request->type == User::STATUS_UPGRADE_APPROVE){
            $notification_type = 'permintaan_upgrade_approve';
            User::where('id', $request->id)->update([
                'status_upgrade' => $request->type,
                'tipe_customer_id' => TipeCustomer::BUSINESS,
            ]);

            $data = [
                'nama' => $user->nama,
            ];
            $email = $user->email;
            Mail::to($email)->send(new PermintaanUpgradeApprove($data));

        }else{
            $notification_type = 'permintaan_upgrade_reject';
            User::where('id', $request->id)->update([
                'status_upgrade' => $request->type,
            ]);

            $data = [
                'nama' => $user->nama,
            ];
            $email = $user->email;
            Mail::to($email)->send(new PermintaanUpgradeReject($data));
        }

        //NOTIFICATION
        Notification::create([
            'user_id' => $request->id,
            'notification_type' => $notification_type,
        ]);

        $message = 'Upgrade B2B berhasil ditolak';
        if($request->type == 1){
            $message = 'Upgrade B2B berhasil diterima';
        }

        return [
            'status' => 200,
            'message' => $message
        ];
    }
}
