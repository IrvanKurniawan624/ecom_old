<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Blameable;

class MasterProdukSubkategori extends Model
{
    use HasFactory, Blameable, SoftDeletes;

    protected $table = 'master_produk_subkategori';
    protected $guarded = ['id'];

    public function master_produk(){
        return $this->belongsTo(MasterProduk::class)->withTrashed();
    }

    public function master_subkategori(){
        return $this->belongsTo(MasterSubkategori::class)->withTrashed();
    }
}
