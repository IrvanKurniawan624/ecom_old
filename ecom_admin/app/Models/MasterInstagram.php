<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Blameable;

class MasterInstagram extends Model
{
    use HasFactory, Blameable, SoftDeletes;

    protected $table = 'master_instagram';
    protected $guarded = ['id'];
}
