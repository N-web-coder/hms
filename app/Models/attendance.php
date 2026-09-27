<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class attendance extends Model
{
    protected $table = 'attendances';

    protected $fillable = [
        'user_id', 'status', 'date', 'time_in', 'time_out'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}

