<?php

use App\Models\Language;
use Illuminate\Support\Facades\Config;

function get_languages(){
    return Language::active()->select()->get();
}

function get_default_lang(){
    return Config::get('app.locale');
}


function uploadImage($folder, $image){
    $image->store('/', $folder);
    $file_name = $image->hashName();
    $path = 'images/'.$folder.'/'.$file_name;
    return $path;
}
