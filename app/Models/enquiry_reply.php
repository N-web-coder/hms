<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class enquiry_reply extends Model
{
    protected $fillable = ['enquiry_id', 'user_id', 'reply'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function enquiry()
    {
        return $this->belongsTo(enquiry::class);
    }
}
