<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('user.loginPage');
});
Route::get('cron', "UserController@runCron");

Route::get('push', "UserController@push");

Route::get('login', "UserController@loginPage")->name("user.loginPage");
Route::post('login', "UserController@login")->name("user.login");
Route::get('register', "UserController@registerPage")->name("user.registerPage");
Route::post('register', "UserController@register")->name("user.register");
Route::get('logout', "UserController@logout")->name("user.logout");
Route::get('profile', "UserController@profile")->name("user.profile");
Route::post('profile', "UserController@updateProfile")->name("user.profile.update");

Route::get('home', "UserController@home")->name("user.home")->middleware('User');
Route::group(['prefix' => "schedule"], function () {
    Route::get('add', "ScheduleController@add")->name("user.schedule.add")->middleware('User');
    Route::post('store', "ScheduleController@store")->name("user.schedule.store")->middleware('User');
    Route::get('{id}/accept', "ScheduleController@accept")->name("user.schedule.accept")->middleware('User');
    Route::get('{id}/decline', "ScheduleController@decline")->name("user.schedule.decline")->middleware('User');
    Route::get('/', "UserController@schedule")->name("user.schedule")->middleware('User');
});
Route::get('history', "UserController@history")->name("user.history")->middleware('User');

Route::group(['prefix' => "connect"], function () {
    Route::post('add', "ConnectController@add")->name('user.connect.add')->middleware('User');
    Route::get('/', "UserController@connect")->name("user.connect")->middleware('User');
});

Route::group(['prefix' => "admin"], function () {
    Route::get('login', "AdminController@loginPage")->name("admin.loginPage");
    Route::post('login', "AdminController@login")->name("admin.login");
    Route::get('logout', "AdminController@logout")->name("admin.logout");

    Route::get('dashboard', "AdminController@dashboard")->name("admin.dashboard")->middleware('Admin');
    Route::get('user', "AdminController@user")->name("admin.user")->middleware('Admin');
    Route::get('schedule', "AdminController@schedule")->name("admin.schedule")->middleware('Admin');
    
    Route::get('/', function () {
        return redirect()->route('admin.loginPage');
    });
});