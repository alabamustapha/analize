<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Synlab extends Model
{
    protected $table = 'synlabs';
    protected $fillable = ['name', 'code', 'price'];
}
