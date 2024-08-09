<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Blameable;

class PoinStrukOffline extends Model
{
    use HasFactory, SoftDeletes, Blameable;

    protected $table = 'poin_struk_offline';
    protected $guarded = ['id'];
    protected $appends = ['status_desc', 'status_badge', 'created_at_desc'];

    protected static $logAttributes = ["*"];

    public const PENDING = 0;
    public const DITERIMA = 1;
    public const DITOLAK = 2;

    public function getStatusDescAttribute(){
        if($this->attributes['status'] == '1'){
            return 'diterima';
        }elseif($this->attributes['status'] == '2'){
            return 'ditolak';
        }else{
            return 'pending';
        }
    }

    public function getStatusBadgeAttribute(){
        if($this->attributes['status'] == '0'){
            return '<span class="badge badge-warning">pending</span>';
        }elseif($this->attributes['status'] == '1'){
            return '<span class="badge badge-success">approved</span>';
        }else{
            return '<span class="badge badge-danger">rejected</span>';
        }
    }

    public function user(){
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function getCreatedAtDescAttribute(){
        return \Carbon\Carbon::parse($this->attributes['created_at'])->format('d-m-Y');
    }
}
