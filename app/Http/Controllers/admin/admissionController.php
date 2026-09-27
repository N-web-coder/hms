<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admission;
use App\Models\enquiry;
use App\Models\enquiry_reply;
use App\Models\hostel_beds;
use App\Models\hostel_room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class admissionController extends Controller
{

    public function adminIndexShow(Request $request)
    {

        $totalStudents = User::where('type', 'student')->count() ?? 0;
        $totalStaffs = User::where('type', 'staff')->count() ?? 0;
        $totalRoom = hostel_room::count() ?? 0;
        $totalBeds = hostel_room::sum('total_bed') ?? 0;
        $totalBedOccupy = hostel_beds::where('status', 'occupy')->count() ?? 0;
        $totalBedEmpty = hostel_beds::where('status', 'empty')->count() ?? 0;

        return view('admin.index', compact('totalStudents', 'totalStaffs', 'totalRoom', 'totalBeds', 'totalBedOccupy', 'totalBedEmpty'));
    }

    public function admissionFormShow(Request $request)
    {
        $rooms = hostel_room::with(['beds' => function ($q) {
            $q->where('status', 'empty');
        }])->get()->filter(function ($room) {
            return $room->beds->count() > 0;
        });

        return view('admin.new_admission', compact('rooms'));
    }

    public function submitAdminForm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'nullable|email|unique:users,email',
            'mobile' => 'required|digits:10',
            'parentMobile' => 'required|digits:10',
            'dob' => 'required|date',
            'gender' => 'required|in:male,female',
            'pincode' => 'required|digits:6',
            'address' => 'required|string',
            'adhar' => 'required|digits:12',
            'type' => 'required',
            'room_id' => 'required|exists:hostel_rooms,id',
            'bed_id' => 'required|exists:hostel_beds,id',
            'pan' => 'required|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/i',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'doc_adhar' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'doc_pan' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'doc_qualification' => 'nullable|mimes:pdf,jpg,png,jpeg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $emailExists = User::where('email', $request->email)->exists();

        if ($emailExists) {
            return redirect()->back()->withErrors(['email' => 'This email is already registered.'])->withInput();
        }

        $bed = hostel_beds::where('id', $request->bed_id)->where('status', 'empty')->first();
        if (!$bed) {
            return redirect()->back()->withErrors(['bed_id' => 'Selected bed is not available.'])->withInput();
        }

        $user = new User();
        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->email = $request->email;
        $user->type = $request->type;

        $cleanedName = strtolower(str_replace(' ', '', $request->name));
        $defaultPassword = $cleanedName . '@123';
        $user->password = Hash::make($defaultPassword);
        $user->save();

        $photo = $request->file('photo') ? $request->file('photo')->store('uploads/photo', 'public') : null;
        $adhar = $request->file('doc_adhar') ? $request->file('doc_adhar')->store('uploads/documents', 'public') : null;
        $pan = $request->file('doc_pan') ? $request->file('doc_pan')->store('uploads/documents', 'public') : null;
        $qualification = $request->file('doc_qualification') ? $request->file('doc_qualification')->store('uploads/documents', 'public') : null;

        $admission = new admission();
        $admission->user_id = $user->id;
        $admission->parent_number = $request->parentMobile;
        $admission->dob = $request->dob;
        $admission->gender = $request->gender;
        $admission->address = $request->address;
        $admission->pincode = $request->pincode;
        $admission->adhar_number = $request->adhar;
        $admission->pan_number = $request->pan;
        $admission->photo = $photo;
        $admission->doc_adhar = $adhar;
        $admission->doc_pan = $pan;
        $admission->room_id = $request->room_id;
        $admission->bed_id = $request->bed_id;
        $admission->doc_qualification = $qualification;
        $admission->admission_date = now();
        $admission->status = 'inactive';
        $admission->created_by = auth()->id();
        $admission->save();

        $bed->status = 'occupy';
        $bed->save();

        return redirect()->back()->with('success', 'Admission successful.');
    }

    public function viewEnquiries(Request $request)
    {
        $query = enquiry::with('user')->orderBy('enquiry_raise', 'desc');

        if ($request->filled('name')) {
            $name = $request->input('name');
            $query->whereHas('user', function ($q) use ($name) {
                $q->where('name', 'like', "%$name%");
            });
        }

        if ($request->filled('role')) {
            $role = $request->input('role');

            if ($role === 'guest') {
                $query->whereNull('user_id');
            } else {
                $query->where('role', $role);
            }
        }

        if ($request->filled('subject')) {
            $subject = $request->input('subject');
            $query->where('subject', 'like', "%$subject%");
        }

        $enquiries = $query->get();

        return view('admin.enquiry', compact('enquiries'));
    }

    public function updateRemarks(Request $request, $id)
    {
        $request->validate([
            'remarks' => 'required|string',
            'enquiry_resolve' => 'nullable|date',
        ]);

        $enquiry = enquiry::findOrFail($id);

        if ($request->enquiry_resolve) {
            $enquiry->enquiry_resolve = $request->enquiry_resolve;
            $enquiry->save();
        }

        enquiry_reply::create([
            'enquiry_id' => $id,
            'user_id' => Auth::id(),
            'reply' => $request->remarks,
        ]);

        return redirect()->route('admin.enquiries')->with('success', 'Reply saved successfully.');
    }

    public function deleteEnquiry($id)
    {
        $enquiry = enquiry::findOrFail($id);
        $enquiry->delete();

        return redirect()->route('admin.enquiries')->with('success', 'Enquiry deleted successfully.');
    }
}
