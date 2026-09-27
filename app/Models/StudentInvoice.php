<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentInvoice extends Model
{
     protected $fillable = [
        'admission_id',
        'fee_type_id',
        'invoice_no',
        'invoice_date',
        'payment_mode',
        'gross_amount',
        'tax_amount',
        'discount_amount',
        'total_amount',
        'paid_amount',
        'remarks',
        'status',
    ];

    public function feeType()
    {
        return $this->belongsTo(FeeType::class);
    }

    public function admission()
    {
        return $this->belongsTo(admission::class);
    }
}
