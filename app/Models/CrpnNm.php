<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class CrpnNm extends Model
{

    protected $connection = 'mongodb';
    protected $fillable = ['value'];


}
