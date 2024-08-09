<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Blameable;

class PembelianProdukDetail extends Model
{
    use HasFactory, Blameable, SoftDeletes;

    protected $table = 'pembelian_produk_detail';
    protected $guarded = ['id'];

    public function pembelian_produk(){
        return $this->belongsTo(PembelianProduk::class);
    }

    public function master_produk(){
        return $this->belongsTo(MasterProduk::class)->withTrashed();
    }
}
