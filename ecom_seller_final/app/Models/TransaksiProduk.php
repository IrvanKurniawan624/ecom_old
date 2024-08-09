<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Blameable;

class TransaksiProduk extends Model
{
    use HasFactory, Blameable, SoftDeletes, LogsActivity;

    protected static $logAttributes = ["*"];

    protected $table = 'transaksi_produk';
    protected $guarded = ['id'];
    protected $appends = ['status_desc'];


    public const PENDING = 0;
    public const AKTIF = 1;
    public const NONAKTIF = 2;

    public function getStatusDescAttribute(){
        if($this->attributes['status'] == '1'){
            return 'diterima';
        }elseif($this->attributes['status'] == '2'){
            return 'ditolak';
        }elseif($this->attributes['status'] == '0'){
            return 'pending';
        }
    }

    public function transaksi(){
        return $this->belongsTo(Transaksi::class)->withTrashed();
    }

    public function master_seller(){
        return $this->belongsTo(MasterSeller::class);
    }

    public function master_produk(){
        return $this->belongsTo(MasterProduk::class)->withTrashed();
    }
}
