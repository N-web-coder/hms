<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class hostel_beds extends Model
{

    protected $fillable = ['room_id', 'bed_number', 'total_bed', 'status'];

    public function room()
    {
        return $this->belongsTo(hostel_room::class, 'room_id');
    }
    public function allocation()
    {
        return $this->hasOne(room_allocation::class, 'bed_id')->latest();
    }

    public function bed()
    {
        return $this->belongsTo(hostel_beds::class, 'bed_id');
    }

    public function beds()
    {
        return $this->hasMany(hostel_beds::class, 'room_id');
    }
}
