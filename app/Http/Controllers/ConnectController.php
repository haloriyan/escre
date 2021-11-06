<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Connect;
use Illuminate\Http\Request;

class ConnectController extends Controller
{
    public static function get($filter = NULL) {
        if ($filter == NULL) {
            return new Connect;
        }
        return Connect::where($filter);
    }
    public function add(Request $request) {
        $userID = $request->userID;
        $myData = UserController::me();
        $user = User::find($userID);
        $whosAdded = $request->whosAdding;

        if (!$myData->is_premium) {
            $dateNow = Carbon::now()->format('Y-m-d');
            $relation = $myData->role == "assistant" ? "secretary_id" : "headship_id";
            $connects = ConnectController::get([[$relation, $myData->id]])->get('id');
            if ($connects->count() >= config('premium')['max_connects']) {
                return redirect()->route('user.connect', ['username' => $user->username])->withErrors([
                    'Anda tidak bisa menambahkan koneksi baru. Tingkatkan ke premium untuk memiliki koneksi tanpa batas'
                ]);
            }
        }

        if ($whosAdded == "assistant") {
            $toSave['secretary_id'] = $myData->id;
            $toSave['headship_id'] = $userID;
        } else {
            $toSave['secretary_id'] = $userID;
            $toSave['headship_id'] = $myData->id;
        }

        $saveData = Connect::create($toSave);

        return redirect()->route('user.connect')->with(['message' => $user->name." berhasil ditambahkan sebagai koneksi"]);
    }
}
