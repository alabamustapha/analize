<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';
    
    protected $fillable = ['name', 'url', 'category_id'];

    public function category(){
        return $this->belongsTo('App\Category');
    }

    public function tests(){
        return $this->hasMany('App\Test');
    }
}
