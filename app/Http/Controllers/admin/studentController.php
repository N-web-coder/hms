<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admission;
use App\Models\admission_payment;
use App\Models\hostel_beds;
use App\Models\hostel_room;
use App\Models\mesh_subscription;
use App\Models\room_allocation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Validator;

class studentController extends Controller
{

    public function studentView()
    {
        $students = DB::table('users')
            ->join('admission', 'users.id', '=', 'admission.user_id')
            ->where('users.type', 'student')
            ->select('users.*', 'admission.*')
            ->get();

        return view('admin.student_view', compact('students'));
    }

    public function approve($id)
    {
        $admission = admission::findOrFail($id);

        if ($admission->status === 'active') {
            return redirect()->back()->with('error', 'Admission is already approved.');
        }

        $admission->status = 'active';
        $admission->save();

        return redirect()->back()->with('success', 'Admission approved successfully.');
    }

    public function edit($id)
    {
        $student = admission::with('user')->where('user_id', $id)->firstOrFail();
        $bedAllocation = room_allocation::with('bed')->where('admission_id', $student->id)->first();
        $selectedBedId = $bedAllocation->bed_id ?? null;
        $selectedRoomId = $bedAllocation->bed->room_id ?? null;

        $rooms = hostel_room::with(['beds' => function ($q) use ($selectedBedId) {
            $q->where('status', 'empty')
                ->orWhere('id', $selectedBedId);
        }])->get()->filter(function ($room) {
            return $room->beds->count() > 0;
        });

        $beds = $rooms->firstWhere('id', $selectedRoomId)?->beds ?? collect();

        $mess = mesh_subscription::where('user_id', $id)->first();

        return view('admin.edit_student', compact('student', 'rooms', 'mess', 'bedAllocation', 'beds'));
    }


    public function update(Request $request, $id)
    {

        $user = User::findOrFail($id);
        $admission = admission::where('user_id', $id)->firstOrFail();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'mobile' => 'required|digits:10',
            'parentMobile' => 'required|digits:10',
            'dob' => 'required|date',
            'gender' => 'required|in:male,female',
            'pincode' => 'required|digits:6',
            'address' => 'required|string',
            'adhar' => 'required|digits:12',
            'type' => 'required|in:student,staff',
            'room_id' => ['required_if:type,student','nullable','exists:hostel_rooms,id',],
            'bed_id' => ['required_if:type,student','nullable','exists:hostel_beds,id',],
            'pan' => 'required|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/i',
            'meal_type' => 'required|in:break_fast,lunch,dinner,all',
            'mesh_start' => 'nullable|date',    
            'mesh_end' => 'nullable|date|after_or_equal:mesh_start',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'doc_adhar' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'doc_pan' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'doc_qualification' => 'nullable|mimes:pdf,jpg,png,jpeg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::findOrFail($id);
        $admission = admission::where('user_id', $id)->firstOrFail();

        $user->update([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'type' => $request->type,
        ]);

        if ($request->bed_id != $admission->bed_id) {
            $newBed = hostel_beds::where('id', $request->bed_id)->where('status', 'empty')->first();
            if (!$newBed) {
                return redirect()->back()->withErrors(['bed_id' => 'Selected bed is not available'])->withInput();
            }

            $oldBed = hostel_beds::find($admission->bed_id);
            if ($oldBed) {
                $oldBed->update(['status' => 'empty']);
            }

            $newBed->update(['status' => 'occupy']);

            room_allocation::updateOrCreate(
                ['admission_id' => $admission->id],
                [
                    'user_id' => Auth::id(),
                    'bed_id' => $newBed->id,
                    'allocation_date' => now(),
                    'status' => 'active',
                ]
            );

            $admission->room_id = $request->room_id;
            $admission->bed_id = $request->bed_id;
        }

        $admission->parent_number = $request->parentMobile;
        $admission->dob = $request->dob;
        $admission->gender = $request->gender;
        $admission->address = $request->address;
        $admission->pincode = $request->pincode;
        $admission->adhar_number = $request->adhar;
        $admission->pan_number = $request->pan;

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('uploads/photo', 'public');
            $admission->photo = $photoPath;
        }
        if ($request->hasFile('doc_adhar')) {
            $adharPath = $request->file('doc_adhar')->store('uploads/documents', 'public');
            $admission->doc_adhar = $adharPath;
        }
        if ($request->hasFile('doc_pan')) {
            $panPath = $request->file('doc_pan')->store('uploads/documents', 'public');
            $admission->doc_pan = $panPath;
        }
        if ($request->hasFile('doc_qualification')) {
            $qualPath = $request->file('doc_qualification')->store('uploads/documents', 'public');
            $admission->doc_qualification = $qualPath;
        }

        $admission->save();

        mesh_subscription::updateOrCreate(
            ['user_id' => $user->id],
            [
                'subscription' => 'with_mesh',
                'meal_type' => $request->meal_type,
                'mesh_start' => $request->mesh_start,
                'mesh_end' => $request->mesh_end,
            ]
        );

        return redirect()->route('admin.student.show')->with('success', 'Student updated successfully');
    }

    public function getEmptyBeds($room_id)
    {
        $beds = hostel_beds::where('room_id', $room_id)
            ->where('status', 'empty')
            ->get(['id', 'bed_number', 'status']);

        return response()->json($beds);
    }


    public function destroy($id)
    {

        DB::table('admission')->where('user_id', $id)->delete();
        DB::table('users')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Student deleted successfully.');
    }

    public function studentPayments(Request $request)
    {
        $students = User::where('type', 'student')->pluck('name', 'id');

        $query = admission_payment::with('user');

        if ($request->filled('month')) {
            $query->whereMonth('date', $request->month);
        }

        if ($request->filled('year')) {
            $query->whereYear('date', $request->year);
        }

        if ($request->filled('student_id')) {
            $query->where('user_id', $request->student_id);
        }

        $payments = $query->orderBy('date', 'desc')->get();

        return view('admin.student_payments', compact('payments', 'students'));
    }

    public function generatePDF($id)
    {
        $payment = admission_payment::with(['user', 'admission'])->findOrFail($id);

        $pdf = Pdf::loadView('admin.student_slip', compact('payment'));
        return $pdf->stream('payment_receipt_' . $payment->id . '.pdf');
    }

    public function fullDetails($admission_id)
    {
        $admission = admission::with([
            'user',
            'payments',
            'roomAllocation.bed.room',
            'mesh'
        ])->find($admission_id);

        if (!$admission) {
            return redirect()->route('admin.student.show')
                ->with('error', 'Student admission not found.');
        }

        return view('admin.student_details', compact('admission'));
    }
}
