@extends('layouts.user')

@section('title', "Home")

@section('content')
<div class="bg-putih rounded bayangan-5 smallPadding">
    <div class="wrap">
        <h2>Selamat Datang di {{ env('APP_NAME') }},</h2>
        <p>Ada agenda apa hari ini?</p>
    </div>
</div>

<div class="bagi bagi-2 mt-4">
    <div class="wrap">
        <div class="bg-putih rounded bayangan-5 smallPadding">
            <div class="wrap super">
                <h2>{{ $schedules->count() }} <span>schedule</span></h2>
                <div>hari ini</div>
            </div>
        </div>
    </div>
</div>
<div class="bagi bagi-2 mt-4">
    <div class="wrap">
        <div class="bg-putih rounded bayangan-5 smallPadding">
            <div class="wrap super">
                <h2>{{ $connects->count() }} <span>connects</span></h2>
                <div>total</div>
            </div>
        </div>
    </div>
</div>
@endsection