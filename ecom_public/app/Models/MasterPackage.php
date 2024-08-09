<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Blameable;

class MasterPackage extends Model
{
    use HasFactory, Blameable, SoftDeletes;

    protected $table = 'master_package';
    protected $guarded = ['id'];
    protected $appends = ['total_produk'];

    public function getTotalProdukAttribute(){
        return MasterProduk::whereHas('master_kategori',function($query){
            $query->where('master_package_id', $this->attributes['id']);
        })->where(['is_publish' => '1'])->where('stock', '>', 0)->count();
    }

    public function getPackageAttribute(){
        return ucwords(strtolower($this->attributes['package']));
    }

    public function master_produk(){
        return $this->hasMany(MasterProduk::class)->withTrashed();
    }
}
