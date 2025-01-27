<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class MktNm extends Model
{

    protected $connection = 'mongodb';
    protected $fillable = ['value'];

}
