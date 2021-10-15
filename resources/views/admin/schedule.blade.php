@extends('layouts.admin')

@section('title', "Schedules")
    
@php
    use Carbon\Carbon;
    Carbon::setLocale('id');
@endphp

@section('content')
<div class="bg-putih rounded bayangan-5 smallPadding">
    <div class="wrap">
        <table>
            <thead>
                <thead>
                    <th>Kegiatan</th>
                    <th><i class="fas fa-users"></i></th>
                    <th><i class="fas fa-calendar"></i></th>
                    <th>Status</th>
                </thead>
            </thead>
            <tbody>
                @foreach ($schedules as $schedule)
                    @php
                        $date = Carbon::parse($schedule->date);
                    @endphp
                    <tr>
                        <td>
                            <div class="teks-besar">{{ $schedule->title }}</div>
                            <div class="mt-1 teks-kecil">
                                @if ($schedule->place_type == 'maps')
                                    @php
                                        $place = explode("|", $schedule->place);
                                    @endphp
                                    <a href="{{ $place[1] }}" target="_blank">
                                        <i class="fas fa-map-marker mr-1"></i>
                                        {{ $place[0] }}
                                    </a>
                                @else
                                    <a href="{{ $schedule->place }}">Zoom</a>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="bagi mr-1">
                                {{ $schedule->connection->headships->name }}<br />
                                {{ ucwords($schedule->connection->headships->role) }}
                            </div>
                            -
                            <div class="bagi ml-1">
                                {{ $schedule->connection->secretaries->name }}<br />
                                {{ ucwords($schedule->connection->secretaries->role) }}
                            </div>
                        </td>
                        <td>
                            {{ $date->isoFormat('D MMMM YYYY') }} <br />
                            {{ $date->format('H:i') }}
                        </td>
                        <td>
                            @displayStatus($schedule->status_code)
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3">
            {{ $schedules->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection