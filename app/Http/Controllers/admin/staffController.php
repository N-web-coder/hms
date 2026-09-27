<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admission;
use App\Models\salary_payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;

class staffController extends Controller
{
    public function staffView()
    {
        $staffs = DB::table('users')
            ->leftJoin('admission', 'users.id', '=', 'admission.user_id')
            ->where('users.type', 'staff')
            ->select('users.*', 'admission.*', 'users.id as user_id')
            ->get();

        return view('admin.staff_view', compact('staffs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'mobile'   => 'required|digits:10',
            'password' => 'required|min:6|confirmed',

            'parent_number' => 'nullable',
            'dob'           => 'nullable|date',
            'gender'        => 'nullable|in:male,female',
            'address'       => 'nullable',
            'pincode'       => 'nullable',
            'adhar_number'  => 'nullable',
            'pan_number'    => 'nullable',
            'photo'         => 'nullable|image',
        ]);


        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'mobile'   => $request->mobile,
            'password' => Hash::make($request->password),
            'type'     => 'staff',
        ]);


        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('uploads/photo', 'public');
        }


        DB::table('admission')->insert([
            'user_id'         => $user->id,
            'parent_number'   => $request->parent_number,
            'dob'             => $request->dob,
            'gender'          => $request->gender,
            'address'         => $request->address,
            'pincode'         => $request->pincode,
            'adhar_number'    => $request->adhar_number,
            'pan_number'      => $request->pan_number,
            'photo'           => $photoPath,
            'status'          => 'active',
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        return redirect()->route('admin.staff.show')->with('success', 'Staff created successfully!');
    }

    public function edit($id)
    {
        $staff = User::findOrFail($id);
        $admission = DB::table('admission')->where('user_id', $id)->first();

        return view('admin.edit_staff', compact('staff', 'admission'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $id,
            'mobile'   => 'required|digits:10',

            'parent_number' => 'nullable',
            'dob'           => 'nullable|date',
            'gender'        => 'nullable|in:male,female',
            'address'       => 'nullable',
            'pincode'       => 'nullable',
            'adhar_number'  => 'nullable',
            'pan_number'    => 'nullable',
            'photo'         => 'nullable|image',
        ]);


        $user = User::findOrFail($id);
        $user->update([
            'name'   => $request->name,
            'email'  => $request->email,
            'mobile' => $request->mobile,
        ]);


        $admissionData = [
            'parent_number' => $request->parent_number,
            'dob'           => $request->dob,
            'gender'        => $request->gender,
            'address'       => $request->address,
            'pincode'       => $request->pincode,
            'adhar_number'  => $request->adhar_number,
            'pan_number'    => $request->pan_number,
            'updated_at'    => now(),
        ];

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('uploads/photo', 'public');
            $admissionData['photo'] = $photoPath;
        }

        DB::table('admission')->where('user_id', $id)->update($admissionData);

        return redirect()->route('admin.staff.show')->with('success', 'Staff updated successfully!');
    }


    public function staffApprove($id)
    {
        $admission = admission::where('user_id', $id)->first();

        if (!$admission) {
            return back()->with('error', 'Staff admission record not found.');
        }

        $admission->status = 'active';
        $admission->save();

        return back()->with('success', 'Staff admission approved successfully.');
    }

    public function destroy($id)
    {
        DB::table('admission')->where('user_id', $id)->delete();
        User::where('id', $id)->delete();

        return redirect()->route('admin.staff.show')->with('success', 'Staff deleted successfully!');
    }

    public function paySalary(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'present_days' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);

        $user_id = $request->user_id;
        $perDay = 500;

        $account = DB::table('accounts')->where('user_id', $user_id)->first();

        if (!$account) {
            return back()->with('error', 'Bank account not found for this staff.');
        }

        $alreadyPaid = DB::table('salary_payments')
            ->where('account_id', $account->id)
            ->where('date', $request->date)
            ->exists();

        if ($alreadyPaid) {
            return back()->with('error', 'Salary already paid for this staff on this date.');
        }


        DB::table('salary_payments')->insert([
            'account_id'    => $account->id,
            'gross_amount'  => $request->present_days * $perDay,
            'deduct_amount' => 0,
            'net_amount'    => $request->present_days * $perDay,
            'date'          => $request->date,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        return back()->with('success', 'Salary paid successfully.');
    }

    public function salaryHistory(Request $request)
    {
        $staffList = DB::table('users')->where('type', 'staff')->get();

        $selectedStaff = $request->input('staff_id');
        $selectedMonth = $request->input('month');
        $selectedYear  = $request->input('year');

        $query = DB::table('salary_payments')
            ->join('accounts', 'salary_payments.account_id', '=', 'accounts.id')
            ->join('users', 'accounts.user_id', '=', 'users.id')
            ->select('users.name', 'users.id as user_id', 'salary_payments.*')
            ->orderBy('salary_payments.date', 'desc');

        if ($selectedStaff) {
            $query->where('users.id', $selectedStaff);
        }

        if ($selectedMonth) {
            $query->whereMonth('salary_payments.date', $selectedMonth);
        }

        if ($selectedYear) {
            $query->whereYear('salary_payments.date', $selectedYear);
        }

        $salaries = $query->get();


        return view('admin.staff_salary_history', compact('salaries', 'staffList', 'selectedStaff', 'selectedMonth', 'selectedYear'));
    }

    public function staffAttendanceHistory(Request $request)
    {
        $staffList = DB::table('users')
            ->where('type', 'staff')
            ->select('id', 'name')
            ->get();

        $selectedStaffId = $request->input('staff_id');
        $selectedMonth   = $request->input('month');
        $selectedYear    = $request->input('year');

        $attendances = collect();

        if ($selectedStaffId) {
            $query = DB::table('attendances')
                ->join('users', 'attendances.user_id', '=', 'users.id')
                ->where('attendances.user_id', $selectedStaffId)
                ->select('users.name', 'users.email', 'attendances.*')
                ->orderBy('attendances.date', 'desc');

            if ($selectedMonth) {
                $query->whereMonth('attendances.date', $selectedMonth);
            }

            if ($selectedYear) {
                $query->whereYear('attendances.date', $selectedYear);
            }

            $attendances = $query->get();
        }

        return view('admin.staff_attendance', compact('staffList', 'attendances', 'selectedStaffId', 'selectedMonth', 'selectedYear'));
    }

    public function generateSalarySlipPDF($id)
    {
        $salary = salary_payment::with('account', 'user')->findOrFail($id);

        $pdf = Pdf::loadView('admin.staff_slip', compact('salary'));
        return $pdf->stream('salary_slip_' . $salary->id . '.pdf');
    }
}
