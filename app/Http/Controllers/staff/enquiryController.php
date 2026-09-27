<?php

namespace App\Http\Controllers\staff;

use App\Http\Controllers\Controller;
use App\Models\enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class enquiryController extends Controller
{
    public function showEnquiryForm()
    {
        $enquiries = enquiry::where('user_id', Auth::id())->latest()->get();
        return view('staff.enquiry_form', compact('enquiries'));
    }

    public function submitEnquiry(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        enquiry::create([
            'user_id' => Auth::id(),
            'enquiry_raise' => now(),
            'enquiry_resolve' => now(),
            'remarks' => 'NA',
            'subject' => $request->subject,
            'message' => $request->message,
            'role' => 'student',
        ]);

        return redirect()->back()->with('success', 'Enquiry submitted successfully.');
    }
}
