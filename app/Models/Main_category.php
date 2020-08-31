<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Main_category extends Model
{
    protected $table = 'main_categories';
    protected $fillable = ['translation_lang', 'translation_of', 'name', 'slug', 'photo', 'active'];

    public function scopeActive($q){
        return $q->where('active' , 1);
    }

    public function scopeSelection($q){
        return $q->select('id', 'translation_lang', 'name', 'slug', 'photo', 'active');
    }

    public function getPhotoAttribute($val)
    {
        return ($val !== null) ? asset('assets/' . $val) : "";
    }

    public function getActive(){
        return $this->active == 1 ? 'مفعل' : 'غير مفعل';
    }
}
