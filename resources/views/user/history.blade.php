@extends('layouts.user')

@section('title', "History")

@php
    use Carbon\Carbon;
    Carbon::setLocale('id');
    $relation = $myData->role == "assistant" ? "secretaries" : "headships";
@endphp

@section('content')
@if ($schedules->count() == 0)
    <div class="bg-putih rounded bayangan-5 smallPadding">
        <div class="wrap">
            <h2 class="teks-hitam rata-tengah">Tidak ada data</h2>
        </div>
    </div>
@else
    @foreach ($schedules as $item)
    <div class="bg-putih rounded bayangan-5 smallPadding mb-3">
        <div class="wrap">
            <div class="bagi lebar-70">
                <h2 class="mt-0">{{ $item->title }}</h2>
                @if ($item->place_type == "maps")
                    @php
                        $place = explode("|", $item->place);
                    @endphp
                    <div class="mt-2">
                        <a href="{{ $place[1] }}" target="_blank">
                            <i class="fas fa-map-marker mr-1"></i> {{ $place[0] }}
                        </a>
                    </div>
                    <div class="mt-1">
                        <i class="fas fa-user mr-1"></i> {{ $item->connection->{$relation}->name }}
                    </div>
                @endif
            </div>
            <div class="bagi lebar-30 rata-kanan">
                <h2 class="mt-0 teks-hitam">
                    <i class="fas fa-calendar mr-1"></i>
                    {{ Carbon::parse($item->date)->isoFormat('D MMMM') }}
                </h2>
            </div>
        </div>
    </div>
    @endforeach

    {{ $schedules->links('pagination::bootstrap-4') }}
@endif
@endsection