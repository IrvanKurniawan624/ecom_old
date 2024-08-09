<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
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

    protected static $logAttributes = ["*"];

    protected $guarded = ['id'];
    protected $appends = ['status_upgrade_desc', 'status_upgrade_badge'];

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

    public const STATUS_UPGRADE_PENDING = 0;
    public const STATUS_UPGRADE_APPROVE = 1;
    public const STATUS_UPGRADE_REJECT = 2;

    public function getStatusUpgradeBadgeAttribute(){
        if($this->attributes['status_upgrade'] == '0'){
            return '<span class="badge badge-warning">pending</span>';
        }elseif($this->attributes['status_upgrade'] == '1'){
            return '<span class="badge badge-success">approved</span>';
        }else{
            return '<span class="badge badge-danger">rejected</span>';
        }
    }

    public function getStatusUpgradeDescAttribute(){
        if($this->attributes['status_upgrade'] == '0'){
            return 'pending';
        }elseif($this->attributes['status_upgrade'] == '1'){
            return 'approved';
        }else{
            return 'rejected';
        }
    }

    public function tipe_customer(){
        return $this->belongsTo(TipeCustomer::class)->withTrashed();
    }

    public function scopeCustomerAll($query){
        $query->whereNotIn('tipe_customer_id', ['1']);
    }

    public function scopeActive($query){
        $query->where('is_active', 1);
    }
}
