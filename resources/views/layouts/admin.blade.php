<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - {{ env('APP_NAME') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('fa/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @yield('head.dependencies')
</head>
<body>
    
@php
    $currentRoute = Route::current();
    $routeParameters = json_decode(json_encode($currentRoute->parameters), FALSE);
    $prefix = $currentRoute->getPrefix();
    $prefixes = explode("/", $prefix);
@endphp

<div class="main-navigation">
    <a href="#">
        <div class="header smallPadding rata-tengah">
            <div class="wrap super">
                <div class="icon mb-1">{{ $myData->initial }}</div>
                <h2>{{ $myData->name }}</h2>
            </div>
        </div>
    </a>
    <ul>
        <a href="{{ route('admin.dashboard') }}">
            <li class="{{ $currentRoute->uri == 'admin/dashboard' ? 'active' : '' }}">
                <div class="icon"><i class="fas fa-home"></i></div>
                <div class="text">Dashboard</div>
            </li>
        </a>
        <a href="{{ route('admin.user') }}">
            <li class="{{ $currentRoute->uri == 'admin/user' ? 'active' : '' }}">
                <div class="icon"><i class="fas fa-users"></i></div>
                <div class="text">Users</div>
            </li>
        </a>
        <a href="{{ route('admin.schedule') }}">
            <li class="{{ $currentRoute->uri == 'admin/schedule' ? 'active' : '' }}">
                <div class="icon"><i class="fas fa-calendar"></i></div>
                <div class="text">Schedules</div>
            </li>
        </a>
        {{-- <a href="#">
            <li class="{{ $prefixes[0] == 'admin' && $prefixes[1] == 'copywriting' ? 'active' : '' }}">
                <div class="icon"><i class="fas fa-edit"></i></div>
                <div class="text">Copywriting
                    <i class="fas fa-angle-down"></i>
                </div>
                <ul>
                    @foreach ($myData->copywritings as $writing)
                        <a href="{{ route('admin.copywriting.edit', $writing->item_code) }}">
                            <li class="{{ $prefixes[1] == "copywriting" && $routeParameters->code == $writing->item_code ? 'active' : '' }}">
                                <div class="text">{{ ucwords($writing->item_code) }}</div>
                            </li>
                        </a>
                    @endforeach
                </ul>
            </li>
        </a> --}}
        {{-- <a href="{{ route('admin.copywriting') }}">
            <li class="{{ $currentRoute->uri == 'admin/copywriting' ? 'active' : '' }}">
                <div class="icon"><i class="fas fa-edit"></i></div>
                <div class="text">Copywriting</div>
            </li>
        </a> --}}
        <a href="{{ route('admin.logout') }}">
            <li class="{{ $currentRoute->uri == 'admin/logout' ? 'active' : '' }}">
                <div class="icon"><i class="fas fa-sign-out-alt"></i></div>
                <div class="text">Logout</div>
            </li>
        </a>
    </ul>
</div>

<header class="main">
    <h1>@yield('header.beforeTitle') @yield('title')</h1>
    <div class="action">
        @yield('header.action')
    </div>
</header>

<div class="content">
    @yield('content')
    <div class="tinggi-70"></div>
</div>

<script src="{{ asset('js/base.js') }}"></script>
@yield('javascript')

</body>
</html>