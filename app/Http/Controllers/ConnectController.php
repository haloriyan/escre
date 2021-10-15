<?php

namespace App\Http\Controllers;

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
        $whosAdding = $request->whosAdding;

        if ($whosAdding == "assistant") {
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
