<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PoinStrukOffline extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'poin_struk_offline';
    protected $guarded = ['id'];

    public const PENDING = 0;
    public const DITERIMA = 1;
    public const DITOLAK = 2;

    public function user(){
        return $this->belongsTo(User::class)->withTrashed();
    }
}
