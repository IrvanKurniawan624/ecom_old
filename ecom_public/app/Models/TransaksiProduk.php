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

    public const PENDING = 0;
    public const AKTIF = 1;
    public const NONAKTIF = 2;

    protected $table = 'transaksi_produk';
    protected $guarded = ['id'];

    public function transaksi(){
        return $this->belongsTo(Transaksi::class)->withTrashed();
    }

    public function master_produk(){
        return $this->belongsTo(MasterProduk::class)->withTrashed();
    }
}
