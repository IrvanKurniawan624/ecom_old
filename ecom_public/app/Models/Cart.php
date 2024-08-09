<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Cart extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('available_produk', function (Builder $builder) {
            $builder->whereHas('master_produk', function($query){
                $query->whereNull('deleted_at')->where('is_publish', 1)->where('stock', '>', 0);
            });
        });
    }

    protected $table = 'cart';
    protected $guarded = ['id'];

    public function scopeActive($query){
        $query->where('user_id', auth()->user()->id);
    }

    public function scopeCheckoutActive($query){
        $query->where(['user_id' => auth()->user()->id, 'is_checkout' => '1']);
    }

    public function master_seller(){
        return $this->belongsTo(MasterSeller::class, 'seller_id' ,'id');
    }

    public function user(){
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function master_produk(){
        return $this->belongsTo(MasterProduk::class)->withTrashed();
    }
}
