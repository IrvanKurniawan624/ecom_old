<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Blameable;

class MasterProperties extends Model
{
    use HasFactory, Blameable, SoftDeletes;

    protected $table = 'master_properties';
    protected $guarded = ['id'];

    public function master_kategori(){
        return $this->belongsTo(MasterKategori::class)->withTrashed();
    }
}
