<?php

namespace App\Http\Controllers\staff;

use App\Http\Controllers\Controller;
use App\Models\salary_payment;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class paymentController extends Controller
{
    public function staffSalaryHistory(Request $request)
    {

        $user = Auth::user()->load('accounts');

        if (!$user->accounts || $user->accounts->isEmpty()) {
            return back()->with('error', 'No bank account found. Please contact admin.');
        }

        $accountIds = $user->accounts->pluck('id');

        $query = salary_payment::with('accounts')
            ->whereIn('account_id', $accountIds);

        if ($request->filled('from_date')) {
            $query->where('date', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->where('date', '<=', $request->to_date);
        }

        $payments = $query->orderBy('date', 'desc')->paginate(10);


        return view('staff.payment_history', compact('payments'));
    }
}
