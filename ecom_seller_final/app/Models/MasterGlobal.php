<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Blameable;

class MasterGlobal extends Model
{
    use HasFactory, Blameable, SoftDeletes;

    protected $table = 'master_global';
    protected $guarded = ['id'];
}
