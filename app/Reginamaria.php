<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reginamaria extends Model
{
    protected $table = 'reginamarias';
    protected $fillable = ['name', 'price'];
}
