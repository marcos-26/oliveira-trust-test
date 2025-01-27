<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class ISIN extends Model
{

    protected $connection = 'mongodb';
    protected $fillable = ['value'];

}
