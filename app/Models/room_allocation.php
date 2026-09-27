<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class room_allocation extends Model
{

    use HasFactory;

    protected $fillable = [
        'user_id',
        'student_id',
        'room_id',
        'bed_id',
        'allocation_date',
        'admission_id',
        'status',
    ];


    public function admission()
    {
        return $this->belongsTo(admission::class, 'admission_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function bed()
    {
        return $this->belongsTo(hostel_beds::class, 'bed_id');
    }
}
