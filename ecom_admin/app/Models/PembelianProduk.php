<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Blameable;
use \Carbon\Carbon;

class PembelianProduk extends Model
{
    use HasFactory, Blameable, SoftDeletes;

    protected $table = 'pembelian_produk';
    protected $guarded = ['id'];
    protected $appends = ['status_desc', 'is_cash_desc', 'total_pembelian_detail', 'sisa_pembayaran'];

    public const IS_HUTANG = 0;
    public const IS_CASH = 1;

    public const PENDING = 0;
    public const BELUM_LUNAS = 1;
    public const LUNAS = 2;

    public function getStatusDescAttribute(){
        if($this->attributes['status'] == 0){
            return 'pending';
        }elseif($this->attributes['status'] == 1){
            return 'belum lunas';
        }else{
            return 'lunas';
        }
    }

    public function getIsCashDescAttribute(){
        if($this->attributes['is_cash'] == 0){
            return 'hutang';
        }elseif($this->attributes['is_cash'] == 1){
            return 'cash';
        }
    }

    public function getSisaPembayaranAttribute(){
        $sisa_pembayaran = 0;
        if($this->attributes['is_cash'] == 0){
            $sisa_pembayaran = $this->attributes['total_pembelian'] - $this->attributes['total_pembayaran'];
        }

        return $sisa_pembayaran;
    }

    public function getTotalPembelianDetailAttribute(){
        $total = 0;
        foreach($this->pembelian_produk_detail as $item){
            if(empty($item->deleted_by)){
                $total += $item->quantity * $item->harga_beli;
            }
        }

        return $total;
    }

    public function master_supplier(){
        return $this->belongsTo(MasterSupplier::class)->withTrashed();
    }

    public function pembelian_produk_detail(){
        return $this->hasMany(PembelianProdukDetail::class)->withTrashed();
    }
}
