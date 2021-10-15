<?php

namespace App\Http\Middleware;

use Auth;
use Route;
use Closure;
use Illuminate\Http\Request;

class User
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $myData = Auth::user();
        if ($myData == "") {
            $currentRoute = Route::currentRouteName();
            return redirect()->route('user.loginPage', ['r' => $currentRoute])->withErrors(['Anda harus login']);
        }
        return $next($request);
    }
}
