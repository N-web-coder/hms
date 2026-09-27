<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class monthly_payment extends Model
{
    protected $fillable = [
    'user_id',
    'month',
    'hostel_amount',
    'mess_amount',
    'payment_mode',
    'ref_no',
];

}
