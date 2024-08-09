<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterSeller extends Model
{
    use HasFactory;
    protected $table = 'master_seller';
    protected $guarded = ['id'];
}
