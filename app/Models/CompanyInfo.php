<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyInfo extends Model
{

    protected $table = 'companyinfos';
    protected $fillable = ['user_id','owner', 'CompanyName', 'CompanyEmail', 'mobile'];
}
