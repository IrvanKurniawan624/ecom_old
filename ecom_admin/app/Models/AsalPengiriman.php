<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Blameable;

class AsalPengiriman extends Model
{
    use HasFactory, Blameable, SoftDeletes;

    protected $table = 'asal_pengiriman';
    protected $guarded = ['id'];

    public function master_seller(){
        return $this->belongsTo(MasterSeller::class, 'seller_id');
    }
}
