<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Blameable;

class MasterProduk extends Model
{
    use HasFactory, Blameable, SoftDeletes, LogsActivity;
    

    protected $table = 'master_produk';
    protected $guarded = ['id'];
    protected $appends = ['is_publish_desc', 'harga_jual', 'nama_produk_desc', 'bintang', 'is_wishlist', 'is_compare'];

    public function getUrlImageAttribute(){
        if($this->attributes['url_image'] == null){
            return empty($this->attributes['url_image']) ? ['/assets/img/no-image.png'] : $this->attributes['url_image'];
        }else{
            return json_decode($this->attributes['url_image']);
        }
    }

    public function getIsWishlistAttribute(){
        $is_wishlist = 0;
        if (Auth::check()) {
            $wishlist = Wishlist::where(['user_id' => auth()->user()->id, 'master_produk_id' => $this->attributes['id']])->count();
            if($wishlist > 0){
                $is_wishlist = 1;
            }
        }

        return $is_wishlist;
    }

    public function getIsCompareAttribute(){
        $is_compare = 0;
        if (Auth::check()) {
            $compare = Compare::where(['user_id' => auth()->user()->id, 'master_produk_id' => $this->attributes['id']])->count();
            if($compare > 0){
                $is_compare = 1;
            }
        }

        return $is_compare;
    }

    public function getNamaProdukDescAttribute(){
        $string_nama_produk = $this->attributes['nama_produk'];
        foreach($this->master_produk_properties as $item){
            $string_nama_produk .= " [" . $item->value . "]";
        }

        return $string_nama_produk;
    }

    public function getIsPublishDescAttribute(){
        return ($this->attributes['is_publish'] == '1') ? 'publish' : 'not publish';
    }

    public function getHargaJualAttribute(){
        if (Auth::check()) {
            return auth()->user()->tipe_customer_id == 3 ? $this->attributes['harga_jual_b2b'] : $this->attributes['harga_jual_b2c'];
        }else{
            return $this->attributes['harga_jual_b2c'];
        }
    }

    public function getBintangAttribute(){
        return round(TransaksiProduk::where(['master_produk_id' => $this->attributes['id'], 'status' => TransaksiProduk::AKTIF])->avg('bintang')) ?? 0;
    }

    public function scopeActive($query){
        return $query->where(['is_publish' => '1'])->whereNull('deleted_at')->where('stock', '>', '0');
    }

    public function master_kategori(){
        return $this->belongsTo(MasterKategori::class)->withTrashed();
    }

    public function master_subkategori(){
        return $this->belongsTo(MasterSubkategori::class)->withTrashed();
    }

    public function master_produk_subkategori(){
        return $this->hasMany(MasterProdukSubkategori::class)->withTrashed();
    }

    public function master_produk_properties(){
        return $this->hasMany(MasterProdukProperties::class)->withTrashed();
    }

    public function master_produk_harga_grosir(){
        return $this->hasMany(MasterProdukHargaGrosir::class)->withTrashed();
    }

    public function master_seller(){
        return $this->belongsTo(MasterSeller::class, 'seller_id', 'id');
    }
}
