<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Synevo extends Model
{
    protected $table = 'synevos';
    protected $fillable = ['name', 'code', 'price'];
}
