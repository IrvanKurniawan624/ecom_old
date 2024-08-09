<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notification';
    protected $guarded = ['id'];
    protected $appends = ['notification_alert'];

    public function scopeActive($query){
        $query->where('user_id', auth()->user()->id);
    }

    public function getNotificationAlertAttribute(){
        switch ($this->attributes['notification_type']) {
            case "menunggu_pembayaran":
                return "<b>Transaksi " .$this->transaksi->no_invoice. " berhasil digenerate</b><br>Jangan lupa lakukan pembayaran sebelum " . $this->transaksi->datetime_batas_pembayaran .  " atau transaksi anda akan dibatalkan otomatis oleh sistem";
                break;
            case "sudah_bayar":
                return "<b>Terimakasih sudah melakukan pembayaran transaksi " .$this->transaksi->no_invoice. " sejumlah " .$this->transaksi->total_harga. "</b><br>Tunggu sebentar pembayaranmu sedang kami proses ya :)";
                break;
            case "transaksi_approve":
                return "<b>Yeay! Pembayaran Transaksi " .$this->transaksi->no_invoice. " sudah kami terima</b><br>Pesananmu akan segera kami proses";
                break;
            case "transaksi_dikemas":
                return "<b>Transaksi " .$this->transaksi->no_invoice. "</b><br>Pesananmu sedang dilakukan dikemas";
                break;
            case "transaksi_dikirim":
                return "<b>Transaksi " .$this->transaksi->no_invoice. "</b><br>Pesananmu sudah diserahkan ke pihak ekspedisi";
                break;
            case "transaksi_cancel":
                return "<b>Transaksi " .$this->transaksi->no_invoice. " batal karena waktu pembayaran telah berakhir</b><br>Oops, Waktu untuk pembayaranmu sudah habis";
                break;
            case "permintaan_upgrade_pending":
                return "<b>Yeay! Pemintaan upgrade akun berhasil dibuat</b><br>Permintaanmu untuk upgrade akun sedang kami review ya";
                break;
            case "permintaan_upgrade_approve":
                return "<b>Hooray! Permintaanmu upgrade akun udah disetujui nih</b><br>Selamat akunmu telah berubah menjadi business nih yuk segera belanja untuk menikmati promo dari kami";
                break;
            case "permintaan_upgrade_reject":
                return "<b>Oops! Permintaanmu upgrade akunmu ditolak nih</b><br>Maaf permintaanmu untuk upgrade akun kami tolak";
                break;
            default:
                return "<b>Yeay! Ada pengumuman nih buat kamu</b><br>" . $this->attributes['pengumuman'];
        }
    }

    public function user(){
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function transaksi(){
        return $this->belongsTo(Transaksi::class)->withTrashed();
    }
}
