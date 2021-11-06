<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public static function me() {
        return Auth::guard('admin')->user();
    }
    public function loginPage(Request $request) {
        $message = Session::get('message');

        return view('admin.login', [
            'message' => $message,
            'request' => $request,
        ]);
    }
    public function login(Request $request) {
        $loggingIn = Auth::guard('admin')->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if (!$loggingIn) {
            return redirect()->route('admin.loginPage')->withErrors(['Kombinasi email dan kata sandi tidak tepat']);
        }

        return redirect()->route('admin.dashboard');
    }
    public function logout() {
        $loggingOut = Auth::guard('admin')->logout();
        return redirect()->route('admin.loginPage')->with(['message' => "Berhasil logout"]);
    }
    public function dashboard() {
        $myData = self::me();
        $message = Session::get('message');
        
        return view('admin.dashboard', [
            'myData' => $myData,
            'message' => $message
        ]);
    }
    public function user(Request $request) {
        $myData = self::me();
        $message = Session::get('message');
        
        $filter = [];
        if ($request->name != "") {
            $filter[] = ['name', "LIKE", "%".$request->name."%"];
        }
        if ($request->role != "") {
            $filter[] = ['role', $request->role];
        }

        $users = UserController::get($filter)->paginate(25);
        
        return view('admin.user', [
            'myData' => $myData,
            'users' => $users,
            'request' => $request,
            'message' => $message
        ]);
    }
    public function updateUser(Request $request) {
        $id = $request->id;
        $data = UserController::get([['id', $id]]);
        $user = $data->first();
        $updateData = $data->update([
            'premium_until' => $request->premium_until
        ]);

        return redirect()->route('admin.user')->with(['message' => "Data user ".$user->name." berhasil diubah"]);
    }
    public function schedule() {
        $myData = self::me();
        $message = Session::get('message');
        $schedules = ScheduleController::get()->orderBy('created_at', 'DESC')->paginate(25);

        return view('admin.schedule', [
            'myData' => $myData,
            'schedules' => $schedules,
            'message' => $message,
        ]);
    }
}
