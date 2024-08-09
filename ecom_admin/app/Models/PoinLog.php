<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Blameable;

class PoinLog extends Model
{
    use HasFactory, LogsActivity, Blameable;

    protected static $logAttributes = ["*"];

    protected $table = 'poin_log';
    protected $guarded = ['id'];
    protected $appends = ['history_poin','status_desc','created_at_desc'];

    public function getStatusDescAttribute(){
        return $this->attributes['status'] == '+' ? 'Penambahan' : 'Pengurangan';
    }

    public function getHistoryPoinAttribute(){
        $tipe = $this->attributes['status'] == '+' ? 'Penambahan' : 'Pengurangan';
        if($this->attributes['transaksi_id'] != null && $this->attributes['keterangan'] == ''){
            return $tipe . ' sejumlah ' . number_format($this->attributes['nominal'],0,',','.') . ' dari transaksi ' . $this->transaksi->no_invoice;
        }elseif($this->attributes['transaksi_id'] != null && $this->attributes['keterangan'] != ''){
            return $this->attributes['keterangan'] . ' sejumlah ' . number_format($this->attributes['nominal'],0,',','.') . ' dari transaksi ' . $this->transaksi->no_invoice;
        }else{
            return $this->attributes['keterangan'] . ' sejumlah ' . number_format($this->attributes['nominal'],0,',','.');
        }
    }

    public function getCreatedAtDescAttribute(){
        return \Carbon\Carbon::parse($this->attributes['created_at'])->isoFormat('D MMMM Y');
    }

    public function user(){
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function transaksi(){
        return $this->belongsTo(Transaksi::class)->withTrashed();
    }

    public function created_by(){
        return $this->belongsTo(User::class, 'created_by')->withTrashed();
    }
}
