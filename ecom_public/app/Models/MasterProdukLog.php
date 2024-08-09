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

    public function master_produk(){
        return $this->belongsTo(MasterProduk::class);
    }

    public function getTanggalDescAttribute(){
        return \Carbon\Carbon::parse( $this->attributes['created_at'] )->isoFormat('D MMMM Y');
    }


}
