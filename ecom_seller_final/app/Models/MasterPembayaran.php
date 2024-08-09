<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterPembayaran extends Model
{
    use HasFactory;
    protected $table = 'master_pembayaran';
    protected $guarded = ['id'];
}
