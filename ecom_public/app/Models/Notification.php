<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Carbon\Carbon;

class Notification extends Model
{
    use HasFactory;

    // public static function boot()
    // {
    //     parent::boot();

    //     self::created(function($model){
    //         dd($model);
    //     });
    // }

    protected $table = 'notification';
    protected $guarded = ['id'];
    protected $appends = ['notification_alert', 'notification_alert_full'];

    public function scopeActive($query){
        $query->where('user_id', auth()->user()->id);
    }

    public function getNotificationAlertFullAttribute(){
        switch ($this->attributes['notification_type']) {
            case "menunggu_pembayaran":
                return "<b style=\"margin-bottom: 15px\">Transaksi " .$this->transaksi->no_invoice. " berhasil digenerate</b><br>Jangan lupa lakukan pembayaran sebelum " . Carbon::parse($this->transaksi->datetime_batas_pembayaran)->isoFormat('dddd, D MMM Y HH:mm:ss') .  " atau transaksi anda akan dibatalkan otomatis oleh sistem";
                break;
            case "sudah_bayar":
                return "<b style=\"margin-bottom: 15px\">Terimakasih sudah melakukan pembayaran transaksi " .$this->transaksi->no_invoice. " sejumlah " .number_format($this->transaksi->total_harga,0,',','.'). "</b><br>Tunggu sebentar pembayaranmu sedang kami proses ya :)";
                break;
            case "transaksi_approve":
                return "<b style=\"margin-bottom: 15px\">Yeay! Pembayaran Transaksi " .$this->transaksi->no_invoice. " sudah kami terima</b><br>Pesananmu akan segera kami proses";
                break;
            case "transaksi_dikemas":
                return "<b style=\"margin-bottom: 15px\">Transaksi " .$this->transaksi->no_invoice. "</b><br>Pesananmu sedang dilakukan dikemas";
                break;
            case "transaksi_dikirim":
                return "<b style=\"margin-bottom: 15px\">Transaksi " .$this->transaksi->no_invoice. "</b><br>Pesananmu sudah diserahkan ke pihak ekspedisi";
                break;
            case "transaksi_cancel":
                return "<b style=\"margin-bottom: 15px\">Transaksi " .$this->transaksi->no_invoice. " batal karena waktu pembayaran telah berakhir</b><br>Oops, Waktu untuk pembayaranmu sudah habis";
                break;
            case "transaksi_selesai":
                return "<b style=\"margin-bottom: 15px\">Transaksi " .$this->transaksi->no_invoice. " telah selesai</b><br>Pesananmu sudah beres terimakasih telah berbelanja di SIMANHURA.com ditunggu orderan selanjutnya ya :)";
                break;
            case "permintaan_upgrade_pending":
                return "<b style=\"margin-bottom: 15px\">Yeay! Pemintaan upgrade akun berhasil dibuat</b><br>Permintaanmu untuk upgrade akun sedang kami review ya";
                break;
            case "permintaan_upgrade_approve":
                return "<b style=\"margin-bottom: 15px\">Hooray! Permintaanmu upgrade akun udah disetujui nih</b><br>Selamat akunmu telah berubah menjadi business nih yuk segera belanja untuk menikmati promo dari kami";
                break;
            case "permintaan_upgrade_reject":
                return "<b style=\"margin-bottom: 15px\">Oops! Permintaanmu upgrade akunmu ditolak nih</b><br>Maaf permintaanmu untuk upgrade akun kami tolak";
                break;
            default:
                return "<b style=\"margin-bottom: 15px\">" . $this->attributes['judul'] . "</b><br>" . $this->attributes['pengumuman'];
        }
    }

    public function getNotificationAlertAttribute(){
        switch ($this->attributes['notification_type']) {
            case "menunggu_pembayaran":
                return "Transaksi " .$this->transaksi->no_invoice. " berhasil digenerate";
                break;
            case "sudah_bayar":
                return "Terimakasih sudah melakukan pembayaran transaksi " .$this->transaksi->no_invoice. " sejumlah " .number_format($this->transaksi->total_harga,0,',','.'). "";
                break;
            case "transaksi_approve":
                return "Yeay! Pembayaran Transaksi " .$this->transaksi->no_invoice. " sudah kami terima";
                break;
            case "transaksi_dikemas":
                return "Transaksi " .$this->transaksi->no_invoice. " sedang dikemas";
                break;
            case "transaksi_dikirim":
                return "Transaksi " .$this->transaksi->no_invoice. " sedang dikirim";
                break;
            case "transaksi_cancel":
                return "Transaksi " .$this->transaksi->no_invoice. " batal karena waktu pembayaran telah berakhir";
                break;
            case "transaksi_selesai":
                return "Transaksi " .$this->transaksi->no_invoice. " telah selesai";
                break;
            case "permintaan_upgrade_pending":
                return "Yeay! Pemintaan upgrade akun berhasil dibuat";
                break;
            case "permintaan_upgrade_approve":
                return "Hooray! Permintaanmu upgrade akun udah disetujui nih";
                break;
            case "permintaan_upgrade_reject":
                return "Oops! Permintaanmu upgrade akunmu ditolak nih";
                break;
            default:
                return $this->attributes['judul'];
        }
    }

    public function user(){
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function transaksi(){
        return $this->belongsTo(Transaksi::class)->withTrashed();
    }
}
