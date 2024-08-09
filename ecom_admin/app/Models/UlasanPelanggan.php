<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Blameable;

class UlasanPelanggan extends Model
{
    use HasFactory, Blameable, SoftDeletes;

    protected $table = 'ulasan_pelanggan';
    protected $guarded = ['id'];
    protected $appends = ['status_desc'];

    public function master_produk(){
        return $this->belongsTo(MasterProduk::class)->withTrashed();
    }

    public function user(){
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function getStatusDescAttribute(){
        if($this->attributes['status'] == '1'){
            return 'diterima';
        }elseif($this->attributes['status'] == '2'){
            return 'ditolak';
        }else{
            return 'pending';
        }
    }
}
