<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class TckrSymb extends Model
{

    protected $connection = 'mongodb';
    protected $fillable = ['value'];

}
