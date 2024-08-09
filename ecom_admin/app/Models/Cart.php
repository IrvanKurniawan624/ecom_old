<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Blameable;

class Cart extends Model
{
    use HasFactory, Blameable;

    protected $table = 'cart';
    protected $guarded = ['id'];

    public function scopeActive($query){
        $query->where('user_id', auth()->user()->id);
    }

    public function scopeCheckoutActive($query){
        $query->where(['user_id' => auth()->user()->id, 'is_checkout' => '1']);
    }

    public function user(){
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function master_produk(){
        return $this->belongsTo(MasterProduk::class)->withTrashed();
    }
}
