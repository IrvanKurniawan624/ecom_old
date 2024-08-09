<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Blameable;

class MarketplaceTransaksiProduk extends Model
{
    use HasFactory, Blameable, SoftDeletes;

    protected $table = 'marketplace_transaksi_produk';
    protected $guarded = ['id'];

    public function marketplace_transaksi(){
        return $this->belongsTo(MarketplaceTransaksi::class)->withTrashed();
    }

    public function master_produk(){
        return $this->belongsTo(MasterProduk::class)->withTrashed();
    }
}
