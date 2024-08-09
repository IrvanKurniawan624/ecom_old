<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Blameable;
use \Carbon\Carbon;

class MarketplaceTransaksi extends Model
{
    use HasFactory, Blameable, SoftDeletes;

    protected $table = 'marketplace_transaksi';
    protected $guarded = ['id'];
    protected $appends = ['status_desc'];

    public function getStatusDescAttribute(){
        if($this->attributes['status'] == 0){
            return 'pending';
        }elseif($this->attributes['status'] == 1){
            return 'approved';
        }else{
            return 'not approved';
        }
    }

    public function marketplace_transaksi_produk(){
        return $this->hasMany(MarketplaceTransaksiProduk::class)->withTrashed();
    }
}
