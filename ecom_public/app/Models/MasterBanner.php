<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Blameable;

class MasterBanner extends Model
{
    use HasFactory, Blameable, SoftDeletes;

    protected $table = 'master_banner';
    protected $guarded = ['id'];
    protected $appends = ['status_desc'];

    public function scopeActive($query){
        return $query->where(['status' => '1']);
    }


    public function getStatusDescAttribute(){
        if($this->attributes['status'] == '1'){
            return 'aktif';
        }elseif($this->attributes['status'] == '0'){
            return 'non-aktif';
        }
    }

    public function master_package(){
        return $this->belongsTo(MasterPackage::class)->withTrashed();
    }
}
