<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Blameable;

class MasterSubkategori extends Model
{
    use HasFactory, Blameable, SoftDeletes;

    protected $table = 'master_subkategori';
    protected $guarded = ['id'];

    public function master_kategori(){
        return $this->belongsTo(MasterKategori::class)->withTrashed();
    }

    public function parent(){
        return $this->belongsTo(MasterSubkategori::class, 'parent_id')->withTrashed();
    }
}
