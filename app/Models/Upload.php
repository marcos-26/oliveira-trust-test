<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Upload extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'uploads';

    protected $fillable = ['filename', 'reference_date', 'uploaded_at'];
}
