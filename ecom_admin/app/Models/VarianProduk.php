<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Blameable;

class VarianProduk extends Model
{
    use HasFactory, Blameable, SoftDeletes;

    protected $table = 'varian_produk';
    protected $guarded = ['id'];

    public function master_produk(){
        return $this->belongsTo(MasterProduk::class)->withTrashed();
    }
}
