<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Checkin extends Model
{
    protected $fillable = ['_id', 'pin'];
}
