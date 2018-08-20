<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['lab_id', 'url', 'rank', 'title', 'description'];

    public function getUrlAttribute($value){
        return \Storage::url($value);
    }
}
