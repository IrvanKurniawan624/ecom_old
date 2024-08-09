<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Blameable;

class MasterProdukLog extends Model
{
    use HasFactory, Blameable;

    protected $table = 'master_produk_log';
    protected $guarded = ['id'];
    // protected $appends = ['created_at_format'];

    public function master_produk(){
        return $this->belongsTo(MasterProduk::class)->withTrashed();
    }

    // public function created_by(){
    //     return $this->belongsTo(User::class, 'created_by')->withTrashed();
    // }

    public function master_seller(){
        return $this->belongsTo(MasterSeller::class, 'seller_id');
    }

    public function getCreatedAtFormatAttribute(){
        return $this->attributes['created_at'];
    }

    public function getCreatedAtAttribute(){
        return \Carbon\Carbon::parse( $this->attributes['created_at'] )->isoFormat('D MMMM Y');
    }



}
