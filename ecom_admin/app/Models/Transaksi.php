<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Blameable;
use \Carbon\Carbon;

class Transaksi extends Model
{
    use HasFactory, Blameable, SoftDeletes, LogsActivity;

    protected $table = 'transaksi';
    protected $guarded = ['id'];
    protected $appends = ['status_desc', 'color', 'created_at_desc'];

    public const BELUM_BAYAR = 0;
    public const KONFIRMASI_ADMIN = 1;
    public const DIKEMAS = 2;
    public const DIKIRIM = 3;
    public const SELESAI = 4;
    public const CANCEL = 5;

    public function getStatusDescAttribute(){
        if($this->attributes['status'] == '0') return 'Belum Bayar';
        if($this->attributes['status'] == '1') return 'Konfirmasi Admin';
        if($this->attributes['status'] == '2') return 'Dikemas';
        if($this->attributes['status'] == '3') return 'Dikirim';
        if($this->attributes['status'] == '4') return 'Selesai';
        if($this->attributes['status'] == '5') return 'Cancel';
    }

    public function getColorAttribute(){
        if($this->attributes['status'] == '0') return 'warning';
        if($this->attributes['status'] == '1') return 'secondary';
        if($this->attributes['status'] == '2') return 'info';
        if($this->attributes['status'] == '3') return 'primary';
        if($this->attributes['status'] == '4') return 'success';
        if($this->attributes['status'] == '5') return 'danger';
    }

    public function getCreatedAtDescAttribute(){
        return Carbon::parse($this->attributes['created_at'])->isoFormat('D MMMM Y');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function alamat_pengiriman(){
        return $this->belongsTo(AlamatPengiriman::class)->withTrashed();
    }

    public function kode_voucher_id(){
        return $this->belongsTo(KodeVoucher::class, 'kode_voucher', 'kode_voucher')->withTrashed();
    }

    public function transaksi_produk(){
        return $this->hasMany(TransaksiProduk::class)->withTrashed();
    }
}
