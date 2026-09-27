<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeType extends Model
{
     protected $fillable = ['name'];

    public function invoices()
    {
        return $this->hasMany(StudentInvoice::class);
    }
}
