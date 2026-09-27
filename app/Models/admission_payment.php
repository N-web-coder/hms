<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class admission_payment extends Model
{
    use HasFactory;
    protected $table = 'admission_payments';

    protected $fillable = ['user_id', 'date', 'amount', 'payment_mode', 'ref_no', 'accepted_by'];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function admission()
    {
        return $this->belongsTo(admission::class, 'admission_id');
    }
}
