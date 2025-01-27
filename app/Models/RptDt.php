<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class RptDt extends Model
{

    protected $connection = 'mongodb';
    protected $fillable = ['value'];

}
