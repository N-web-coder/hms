<?php

namespace App\Http\Controllers\staff;

use App\Http\Controllers\Controller;
use App\Models\admission;
use Illuminate\Http\Request;

class studentMenuController extends Controller
{
    public function staffAdmissions()
    {
        $admissions = admission::where('created_by', auth()->id())->with('user')->latest()->get();
// return $admissions;
        return view('staff.admission', compact('admissions'));
    }
}
