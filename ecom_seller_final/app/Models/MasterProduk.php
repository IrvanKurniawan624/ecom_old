<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Blameable;

class MasterProduk extends Model
{
    use HasFactory, Blameable, SoftDeletes, LogsActivity;

    protected $table = 'master_produk';
    protected $guarded = ['id'];
    protected $appends = ['is_publish_desc', 'nama_produk_desc', 'safety_stock'];

    protected static $logAttributes = ["*"];

    public function getUrlImageAttribute(){
        if($this->attributes['url_image'] == null){
            return empty($this->attributes['url_image']) ? ['/assets/img/no-image.png'] : $this->attributes['url_image'];
        }else{
            return json_decode($this->attributes['url_image']);
        }
    }

    public function getSafetyStockAttribute(){
        return $this->attributes['stock'];
    }

    public function getNamaProdukDescAttribute(){
        $string_nama_produk = $this->attributes['nama_produk'];
        foreach($this->master_produk_properties()->get() as $item){
            $string_nama_produk .= " [" . $item->value . "]";
        }

        return $string_nama_produk;
    }

    public function getIsPublishDescAttribute(){
        return ($this->attributes['is_publish'] == '1') ? 'publish' : 'not publish';
    }

    public function scopeActive($query){
        return $query->where(['is_publish' => '1'])->where('stock', '>', '0');
    }

    public function master_kategori(){
        return $this->belongsTo(MasterKategori::class)->withTrashed();
    }

    public function master_seller(){
        return $this->belongsTo(MasterSeller::class)->withTrashed();
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
        return $this->hasMany(MasterProdukHargaGrosir::class, 'master_produk_id');
    }
}
