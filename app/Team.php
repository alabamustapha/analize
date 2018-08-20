<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['lab_id', 'name', 'title', 'avatar', 'rank'];


    
    public function getAvatarAttribute($value){
        return \Storage::url($value);
    }
}


