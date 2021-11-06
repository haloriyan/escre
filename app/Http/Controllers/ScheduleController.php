<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
        $canCreateSchedule = true;

        if (!$myData->is_premium) {
            $dateNow = Carbon::now()->format('Y-m-d');
            $query = ScheduleController::get([
                ['date', '>=', $dateNow],
            ]);
            $schedules = UserController::getMySchedules($query)
            ->orderBy('created_at', 'DESC')->take(20)
            ->get('id');

            if ($schedules->count() >= config('premium')['max_schedules']) {
                $canCreateSchedule = false;
            }
        }

        return view('user.schedule.add', [
            'myData' => $myData,
            'canCreateSchedule' => $canCreateSchedule,
            'relation' => $relation,
            'relations' => $relations,
            'user' => $user,
        ]);
    }
    public function store(Request $request) {
        $myData = UserController::me();
        $datetime = $request->date." ".$request->time.":00";

        // $connectID = $request->connect_id;
        // $connection = ConnectController::get([['id', $connectID]])->first();
        // return $connection->secretaries;
        $status = "Delay";
        $statusCode = 2;

        if ($myData->role != "assistant") {
            $status = "Diterima";
            $statusCode = 1;
        }

        $saveData = Schedule::create([
            'connect_id' => $request->connect_id,
            'title' => $request->title,
            'date' => $datetime,
            'duration' => $request->duration,
            'place_type' => $request->place_type,
            'place' => $request->place,
            'notes' => $request->notes,
            'status' => $status,
            'status_code' => $statusCode
        ]);
        
        $notify = NotifyController::newSchedule($saveData, $request->connect_id, $myData->role);

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
