<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class admission extends Model
{
    protected $table = 'admission';


    protected $fillable = [
    'user_id',
    'parent_number',
    'dob',
    'admission_date',
    'address',
    'pincode',
    'adhar_number',
    'pan_number',
    'photo',
    'doc_adhar',
    'doc_pan',
    'doc_qualification',
    'gender',
    'status',
    'created_by'
];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function payments()
    {
        return $this->hasMany(admission_payment::class, 'user_id', 'user_id');
    }

    public function roomAllocation()
    {
        return $this->hasOne(room_allocation::class, 'admission_id');
    }

    public function mesh()
    {
        return $this->hasOne(mesh_subscription::class, 'user_id', 'user_id');
    }
}
