<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mesh_subscription extends Model
{

    protected $fillable = [
        'user_id',
        'subscription',
        'meal_type',
        'mesh_start',
        'mesh_end',
        'remarks',
    ];
}
