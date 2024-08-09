<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Blameable;

class PembayaranProduk extends Model
{
    use HasFactory, Blameable, SoftDeletes;

    protected $table = 'pembayaran_produk';
    protected $guarded = ['id'];

    public function pembelian_produk(){
        return $this->belongsTo(PembelianProduk::class);
    }

    public function getCreatedAtAttribute(){
        return \Carbon\Carbon::parse($this->attributes['created_at'])->isoFormat('D MMMM Y');
    }
}
