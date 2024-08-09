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

    public function master_package(){
        return $this->belongsTo(MasterPackage::class)->withTrashed();
    }
}
