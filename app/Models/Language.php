<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $table = 'languages';
    protected $fillable = ['abbr', 'locale', 'name', 'direction', 'active'];

    public function scopeActive($q){
        return $q->where('active' , 1);
    }

    public function scopeSelection($q){
        return $q->select('abbr', 'name', 'direction', 'active');
    }

    public function getActive(){
       return $this->active == 1 ? "مفعل" : "غير مفعل" ;
    }
}
