<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class MasterSeller extends Authenticatable
{
    use HasFactory;
    protected $table = 'master_seller';
    protected $guarded = ['id'];

    public function master_produk(){
        return $this->hasMany(MasterProduk::class)->withTrashed();
    }

    public function master_produk_log(){
        return $this->hasMany(MasterProdukLog::class, 'seller_id');
    }
}
