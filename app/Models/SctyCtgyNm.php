<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class SctyCtgyNm extends Model
{

    protected $connection = 'mongodb';
    protected $fillable = ['value'];

}
