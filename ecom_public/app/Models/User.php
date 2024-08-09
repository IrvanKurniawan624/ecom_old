<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, logsActivity, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];
    protected $appends = ['tipe_customer_desc'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function tipe_customer(){
        return $this->belongsTo(TipeCustomer::class)->withTrashed();
    }

    public function scopeCustomerAll($query){
        $query->whereNotIn('tipe_customer_id', ['1']);
    }

    public function getTipeCustomerDescAttribute(){
        if (Auth::check()) {
            return auth()->user()->tipe_customer_id == 3 ? 'B2B' : 'B2C';
        }else{
            'B2C';
        }
    }
}
