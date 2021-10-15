<?php

namespace App\Http\Controllers;

use Log;
use Auth;
use Str;
use Session;
use Artisan;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public static function me() {
        $myData = Auth::user();
        $name = explode(" ", $myData->name);
        $myData->first_name = $name[0];

        return $myData;
    }
    public static function get($filter = NULL) {
        if ($filter == NULL) {
            return new User;
        }
        return User::where($filter);
    }
    public function loginPage(Request $request) {
        $message = Session::get('message');
        return view('user.login', [
            'message' => $message,
            'request' => $request
        ]);
    }
    public function registerPage() {
        $message = Session::get('message');
        return view('user.register', [
            'message' => $message
        ]);
    }
    public function login(Request $request) {
        $loggingIn = Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if (!$loggingIn) {
            return redirect()->route('user.loginPage', ['r' => $request->r])->withErrors(['Kombinasi email dan kata sandi tidak tepat']);
        }

        $redirectTo = $request->r != "" ? $request->r : "user.home";

        return redirect()->route($redirectTo);
    }
    public function register(Request $request) {
        $username = Str::random(6);
        $saveData = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'username' => $username,
            'role' => $request->role,
            'password' => bcrypt($request->password),
            'is_user_verified' => 1
        ]);

        return redirect()->route('user.loginPage')->with(['message' => "Berhasil mendaftar. Silahkan login"]);
    }
    public function logout() {
        $loggingOut = Auth::logout();
        return redirect()->route('user.loginPage')->with(['message' => "Berhasil logout"]);
    }
    public function getMySchedules($query) {
        global $myData;
        $myData = self::me();

        if ($myData->role == "assistant") {
            $schedules = $query->whereHas('connection', function ($query) {
                global $myData;
                return $query->where('secretary_id', $myData->id);
            });
        } else {
            $schedules = $query->whereHas('connection', function ($query) {
                global $myData;
                return $query->where('headship_id', $myData->id);
            });
        }
        
        return $schedules;
    }
    public function home() {
        global $myData;
        $myData = self::me();
        $dateNow = date('Y-m-d');
        $query = ScheduleController::get([['date', 'LIKE', "%".$dateNow."%"]]);
        $schedules = $this->getMySchedules($query)->get('id');

        return view('user.home', [
            'myData' => $myData,
            'schedules' => $schedules,
        ]);
    }
    public function schedule() {
        global $myData;
        $myData = self::me();
        $dateNow = date('Y-m-d H:i:s');

        $query = ScheduleController::get([
            ['date', '>=', $dateNow],
        ]);
        $schedulesRaw = $this->getMySchedules($query)
        ->orderBy('created_at', 'DESC')->take(20)
        ->get();

        // Filter today
        $schedules['today'] = [];
        $schedules['coming'] = [];
        
        foreach ($schedulesRaw as $item) {
            $date = explode(" ", $item->date);
            if ($date[0] == date('Y-m-d')) {
                $schedules['today'][] = $item;
            } else {
                $schedules['coming'][] = $item;
            }
        }

        return view('user.schedule', [
            'myData' => $myData,
            'schedules' => $schedules
        ]);
    }
    public function history() {
        $myData = self::me();
        $dateNow = date('Y-m-d H:i:s');
        $query = ScheduleController::get([['date', '<', $dateNow]]);
        $schedules = $this->getMySchedules($query)
        ->orderBy('created_at', 'DESC')
        ->paginate(20);

        return view('user.history', [
            'myData' => $myData,
            'schedules' => $schedules
        ]);
    }
    public function connect(Request $request) {
        $myData = self::me();
        $relation = $myData->role == "assistant" ? "headships.secretaries" : "secretaries.headships";
        $user = User::where('id', $myData->id)->with($relation)->first();

        $search = [];
        if ($request->username != "") {
            $search = User::where('username', $request->username)->first();
        }

        return view('user.connect', [
            'myData' => $myData,
            'user' => $user,
            'request' => $request,
            'search' => $search,
            'relation' => $relation,
        ]);
    }
    public function profile() {
        $myData = self::me();
        $message = Session::get('message');

        return view('user.profile', [
            'myData' => $myData,
            'message' => $message
        ]);
    }
    public function updateProfile(Request $request) {
        $myData = self::me();
        $toUpdate = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoFileName = $photo->getClientOriginalName();
            $toUpdate['photo'] = $photoFileName;
            if ($myData->photo != null) {
                $deleteOldPhoto = Storage::delete('public/user_photos/'.$myData->photo);
            }
            $photo->storeAs('public/user_photos/', $photoFileName);
        }

        $data = User::where('id', $myData->id);
        $updateData = $data->update($toUpdate);

        return redirect()->route('user.profile')->with(['message' => "Profil berhasil diubah"]);
    }
    public function runCron() {
        Log::info('behrasil');
    }
    public function push() {
        $myData = self::me();
        return view('user.push', [
            'myData' => $myData
        ]);
    }
}
