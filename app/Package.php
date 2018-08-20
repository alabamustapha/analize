<?php

namespace App;

use App\Test;
use App\Group;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = ['name', 'price', 'groups', 'lab_id'];

    protected $casts = [
        'groups' => 'array',
    ];

    public function  getRouteKeyName(){
        return 'id';
    }

    public function getGroupsAttribute($value){
        $value = json_decode($value);
            
        return $this->lab->tests()->whereIn('group_id', $value)->get();
    }

    public function lab(){
        return $this->belongsTo('App\Lab');
    }
}
