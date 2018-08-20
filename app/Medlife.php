<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medlife extends Model
{
    protected $table = 'medlives';
    protected $fillable = ['name', 'price'];
}
