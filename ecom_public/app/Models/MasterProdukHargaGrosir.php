<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Blameable;

class MasterProdukHargaGrosir extends Model
{
    use HasFactory, Blameable, SoftDeletes;

    protected $table = 'master_produk_harga_grosir';
    protected $guarded = ['id'];

    public function scopeActive($query){
        if (Auth::check()) {
            $tipe = auth()->user()->tipe_customer_id == 3 ? 'b2b' : 'b2c';
        }else{
            $tipe = 'b2c';
        }

        return $query->where('tipe', $tipe);
    }

    public function master_produk(){
        return $this->belongsTo(MasterProduk::class)->withTrashed();
    }
}
