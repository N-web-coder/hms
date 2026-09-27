<?php

namespace App\Http\Controllers\staff;

use App\Http\Controllers\Controller;
use App\Models\attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class attendanceController extends Controller
{

    public function staffDashboard()
    {
        $attendances = Attendance::where('user_id', Auth::id())->get();

        $todayAttendance = $attendances->where('date', date('Y-m-d'));

        $attendanceIn = $todayAttendance->whereNotNull('time_in')->min('time_in');

        $attendanceOut = $todayAttendance->whereNotNull('time_out')->max('time_out');

        $todayStatus = $todayAttendance->first()?->status;

        return view('staff.index', compact('attendances','attendanceIn', 'attendanceOut', 'todayStatus'));
    }

    public function index()
    {
        $staff = Auth::user();
        $today = date('Y-m-d');

        $alreadyMarked = Attendance::where('user_id', $staff->id)
            ->where('date', $today)
            ->exists();

        return view('staff.attendance', compact('staff', 'alreadyMarked'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $today = date('Y-m-d');


        $alreadyMarked = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->exists();

        if ($alreadyMarked) {
            return redirect()->back()->with('error', 'You have already marked your attendance today.');
        }


        $data = $request->input("attendance.{$user->id}");


        Attendance::create([
            'user_id' => $user->id,
            'status' => $data['status'],
            'time_in' => $data['time_in'],
            'time_out' => $data['time_out'],
            'date' => $today
        ]);

        return redirect()->back()->with('success', 'Attendance marked successfully.');
    }

    public function attendanceHistory()
    {
        $user = Auth::user();

        if ($user->type !== 'staff') {
            abort(403, 'Unauthorized');
        }

        $attendances = Attendance::where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->paginate(20);

        return view('staff.attendance_history', compact('attendances'));
    }
}
