<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Blameable;

class MasterProdukProperties extends Model
{
    use HasFactory, Blameable, SoftDeletes;

    protected $table = 'master_produk_properties';
    protected $guarded = ['id'];

    public function master_produk(){
        return $this->belongsTo(MasterProduk::class)->withTrashed();
    }

    public function master_properties(){
        return $this->belongsTo(MasterProperties::class)->withTrashed();
    }
}
