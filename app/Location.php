<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['address', 'lab_id', 'city'];

    public function lab(){
        return $this->belongsTo('App\Lab');
    }

    public function getAddressAttribute($value){
        $splits = explode('-', $value);

        $address = array_pop($splits);

        return trim($address);
    }
}
