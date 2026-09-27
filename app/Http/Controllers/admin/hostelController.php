<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admission;
use App\Models\Deleted_bed;
use App\Models\hostel_beds;
use App\Models\hostel_room;
use App\Models\room_allocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class hostelController extends Controller
{

    public function roomSubmit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'room' => 'required',
            'bed' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->has('room_number')) {

            $room = hostel_room::findOrFail($request->room_number);
            $room->room_number = $request->room;
            $room->total_bed = $request->bed;
            $room->save();

            return redirect()->back()->with('success', 'Room updated successfully.');
        } else {

            $room = new hostel_room();
            $room->user_id = Auth::id();
            $room->room_number = $request->room;
            $room->total_bed = $request->bed;
            $room->save();


            for ($i = 1; $i <= $request->bed; $i++) {
                hostel_beds::create([
                    'room_id' => $room->id,
                    'bed_number' => $i,
                    'total_bed' => $request->bed,
                    'status' => 'empty',
                ]);
            }

            return redirect()->back()->with('success', 'New Room Added successfully with beds.');
        }
    }

    public function roomAllocationView(Request $request)
    {
        $students = admission::with('user')->get();
        $rooms = hostel_room::with('beds')->get();

        $filterStudent = $request->student_id;
        $filterRoom = $request->room_id;

        $bedsQuery = hostel_beds::with(['room', 'allocation.admission.user']);

        if ($filterStudent) {
            $bedsQuery->whereHas('allocation', function ($q) use ($filterStudent) {
                $q->where('admission_id', $filterStudent);
            });
        }

        $beds = $bedsQuery->get();

        return view('admin.hostel.allocate_room', compact('students', 'rooms', 'beds', 'filterStudent'));
    }

    public function allocateRoom(Request $request)
    {
        $request->validate([
            'bed_id' => 'required|exists:hostel_beds,id',
            'admission_id' => 'required|exists:admission,id',
        ]);

        $bed = hostel_beds::find($request->bed_id);

        if ($bed->status === 'occupy') {
            return back()->withErrors('Bed is already occupied.');
        }

        $alreadyAllocated = room_allocation::where('admission_id', $request->admission_id)
            ->where('status', 'active')
            ->exists();

        if ($alreadyAllocated) {
            return back()->withErrors('This student already has a bed allocated.');
        }

        room_allocation::create([
            'user_id' => Auth::id(),
            'admission_id' => $request->admission_id,
            'bed_id' => $bed->id,
            'allocation_date' => now(),
            'status' => 'active',
        ]);

        $bed->status = 'occupy';
        $bed->save();

        return back()->with('success', 'Bed successfully allocated.');
    }

    public function editAllocation(Request $request)
    {
        $request->validate([
            'bed_id' => 'required|exists:hostel_beds,id',
            'admission_id' => 'required|exists:admission,id',
        ]);

        room_allocation::updateOrCreate(
            ['bed_id' => $request->bed_id],
            [
                'user_id' => Auth::id(),
                'admission_id' => $request->admission_id,
                'allocation_date' => now(),
                'status' => 'active',
            ]
        );

        hostel_beds::where('id', $request->bed_id)->update(['status' => 'occupy']);
        return back()->with('success', 'Bed re-allocated successfully.');
    }

    public function removeAllocation(Request $request)
    {
        $request->validate([
            'bed_id' => 'required|exists:hostel_beds,id',
        ]);

        $bed = hostel_beds::findOrFail($request->bed_id);


        room_allocation::where('bed_id', $bed->id)->update(['status' => 'inactive']);


        $bed->status = 'empty';
        $bed->save();

        return back()->with('success', 'Bed allocation removed.');
    }

    public function deleteBed(Request $request)
    {
        $bed = hostel_beds::where('status', 'empty')->find($request->bed_id);

        if (!$bed) {
            return back()->with('error', 'Only empty beds can be deleted or bed not found.');
        }



        Deleted_bed::create([
            'bed_id' => $bed->id,
            'room_id' => $bed->room_id,
            'bed_number' => $bed->bed_number,
            'deleted_at' => now(),
        ]);

        $bed->delete();

        return back()->with('success', 'Bed moved to deleted list.');
    }

    public function restoreBed($id)
    {
        $deleted = DB::table('deleted_beds')->where('id', $id)->first();

        if (!$deleted) {
            return back()->withErrors('Deleted bed not found.');
        }

        $roomExists = DB::table('hostel_rooms')->where('id', $deleted->room_id)->exists();
        if (!$roomExists) {
            return back()->withErrors('Room does not exist.');
        }

        $bedExists = DB::table('hostel_beds')
            ->where('room_id', $deleted->room_id)
            ->where('bed_number', $deleted->bed_number)
            ->exists();


        if ($bedExists) {
            return back()->withErrors('This bed number already exists in the room.');
        }

        $room = DB::table('hostel_rooms')->where('id', $deleted->room_id)->first();

        hostel_beds::create([
            'room_id' => $deleted->room_id,
            'bed_number' => $deleted->bed_number,
            'total_bed' => $room->total_bed ?? 0,
            'status' => 'empty',
        ]);

        DB::table('deleted_beds')->where('id', $id)->delete();

        return back()->with('success', 'Bed restored to room successfully.');
    }

    public function permanentDelete($id)
    {
        DB::table('deleted_beds')->where('id', $id)->update([
            'deleted_at' => null,
        ]);

        return back()->with('success', 'Bed permanently deleted.');
    }

    public function showDeletedItems()
    {
        $deletedBeds = DB::table('deleted_beds')
            ->whereNotNull('deleted_at')
            ->get();

        $deletedRooms = DB::table('deleted_rooms')
            ->whereNotNull('deleted_at')
            ->get();



        return view('admin.hostel.deleted_item', compact('deletedBeds', 'deletedRooms'));
    }

    public function delete(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:hostel_rooms,id',
        ]);

        $room = hostel_room::with('beds')->findOrFail($request->room_id);

        if ($room->beds->where('status', '!=', 'empty')->count() > 0) {
            return back()->withErrors('Cannot delete room with occupied beds.');
        }

        DB::table('deleted_rooms')->insert([
            'room_id' => $room->id,
            'user_id' => $room->user_id,
            'room_number' => $room->room_number,
            'total_bed' => $room->beds->count(),
            'deleted_at' => now(),
        ]);

        hostel_beds::where('room_id', $room->id)->delete();

        $room->delete();

        return back()->with('success', 'Room deleted and moved to deleted_rooms.');
    }

    public function restore($id)
    {
        $deleted = DB::table('deleted_rooms')->where('id', $id)->first();

        if (!$deleted) {
            return back()->withErrors('Deleted room not found.');
        }

        hostel_room::create([
            'room_number' => $deleted->room_number,
            'total_bed' => $deleted->total_bed,
            'user_id' => $deleted->user_id,
        ]);

        DB::table('deleted_rooms')->where('id', $id)->delete();

        return back()->with('success', 'Room restored successfully.');
    }

    public function roomPermanentDelete($id)
    {
        DB::table('deleted_rooms')->where('id', $id)->update([
            'deleted_at' => null,
        ]);

        return back()->with('success', 'Room permanently deleted.');
    }

    public function addBedForm(Request $request, $roomId)
    {
        $request->validate([
            'bed_number' => 'required|string|max:255',
        ]);

        $room = hostel_room::findOrFail($roomId);

        $bedNumber = $request->input('bed_number');

        $exists = $room->beds()->where('bed_number', $bedNumber)->exists();

        if ($exists) {
            return redirect()->back()->withErrors("Bed number $bedNumber already exists in Room {$room->room_number}.");
        }

        $currentBedCount = $room->beds()->count();

        hostel_beds::create([
            'room_id' => $room->id,
            'bed_number' => $bedNumber,
            'status' => 'empty',
            'total_bed' => $currentBedCount + 1,
        ]);

        return redirect()->back()->with('success', "Empty bed $bedNumber added to Room {$room->room_number}.");
    }

    public function storeBed(Request $request, $roomId)
    {
        $request->validate([
            'bed_number' => 'required|unique:hostel_beds,bed_number,NULL,id,room_id,' . $roomId,
        ]);

        hostel_beds::create([
            'room_id' => $roomId,
            'bed_number' => $request->bed_number,
            'status' => 'empty',
        ]);

        return redirect()->back()->with('success', 'Bed added successfully.');
    }
}
