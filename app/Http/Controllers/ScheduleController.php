<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public static function get($filter = NULL) {
        if ($filter == NULL) {
            return new Schedule;
        }
        return Schedule::where($filter);
    }
    public function add() {
        $myData = UserController::me();
        $relation = $myData->role == "assistant" ? "headships.secretaries" : "secretaries.headships";
        $relations = explode(".", $relation);
        $user = User::where('id', $myData->id)->with($relation)->first();

        return view('user.schedule.add', [
            'myData' => $myData,
            'relation' => $relation,
            'relations' => $relations,
            'user' => $user,
        ]);
    }
    public function store(Request $request) {
        $datetime = $request->date." ".$request->time.":00";

        $saveData = Schedule::create([
            'connect_id' => $request->connect_id,
            'title' => $request->title,
            'date' => $datetime,
            'duration' => $request->duration,
            'place_type' => $request->place_type,
            'place' => $request->place,
            'notes' => $request->notes,
            'status' => "Delay",
            'status_code' => 2
        ]);

        return redirect()->route('user.schedule')->with(['message' => "Schedule baru berhasil ditambahkan"]);
    }
    public function accept($id) {
        $data = Schedule::where('id', $id);
        $accepting = $data->update(['status_code' => 1]);
        $schedule = $data->first();

        $notify = NotifyController::scheduleConfirmation($data, 'Diterima');

        return redirect()->route('user.schedule')->with(['message' => "Schedule ".$schedule->title." telah disetujui"]);
    }
    public function decline($id) {
        $data = Schedule::where('id', $id);
        $accepting = $data->update(['status_code' => 0]);
        $schedule = $data->first();

        $notify = NotifyController::scheduleConfirmation($data, 'Ditolak');

        return redirect()->route('user.schedule')->with(['message' => "Schedule ".$schedule->title." ditolak"]);
    }
}
