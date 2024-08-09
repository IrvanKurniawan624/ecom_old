<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Blameable;

class MasterPoin extends Model
{
    use HasFactory, Blameable, SoftDeletes;

    protected $table = 'master_poin';
    protected $guarded = ['id'];
    protected $appends = ['tanggal_desc','status_desc'];

    public function getTanggalDescAttribute(){
        return $this->attributes['tanggal'] == null ? '-' : \Carbon\Carbon::parse( $this->attributes['tanggal'] )->isoFormat('D MMMM Y');
    }

    public function getStatusDescAttribute(){
        return $this->attributes['status'] == '1' ? 'active' : 'non-active';
    }
}
