@extends('layouts.auth')

@section('title', "Login Admin")

@section('content')
<form action="{{ route('admin.login') }}" method="POST">
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
    </div>
</form>
@endsection