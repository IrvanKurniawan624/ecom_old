<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Helpers\Convert;

use DB;
use Carbon\Carbon;

use App\Models\Notification;
use App\Models\MasterPoin;
use App\Models\PoinLog;
use App\Models\User;

class CronPoin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'poin:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menambahkan poin dari Master Poin';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //EXECUTE
        DB::beginTransaction();

		try{

            $master_poin = MasterPoin::find(1);
            if($master_poin->status == '1'){
                $user = User::active()->customerAll()->where('tanggal_lahir','like', '%' . Carbon::now()->format('m-d'))->whereNotNull('tanggal_lahir')->get();
                foreach($user as $item){
                    $total_poin = $item->poin + $master_poin->poin;
                    User::where('id', $item->id)->update([
                        'poin' => $total_poin,
                    ]);

                    PoinLog::create([
                        'user_id' => $item->id,
                        'status' => '+',
                        'nominal' => $master_poin->poin,
                        'sisa_poin' => $total_poin,
                        'keterangan' => 'penambahan poin bonus ' . $master_poin->title,
                    ]);

                    Notification::create([
                        'user_id' => $item->id,
                        'judul' => 'Selamat! Anda mendapatkan bonus poin',
                        'pengumuman' => 'Selamat anda mendapatkan bonus ' . $master_poin->title . ' sejumlah ' . number_format($master_poin->poin,0,',','.') . ' poin',
                        'notification_type' => 'bonus_poin',
                    ]);

                    //KIRIM PERSEORANGAN
                    Http::post(env('URL_WA_SERVER').'/chats/send?id=notifications', [
                    	'receiver' =>  Convert::convert_telepon_to_whatsapp($item->no_telepon),
                    	'message'  => [ 'text' => 'Selamat anda mendapatkan bonus ' . $master_poin->title . ' sejumlah ' . number_format($master_poin->poin,0,',','.') . ' poin :) silahkan cek aplikasi SIMANHURAOnline anda' ]
                    ]);
                }
            }

            $master_poin = MasterPoin::whereDate('tanggal', Carbon::now())->get();
            if(count($master_poin)){
                foreach($master_poin as $poin){
                    $user = User::active()->customerAll()->get();
                    foreach($user as $item){
                        $total_poin = $item->poin + $poin->poin;
                        User::where('id', $item->id)->update([
                            'poin' => $total_poin,
                        ]);

                        PoinLog::create([
                            'user_id' => $item->id,
                            'status' => '+',
                            'nominal' => $poin->poin,
                            'sisa_poin' => $total_poin,
                            'keterangan' => 'penambahan poin bonus ' . $poin->title,
                        ]);

                        Notification::create([
                            'user_id' => $item->id,
                            'judul' => 'Selamat! Anda mendapatkan bonus poin',
                            'pengumuman' => 'Selamat anda mendapatkan bonus ' . $poin->title . ' sejumlah ' . number_format($poin->poin,0,',','.') . ' poin',
                            'notification_type' => 'bonus_poin',
                        ]);

                        //KIRIM PERSEORANGAN
                        Http::post(env('URL_WA_SERVER').'/chats/send?id=notifications', [
                            'receiver' =>  Convert::convert_telepon_to_whatsapp($item->no_telepon),
                            'message'  => [ 'text' => 'Selamat anda mendapatkan bonus ' . $poin->title . ' sejumlah ' . number_format($poin->poin,0,',','.') . ' poin :) silahkan cek aplikasi SIMANHURAOnline anda' ]
                        ]);
                    }
                }
            }
			DB::commit();
            \Log::info("Cron POIN is working fine!");
		}

		catch(\Exception $e){
			DB::rollback();
            \Log::info("Cron POIN is failed!");
		}
    }
}
