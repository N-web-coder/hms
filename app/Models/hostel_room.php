<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class hostel_room extends Model
{

    protected $fillable = ['room_number', 'total_bed', 'user_id'];

    public function beds()
    {
        return $this->hasMany(hostel_beds::class, 'room_id');
    }
}
