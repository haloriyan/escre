<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - {{ env('APP_NAME') }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('fa/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    @yield('head.dependencies')
</head>
<body>
    
<div class="content">
    <div class="logo">
        <img src="{{ asset('images/secrive-nobg.png') }}">
    </div>
    @yield('content')
    <form action="#" class="mt-4 mb-5">
        <div class="bagi bagi-3 rata-tengah">
            <div class="wrap super">
                <img src="{{ asset('images/unair.jpeg') }}" class="lebar-100">
            </div>
        </div>
        <div class="bagi bagi-3 rata-tengah">
            <div class="wrap super">
                <img src="{{ asset('images/vokasi.jpeg') }}" class="lebar-100 mt-3">
            </div>
        </div>
        <div class="bagi bagi-3 rata-tengah">
            <div class="wrap super">
                <img src="{{ asset('images/ap-unair.jpeg') }}" class="lebar-100">
            </div>
        </div>

        <div class="rata-tengah pt-3 pb-3">Created by Secrive Team</div>
    </form>
</div>

<script src="{{ asset('js/base.js') }}"></script>
@yield('javascript')

</body>
</html>