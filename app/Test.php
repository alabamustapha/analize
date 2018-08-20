<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable = ['name', 'price', 'lab_id'];

    public function group(){
        return $this->belongsTo('App\Group');
    }

    public function getRouteKey(){
        return 'id';
    }
}
