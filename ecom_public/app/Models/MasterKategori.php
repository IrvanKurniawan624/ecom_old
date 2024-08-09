<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Blameable;

class MasterKategori extends Model
{
    use HasFactory, Blameable, SoftDeletes;

    protected $table = 'master_kategori';
    protected $guarded = ['id'];
    protected $appends = ['total_produk'];

    public function getTotalProdukAttribute(){
        return MasterProduk::has('master_kategori')->where(['master_kategori_id' => $this->attributes['id'], 'is_publish' => '1'])->count();
    }

    public function master_package(){
        return $this->belongsTo(MasterPackage::class)->withTrashed();
    }
}
