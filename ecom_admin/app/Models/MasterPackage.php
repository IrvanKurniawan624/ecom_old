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
    protected $dates = ['deleted_at'];

    protected $cascadeDeletes = ['master_kategori', 'master_subkategori'];

    public function master_kategori(){
        return $this->hasMany(MasterKategori::class)->withTrashed();
    }

    public function master_subkategori(){
        return $this->hasMany(MasterSubkategori::class)->withTrashed();
    }
}
