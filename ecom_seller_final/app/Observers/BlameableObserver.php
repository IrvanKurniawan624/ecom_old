<?php

namespace App\Observers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use App\Blameable;
use File;

class BlameableObserver
{
    public function creating(Model $model)
    {
        if(Auth::check()){
            $model->created_by = Auth::user()->id;
        }
    }

    public function updating(Model $model)
    {
        if(Auth::check()){
            $model->updated_by = Auth::user()->id;
        }
    }

    public function deleted(Model $model)
    {
        if(Auth::check()){
            $model->deleted_by = Auth::user()->id;
            $model->save();
        }
    }
}
