@extends('layouts.user')

@section('title', "Notification")

@php
    use Carbon\Carbon;
    Carbon::setLocale('id');
@endphp
    
@section('content')
<div class="bg-putih rounded bayangan-5 smallPadding">
    <div class="wrap">
        @if ($notifications == "" || $notifications->count() == 0)
            <h3 class="rata-tengah">Tidak ada data</h3>
        @else
            @foreach ($notifications as $item)
                <div class="border-bottom p-1">
                    <a href="{{ $item->action }}">
                        <div>{{ $item->body }}</div>
                        <div class="teks-kecil teks-transparan mt-1">{{ Carbon::parse($item->created_at)->diffForHumans() }}</div>
                    </a>
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection