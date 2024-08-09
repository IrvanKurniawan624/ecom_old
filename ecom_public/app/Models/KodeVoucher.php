<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Blameable;

class KodeVoucher extends Model
{
    use HasFactory, Blameable, SoftDeletes;

    protected $table = 'kode_voucher';
    protected $guarded = ['id'];
    protected $appends = ['deskripsi_bonus','total_penggunaan'];

    public function getTotalPenggunaanAttribute(){
        return Transaksi::where(['user_id' => auth()->user()->id, 'kode_voucher' => $this->attributes['kode_voucher']])->where('status','!=','5')->count();
    }

    public function getDeskripsiBonusAttribute(){
        if($this->attributes['tipe'] == 'persen'){
            return 'Cashback ' . $this->attributes['persen_presentase_potongan'] . '% maksimal potongan ' . number_format($this->attributes['persen_maksimal_potongan'],0,',','.');
        }else{
            return 'Bonus Barang ' . MasterProduk::withTrashed()->where('id', $this->master_produk_id_bonus)->first()->nama_produk . " sejumlah " . $this->attributes['jumlah_produk_bonus'] . ' item';
        }
    }

    public function scopeActive($query){
        return $query->where(function($q){
            $q->where('user_id', auth()->user()->id)->orWhereNull('user_id');
        })->where('tanggal_mulai','<=', date('Y-m-d'))->where('tanggal_selesai','>=', date('Y-m-d'))->where(['status' => '1', 'is_claim' => '0']);
    }

    public function scopeMustClaim($query){
        return $query->where(function($q){
            $q->where('user_id', auth()->user()->id)->orWhereNull('user_id');
        })->where('tanggal_mulai','<=', date('Y-m-d'))->where('tanggal_selesai','>=', date('Y-m-d'))->where(['status' => '1', 'is_claim' => '1']);
    }

    public function master_package(){
        return $this->belongsTo(MasterPackage::class)->withTrashed();
    }

    public function user(){
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function master_produk_id_beli(){
        return $this->belongsTo(MasterProduk::class, 'master_produk_id_beli')->withTrashed();
    }

    public function master_produk_id_bonus(){
        return $this->belongsTo(MasterProduk::class, 'master_produk_id_bonus')->withTrashed();
    }

    public function kode_voucher_user(){
        return $this->hasMany(KodeVoucherUser::class)->withTrashed();
    }

    public function transaksi(){
        return $this->hasMany(Transaksi::class,'kode_voucher','kode_voucher')->withTrashed();
    }
}
