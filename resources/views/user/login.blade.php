@extends('layouts.auth')

@section('title', "Login")

@section('content')
<form action="{{ route('user.login') }}" method="POST">
    {{ csrf_field() }}
    <input type="hidden" name="r" value="{{ $request->r }}">
    <div class="wrap super">
        @if ($message != "")
            <div class="bg-hijau-transparan rounded p-2 mb-3">
                {{ $message }}
            </div>
        @endif
        @if ($errors->count() != 0)
            @foreach ($errors->all() as $err)
                <div class="bg-merah-transparan rounded p-2 mb-3">
                    {{ $err }}
                </div>
            @endforeach
        @endif

        <div class="mt-2">Email :</div>
        <input type="email" class="box" name="email" required>
        <div class="mt-2">Password :</div>
        <input type="password" class="box" name="password" required>

        <button class="lebar-100 mb-3 mt-3 primer">Login</button>
        
        <div class="bagi bagi-2">
            belum punya akun? <a href="{{ route('user.registerPage') }}">register</a>
        </div>
        <div class="bagi bagi-2 rata-kanan">
            <a href="#">Lupa password?</a>
        </div>
    </div>
</form>
@endsection