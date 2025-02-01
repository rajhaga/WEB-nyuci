<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'package_name',
        'pickup_latitude',
        'pickup_longitude',
        'destination_latitude',
        'destination_longitude',
    ];
}

