<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\admission;
use App\Models\admission_payment;
use App\Models\enquiry;
use App\Models\hostel_beds;
use App\Models\hostel_room;
use App\Models\mesh_subscription;
use App\Models\monthly_payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class indexController extends Controller
{
    public function dashboard()
    {
        $rooms = hostel_room::with('beds')->get();
        return view('student.index', compact('rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            // Admission details
            'parent_number' => 'required',
            'dob' => 'required|date',
            'admission_date' => 'required|date',
            'address' => 'required',
            'pincode' => 'required',
            'adhar_number' => 'required',
            'pan_number' => 'nullable',
            'gender' => 'required|in:male,female',
            'photo' => 'required|image',
            'doc_adhar' => 'required|file',
            'doc_pan' => 'required|file',
            'doc_qualification' => 'required|file',

            // Mesh
            'subscription' => 'required|in:with_mesh,without_mesh',
            'mesh_start' => 'required|date',
            'meal_type' => 'required|in:break_fast,lunch,dinner,all',

            // Room/bed
            'bed_id' => 'required|exists:hostel_beds,id',

            // Payment
            'amount' => 'required|numeric|min:1',
            'payment_mode' => 'required|string',
            'ref_no' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $userId = Auth::id();

            // Save documents
            $photo = $request->file('photo')->store('uploads/photo', 'public');
            $docAadhar = $request->file('doc_adhar')->store('uploads/documents', 'public');
            $docPan = $request->file('doc_pan')->store('uploads/documents', 'public');
            $docQual = $request->file('doc_qualification')->store('uploads/documents', 'public');

            // Save admission
            $admission = admission::create([
                'user_id' => $userId,
                'parent_number' => $request->parent_number,
                'dob' => $request->dob,
                'admission_date' => $request->admission_date,
                'address' => $request->address,
                'pincode' => $request->pincode,
                'adhar_number' => $request->adhar_number,
                'pan_number' => $request->pan_number,
                'photo' => $photo,
                'doc_adhar' => $docAadhar,
                'doc_pan' => $docPan,
                'doc_qualification' => $docQual,
                'gender' => $request->gender,
                'status' => 'inactive',
            ]);

            // Mesh subscription
            \App\Models\mesh_subscription::create([
                'user_id' => $userId,
                'subscription' => $request->subscription,
                'mesh_start' => $request->mesh_start,
                'meal_type' => $request->meal_type,
            ]);

            // Room allocation
            \App\Models\room_allocation::create([
                'user_id' => $userId,
                'admission_id' => $admission->id,
                'bed_id' => $request->bed_id,
                'allocation_date' => now(),
                'status' => 'active',
            ]);

            // Update bed status
            hostel_beds::where('id', $request->bed_id)->update(['status' => 'occupy']);

            // Payment
            \App\Models\admission_payment::create([
                'user_id' => $userId,
                'date' => now(),
                'amount' => $request->amount,
                'payment_mode' => $request->payment_mode,
                'ref_no' => $request->ref_no,
                'accepted_by' => 'self',
            ]);

            DB::commit();
            return redirect()->route('student.dashboard')->with('success', 'Admission completed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Something went wrong: ' . $e->getMessage());
        }
    }


    public function admission()
    {
        $admission = admission::where('user_id', Auth::id())->first();
        // return $admission;
        return view('student.admission', compact('admission'));
    }

    public function payments()
    {
        $payments = admission_payment::where('user_id', Auth::id())->get();
        return view('student.payments', compact('payments'));
    }

    public function mesh()
    {
        $mesh = mesh_subscription::where('user_id', Auth::id())->first();
        return view('student.mesh', compact('mesh'));
    }

    public function monthlyPayments()
    {
        $payments = monthly_payment::where('user_id', Auth::id())->orderBy('month', 'desc')->get();
        return view('student.monthly', compact('payments'));
    }

    public function storeMonthlyPayment(Request $request)
    {
        $request->validate([
            'month' => 'required|date_format:Y-m',
            'hostel_amount' => 'required|integer|min:0',
            'mess_amount' => 'required|integer|min:0',
            'payment_mode' => 'required|string',
            'ref_no' => 'nullable|string',
        ]);

        monthly_payment::create([
            'user_id' => Auth::id(),
            'month' => $request->month,
            'hostel_amount' => $request->hostel_amount,
            'mess_amount' => $request->mess_amount,
            'payment_mode' => $request->payment_mode,
            'ref_no' => $request->ref_no,
        ]);

        return back()->with('success', 'Monthly payment submitted successfully!');
    }

    public function enquiryShow(Request $request)
    {
        $enquiries = enquiry::where('user_id', Auth::id())->latest()->get();
        return view('student.enquiries', compact('enquiries'));
    }

    public function enquiryStore(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        enquiry::create([
            'user_id' => Auth::id(),
            'enquiry_raise' => now(),
            'enquiry_resolve' => now(),
            'remarks'=> 'NA',
            'subject' => $request->subject,
            'message' => $request->message,
            'role' => 'student',
        ]);

        return back()->with('success', 'Enquiry submitted successfully!');
    }
}
