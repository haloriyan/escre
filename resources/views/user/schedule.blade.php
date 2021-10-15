@extends('layouts.user')

@section('title', "Schedule")

@php
    use Carbon\Carbon;
    Carbon::setLocale('id');
    $relation = $myData->role == "assistant" ? "secretaries" : "headships";
@endphp

@section('content')
@if (count($schedules['today']) == 0)
    <div class="bg-putih rounded bayangan-5 smallPadding">
        <div class="wrap">
            <h2 class="rata-tengah teks-hitam">Tidak ada schedule untuk hari ini</h2>
        </div>
    </div>
@else
    @foreach ($schedules['today'] as $schedule)
        @php
            $datetime = Carbon::parse($schedule->date);
        @endphp
        <div class="bg-putih rounded bayangan-5 mb-3 smallPadding teks-hitam">
            <div class="wrap">
                <div class="bagi lebar-75">
                    <h2 class="teks-hitam">{{ $schedule->title }}</h2>
                    @if ($schedule->place_type == "maps")
                        @php
                            $place = explode("|", $schedule->place);
                        @endphp
                        <div class="mt-2">
                            <a href="{{ $place[1] }}" target="_blank">
                                <i class="fas fa-map-marker mr-1"></i> {{ $place[0] }}
                            </a>
                        </div>
                        <div class="mt-1">
                            <i class="fas fa-user mr-1"></i> {{ $schedule->connection->{$relation}->name }}
                        </div>
                    @endif
                </div>
                <div class="bagi lebar-25">
                    <h2 class="teks-hitam">
                        <i class="fas fa-calendar mr-1"></i>
                        {{ $datetime->isoFormat('D MMMM') }}
                    </h2>
                    <div class="mt-2 teks-transparan">
                        <i class="fas fa-clock mr-1"></i> {{ $datetime->format('H:i') }} - {{ $datetime->addHours($schedule->duration)->format('H:i') }} &nbsp; ({{ $schedule->duration }} jam)
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif

<div style="height: 1px" class="bg-primer mt-3 mb-3 lebar-100"></div>

@if (count($schedules['coming']) == 0)
    <div class="bg-putih rounded bayangan-5 smallPadding">
        <div class="wrap">
            <h2 class="rata-tengah teks-hitam">Tidak ada schedule untuk selanjutnya</h2>
        </div>
    </div>
@else
    @foreach ($schedules['coming'] as $schedule)
        @php
            $datetime = Carbon::parse($schedule->date);
        @endphp
        <div class="bg-putih rounded bayangan-5 mb-3 smallPadding teks-hitam">
            <div class="wrap">
                <div class="bagi lebar-75">
                    <h2 class="teks-hitam">{{ $schedule->title }}</h2>
                    @if ($schedule->place_type == "maps")
                        @php
                            $place = explode("|", $schedule->place);
                        @endphp
                        <div class="mt-1">
                            <a href="{{ $place[1] }}" target="_blank">
                                <i class="fas fa-map-marker mr-1"></i> {{ $place[0] }}
                            </a>
                        </div>
                    @endif
                    <div class="mt-1">
                        <i class="fas fa-user mr-1"></i> {{ $schedule->connection->{$relation}->name }}
                    </div>

                    <div class="mt-3">
                        @if ($schedule->status_code == 2)
                            @if ($myData->role == 'headship')
                                <a href="{{ route('user.schedule.accept', $schedule->id) }}" class="bg-hijau-transparan rounded p-1 pl-2 pr-2 mr-2">
                                    <i class="fas fa-check"></i>
                                </a>
                                <a href="{{ route('user.schedule.decline', $schedule->id) }}" class="bg-merah-transparan rounded p-1 pl-2 pr-2">
                                    <i class="fas fa-times"></i>
                                </a>
                            @else
                                <span class="bg-kuning-transparan rounded p-1 pl-2 pr-2">Delay</span>
                            @endif
                        @else
                            @displayStatus($schedule->status_code)
                        @endif
                    </div>
                </div>
                <div class="bagi lebar-25">
                    <h2 class="teks-hitam">
                        <i class="fas fa-calendar mr-1"></i>
                        {{ $datetime->isoFormat('D MMMM') }}
                    </h2>
                    <div class="mt-2 teks-transparan">
                        <i class="fas fa-clock mr-1"></i> {{ $datetime->format('H:i') }} - {{ $datetime->addHours($schedule->duration)->format('H:i') }} &nbsp; ({{ $schedule->duration }} jam)
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif
@endsection