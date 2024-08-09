<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Blameable;

class MasterSupplier extends Model
{
    use HasFactory, Blameable, SoftDeletes;

    protected $table = 'master_supplier';
    protected $guarded = ['id'];
}
