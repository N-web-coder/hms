<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\CompanyInfo;
use App\Models\FeeType;
use App\Models\StudentInvoice;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class invoiceController extends Controller
{

    public function createInvoice()
    {
        $students = User::where('type', 'student')
            ->whereHas('admission', function ($query) {
                $query->where('status', 'active');
            })
            ->with('admission')
            ->get();

        $feeTypes = FeeType::all();

        return view('admin.invoice', compact('students', 'feeTypes'));
    }

    public function storeInvoice(Request $request)
    {
        $request->validate([
            'admission_id'     => 'required|exists:admission,id',
            'fee_type_id'      => 'required|exists:fee_types,id',
            'payment_mode'     => 'required',
            'gross_amount'     => 'required|numeric',
            'tax_amount'       => 'nullable|numeric',
            'discount_amount'  => 'nullable|numeric',
            'remarks'          => 'nullable|string',
        ]);

        $gross = $request->gross_amount;
        $tax = $request->tax_amount ?? 0;
        $discount = $request->discount_amount ?? 0;

        $invoice = StudentInvoice::create([
            'admission_id'    => $request->admission_id,
            'fee_type_id'     => $request->fee_type_id,
            'invoice_no'      => 'INV' . rand(1000, 9999),
            'invoice_date'    => now(),
            'payment_mode'    => $request->payment_mode,
            'gross_amount'    => $gross,
            'tax_amount'      => $tax,
            'discount_amount' => $discount,
            'total_amount'    => ($gross + $tax - $discount),
            'paid_amount'     => 0,
            'remarks'         => $request->remarks,
            'status'          => $request->status,
        ]);


        return redirect()->route('invoice.download', $invoice->id);
    }

    public function download($id)
    {
        $invoice = StudentInvoice::with('feeType', 'admission.user')->findOrFail($id);
        $student = $invoice->admission->user;
        $account = Account::where('user_id', $student->id)->first();
        $companyInfo = CompanyInfo::where('user_id', Auth::id())->first();

        $pdf = PDF::loadView('admin.invoice_download', compact('invoice', 'student', 'account', 'companyInfo'))
            ->setPaper('A4', 'portrait');

        $studentName = str_replace(' ', '_', $student->name);

        return $pdf->download('invoice_' . $studentName . '.pdf');

    }

    public function companyInfoUpdate(Request $request)
    {
        $request->validate([
            'owner'   => 'required|string|max:100',
            'name'    => 'required|string|max:100',
            'email'   => 'required|email',
            'mobile'  => 'required|digits:10',
        ]);

        $companyData = CompanyInfo::create([
            'user_id' => Auth::id(),
            'owner'     => $request->owner,
            'CompanyName'     => $request->name,
            'CompanyEmail'    => $request->email,
            'mobile'   => $request->mobile,
            'address'   => $request->address,
            'city'   => $request->city,
            'pincode'   => $request->pincode,
            'state'   => $request->state,
            'rc'   => $request->rc,
            'pan'   => $request->pan,
            'gst'   => $request->gst,
            'bankName'   => $request->bank,
            'account' => $request->account,
            'ifsc'   => $request->ifsc,
        ]);

        $companyData->save();

        return redirect()->back()->with('Success', 'Company information Created successfully!');
    }
}
