<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckoutTemp extends Model
{
    use HasFactory;

    protected $table = 'checkout_temp';
    protected $guarded = ['id'];

    public function scopeActive($query){
        $query->where('user_id', auth()->user()->id);
    }

    public function user(){
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function master_produk(){
        return $this->belongsTo(MasterProduk::class)->withTrashed();
    }
}
