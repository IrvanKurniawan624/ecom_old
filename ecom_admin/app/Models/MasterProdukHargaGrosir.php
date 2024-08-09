<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Blameable;

class MasterProdukHargaGrosir extends Model
{
    use HasFactory, Blameable;

    protected $table = 'master_produk_harga_grosir';
    protected $guarded = ['id'];

    public function master_produk(){
        return $this->belongsTo(MasterProduk::class)->withTrashed();
    }
}
