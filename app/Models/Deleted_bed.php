<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deleted_bed extends Model
{
    protected $table = 'deleted_beds';

     protected $fillable = [
        'bed_id',
        'room_id',
        'bed_number',
        'deleted_at',
    ];

    public $timestamps = true;
}
