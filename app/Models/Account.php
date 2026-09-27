<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'accounts';
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function salaryPayments()
    {
        return $this->hasMany(salary_payment::class);
    }

    public function accounts()
    {
        return $this->hasMany(account::class);
    }
}
