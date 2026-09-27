<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class enquiry extends Model
{
    use HasFactory;

    protected $table = 'enquiry';

    protected $fillable = [
        'user_id',
        // 'name',
        // 'email',
        // 'mobile',
        'subject',
        'message',
        'enquiry_raise',
        'enquiry_resolve',
        'remarks',
        // 'role'
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function replies()
    {
        return $this->hasMany(enquiry_reply::class);
    }
}
