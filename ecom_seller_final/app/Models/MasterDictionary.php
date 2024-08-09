<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Blameable;

class MasterDictionary extends Model
{
    use HasFactory, Blameable, SoftDeletes;

    protected $table = 'master_dictionary';
    protected $guarded = ['id'];
    protected $appends = ['dictionary_desc'];

    public function getDictionaryDescAttribute(){
        $dictionary = json_decode($this->attributes['dictionary'] );

        $result = '';
        foreach($dictionary as $item){
            $result .= $item . " ,";
        }

        return rtrim($result, ", ");
    }

    public function getDictionaryAttribute(){
         return json_decode($this->attributes['dictionary'] );
    }
}
