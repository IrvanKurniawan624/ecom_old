<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Blameable;

class TipeCustomer extends Model
{
    use HasFactory, Blameable, SoftDeletes;

    protected $table = 'tipe_customer';
    protected $guarded = ['id'];

    public const CUSTOMER = 2;
    public const BUSINESS = 3;
}
